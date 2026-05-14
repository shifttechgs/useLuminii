using Asp.Versioning;
using LuminiiApi.Features.ContactForms.Models.RequestModels;
using LuminiiApi.Features.ContactForms.Services.Interfaces;
using Microsoft.AspNetCore.Mvc;

namespace LuminiiApi.Features.ContactForms.Controllers;

[ApiController]
[ApiVersion(1)]
[Route("api/v{v:apiVersion}/[controller]")]
public class ContactFormController : ControllerBase
{
    private readonly IContactFormService _contactFormService;

    public ContactFormController(IContactFormService contactFormService)
    {
        _contactFormService = contactFormService;
    }

    /// <summary>
    /// Submit a new contact form from the website
    /// </summary>
    /// <param name="contactFormDto">Contact form data</param>
    /// <param name="cancellationToken">Cancellation token</param>
    /// <returns>Created contact form</returns>
    [HttpPost("submitContactForm")]
    [ProducesResponseType(StatusCodes.Status200OK)]
    [ProducesResponseType(StatusCodes.Status400BadRequest)]
    public async Task<IActionResult> SubmitContactForm(
        [FromBody] ContactFormDto contactFormDto,
        CancellationToken cancellationToken)
    {
        if (!ModelState.IsValid)
            return BadRequest(new { Errors = ModelState.Values.SelectMany(v => v.Errors.Select(e => e.ErrorMessage)) });

        var result = await _contactFormService.SubmitContactForm(contactFormDto, cancellationToken);

        return result.Succeeded
            ? Ok(new { Success = true, Data = result.Value, Message = "Contact form submitted successfully. We'll respond within 24 hours." })
            : BadRequest(new { Success = false, Errors = result.Errors });
    }

    /// <summary>
    /// Get all contact forms (Admin endpoint)
    /// </summary>
    /// <param name="cancellationToken">Cancellation token</param>
    /// <returns>List of all contact forms</returns>
    [HttpGet("getAllContactForms")]
    [ProducesResponseType(StatusCodes.Status200OK)]
    public async Task<IActionResult> GetAllContactForms(CancellationToken cancellationToken)
    {
        var contactForms = await _contactFormService.GetAllContactForms(cancellationToken);
        return Ok(new { Success = true, Data = contactForms, Count = contactForms.Count });
    }

    /// <summary>
    /// Get contact forms by status (Admin endpoint)
    /// </summary>
    /// <param name="status">Status filter (New, Contacted, Qualified, Converted, Closed)</param>
    /// <param name="cancellationToken">Cancellation token</param>
    /// <returns>Filtered list of contact forms</returns>
    [HttpGet("getContactFormsByStatus/{status}")]
    [ProducesResponseType(StatusCodes.Status200OK)]
    public async Task<IActionResult> GetContactFormsByStatus(
        string status,
        CancellationToken cancellationToken)
    {
        var contactForms = await _contactFormService.GetContactFormsByStatus(status, cancellationToken);
        return Ok(new { Success = true, Data = contactForms, Count = contactForms.Count });
    }

    /// <summary>
    /// Get a specific contact form by ID (Admin endpoint)
    /// </summary>
    /// <param name="contactId">Contact form ID</param>
    /// <param name="cancellationToken">Cancellation token</param>
    /// <returns>Contact form details</returns>
    [HttpGet("getContactForm/{contactId}")]
    [ProducesResponseType(StatusCodes.Status200OK)]
    [ProducesResponseType(StatusCodes.Status404NotFound)]
    public async Task<IActionResult> GetContactFormById(
        string contactId,
        CancellationToken cancellationToken)
    {
        var contactForm = await _contactFormService.GetContactFormById(contactId, cancellationToken);

        return contactForm != null
            ? Ok(new { Success = true, Data = contactForm })
            : NotFound(new { Success = false, Message = "Contact form not found" });
    }

    /// <summary>
    /// Update a contact form (Admin endpoint)
    /// </summary>
    /// <param name="contactId">Contact form ID</param>
    /// <param name="contactFormDto">Updated contact form data</param>
    /// <param name="cancellationToken">Cancellation token</param>
    /// <returns>Updated contact form</returns>
    [HttpPut("updateContactForm/{contactId}")]
    [ProducesResponseType(StatusCodes.Status200OK)]
    [ProducesResponseType(StatusCodes.Status400BadRequest)]
    [ProducesResponseType(StatusCodes.Status404NotFound)]
    public async Task<IActionResult> UpdateContactForm(
        string contactId,
        [FromBody] ContactFormDto contactFormDto,
        CancellationToken cancellationToken)
    {
        if (!ModelState.IsValid)
            return BadRequest(new { Errors = ModelState.Values.SelectMany(v => v.Errors.Select(e => e.ErrorMessage)) });

        var result = await _contactFormService.UpdateContactForm(contactId, contactFormDto, cancellationToken);

        return result.Succeeded
            ? Ok(new { Success = true, Data = result.Value, Message = "Contact form updated successfully" })
            : BadRequest(new { Success = false, Errors = result.Errors });
    }

    /// <summary>
    /// Mark a contact form as read (Admin endpoint)
    /// </summary>
    /// <param name="contactId">Contact form ID</param>
    /// <param name="cancellationToken">Cancellation token</param>
    /// <returns>Success status</returns>
    [HttpPatch("markAsRead/{contactId}")]
    [ProducesResponseType(StatusCodes.Status200OK)]
    [ProducesResponseType(StatusCodes.Status400BadRequest)]
    public async Task<IActionResult> MarkAsRead(
        string contactId,
        CancellationToken cancellationToken)
    {
        var result = await _contactFormService.MarkAsRead(contactId, cancellationToken);

        return result.Succeeded
            ? Ok(new { Success = true, Message = "Contact form marked as read" })
            : BadRequest(new { Success = false, Errors = result.Errors });
    }

    /// <summary>
    /// Update contact form status (Admin endpoint)
    /// </summary>
    /// <param name="contactId">Contact form ID</param>
    /// <param name="status">New status (New, Contacted, Qualified, Converted, Closed)</param>
    /// <param name="cancellationToken">Cancellation token</param>
    /// <returns>Success status</returns>
    [HttpPatch("updateStatus/{contactId}")]
    [ProducesResponseType(StatusCodes.Status200OK)]
    [ProducesResponseType(StatusCodes.Status400BadRequest)]
    public async Task<IActionResult> UpdateStatus(
        string contactId,
        [FromQuery] string status,
        CancellationToken cancellationToken)
    {
        var result = await _contactFormService.UpdateStatus(contactId, status, cancellationToken);

        return result.Succeeded
            ? Ok(new { Success = true, Message = "Status updated successfully" })
            : BadRequest(new { Success = false, Errors = result.Errors });
    }

    /// <summary>
    /// Assign contact form to a user (Admin endpoint)
    /// </summary>
    /// <param name="contactId">Contact form ID</param>
    /// <param name="userId">User ID to assign to</param>
    /// <param name="cancellationToken">Cancellation token</param>
    /// <returns>Success status</returns>
    [HttpPatch("assignTo/{contactId}")]
    [ProducesResponseType(StatusCodes.Status200OK)]
    [ProducesResponseType(StatusCodes.Status400BadRequest)]
    public async Task<IActionResult> AssignTo(
        string contactId,
        [FromQuery] string userId,
        CancellationToken cancellationToken)
    {
        var result = await _contactFormService.AssignTo(contactId, userId, cancellationToken);

        return result.Succeeded
            ? Ok(new { Success = true, Message = "Contact form assigned successfully" })
            : BadRequest(new { Success = false, Errors = result.Errors });
    }
}
