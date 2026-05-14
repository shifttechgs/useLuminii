using AutoMapper;
using LuminiiApi.Data;
using LuminiiApi.Data.Entities;
using LuminiiApi.Features.ContactForms.Models.RequestModels;
using LuminiiApi.Features.ContactForms.Models.ResponseModels;
using LuminiiApi.Features.ContactForms.Services.Interfaces;
using LuminiiApi.Features.Shared.Services.Interfaces;
using LuminiiApi.Helpers;
using Microsoft.EntityFrameworkCore;
using Microsoft.Extensions.Configuration;
using System.Text.Json;

namespace LuminiiApi.Features.ContactForms.Services;

public class ContactFormService : IContactFormService
{
    private readonly ApplicationDbContext _dbContext;
    private readonly IMapper _mapper;
    private readonly IEmailService _emailService;
    private readonly IConfiguration _configuration;

    public ContactFormService(
        ApplicationDbContext dbContext,
        IMapper mapper,
        IEmailService emailService,
        IConfiguration configuration)
    {
        _dbContext = dbContext;
        _mapper = mapper;
        _emailService = emailService;
        _configuration = configuration;
    }

    public async Task<Result<ContactFormViewModel>> SubmitContactForm(
        ContactFormDto contactFormDto,
        CancellationToken cancellationToken = default)
    {
        try
        {
            // Generate unique ContactId
            string contactId;
            do
            {
                contactId = $"CON-{DateTime.UtcNow:yyyyMMdd}-{Guid.NewGuid().ToString()[..8].ToUpper()}";
            }
            while (await _dbContext.ContactForms.AnyAsync(x => x.ContactId == contactId, cancellationToken));

            // Create contact form entity
            var contactForm = new ContactForm
            {
                ContactId = contactId,
                Name = contactFormDto.Name,
                Email = contactFormDto.Email,
                Phone = contactFormDto.Phone,
                Company = contactFormDto.Company,
                CompanyStage = contactFormDto.CompanyStage,
                ReferralSource = contactFormDto.ReferralSource,
                Budget = contactFormDto.Budget,
                Message = contactFormDto.Message,
                Services = JsonSerializer.Serialize(contactFormDto.Services),
                Status = "New",
                AssignedTo = contactFormDto.AssignedTo,
                Notes = contactFormDto.Notes,
                IsRead = false,
                Created = DateTime.UtcNow,
                CreatedBy = "WebsiteForm"
            };

            _dbContext.ContactForms.Add(contactForm);
            await _dbContext.SaveChangesAsync(cancellationToken);

            // Send email notification to admin
            await SendAdminNotificationEmail(contactForm, contactFormDto.Services);

            // Map to view model
            var viewModel = _mapper.Map<ContactFormViewModel>(contactForm);
            viewModel.Services = contactFormDto.Services;

            return Result<ContactFormViewModel>.Success(viewModel);
        }
        catch (Exception ex)
        {
            return Result<ContactFormViewModel>.Failure(new[] { $"Error submitting contact form: {ex.Message}" });
        }
    }

    public async Task<List<ContactFormViewModel>> GetAllContactForms(
        CancellationToken cancellationToken = default)
    {
        var contactForms = await _dbContext.ContactForms
            .Where(x => !x.IsDeleted)
            .OrderByDescending(x => x.Created)
            .ToListAsync(cancellationToken);

        var viewModels = contactForms.Select(cf =>
        {
            var vm = _mapper.Map<ContactFormViewModel>(cf);
            vm.Services = string.IsNullOrEmpty(cf.Services)
                ? new List<string>()
                : JsonSerializer.Deserialize<List<string>>(cf.Services) ?? new List<string>();
            return vm;
        }).ToList();

        return viewModels;
    }

    public async Task<List<ContactFormViewModel>> GetContactFormsByStatus(
        string status,
        CancellationToken cancellationToken = default)
    {
        var contactForms = await _dbContext.ContactForms
            .Where(x => !x.IsDeleted && x.Status == status)
            .OrderByDescending(x => x.Created)
            .ToListAsync(cancellationToken);

        var viewModels = contactForms.Select(cf =>
        {
            var vm = _mapper.Map<ContactFormViewModel>(cf);
            vm.Services = string.IsNullOrEmpty(cf.Services)
                ? new List<string>()
                : JsonSerializer.Deserialize<List<string>>(cf.Services) ?? new List<string>();
            return vm;
        }).ToList();

        return viewModels;
    }

    public async Task<ContactFormViewModel?> GetContactFormById(
        string contactId,
        CancellationToken cancellationToken = default)
    {
        var contactForm = await _dbContext.ContactForms
            .FirstOrDefaultAsync(x => x.ContactId == contactId && !x.IsDeleted, cancellationToken);

        if (contactForm == null)
            return null;

        var viewModel = _mapper.Map<ContactFormViewModel>(contactForm);
        viewModel.Services = string.IsNullOrEmpty(contactForm.Services)
            ? new List<string>()
            : JsonSerializer.Deserialize<List<string>>(contactForm.Services) ?? new List<string>();

        return viewModel;
    }

    public async Task<Result<ContactFormViewModel>> UpdateContactForm(
        string contactId,
        ContactFormDto contactFormDto,
        CancellationToken cancellationToken = default)
    {
        try
        {
            var contactForm = await _dbContext.ContactForms
                .FirstOrDefaultAsync(x => x.ContactId == contactId && !x.IsDeleted, cancellationToken);

            if (contactForm == null)
                return Result<ContactFormViewModel>.Failure(new[] { "Contact form not found" });

            contactForm.Name = contactFormDto.Name;
            contactForm.Email = contactFormDto.Email;
            contactForm.Phone = contactFormDto.Phone;
            contactForm.Company = contactFormDto.Company;
            contactForm.CompanyStage = contactFormDto.CompanyStage;
            contactForm.ReferralSource = contactFormDto.ReferralSource;
            contactForm.Budget = contactFormDto.Budget;
            contactForm.Message = contactFormDto.Message;
            contactForm.Services = JsonSerializer.Serialize(contactFormDto.Services);
            contactForm.AssignedTo = contactFormDto.AssignedTo;
            contactForm.Notes = contactFormDto.Notes;
            contactForm.LastModified = DateTime.UtcNow;

            await _dbContext.SaveChangesAsync(cancellationToken);

            var viewModel = _mapper.Map<ContactFormViewModel>(contactForm);
            viewModel.Services = contactFormDto.Services;

            return Result<ContactFormViewModel>.Success(viewModel);
        }
        catch (Exception ex)
        {
            return Result<ContactFormViewModel>.Failure(new[] { $"Error updating contact form: {ex.Message}" });
        }
    }

    public async Task<Result<bool>> MarkAsRead(
        string contactId,
        CancellationToken cancellationToken = default)
    {
        try
        {
            var contactForm = await _dbContext.ContactForms
                .FirstOrDefaultAsync(x => x.ContactId == contactId && !x.IsDeleted, cancellationToken);

            if (contactForm == null)
                return Result<bool>.Failure(new[] { "Contact form not found" });

            contactForm.IsRead = true;
            contactForm.LastModified = DateTime.UtcNow;

            await _dbContext.SaveChangesAsync(cancellationToken);

            return Result<bool>.Success(true);
        }
        catch (Exception ex)
        {
            return Result<bool>.Failure(new[] { $"Error marking as read: {ex.Message}" });
        }
    }

    public async Task<Result<bool>> UpdateStatus(
        string contactId,
        string status,
        CancellationToken cancellationToken = default)
    {
        try
        {
            var contactForm = await _dbContext.ContactForms
                .FirstOrDefaultAsync(x => x.ContactId == contactId && !x.IsDeleted, cancellationToken);

            if (contactForm == null)
                return Result<bool>.Failure(new[] { "Contact form not found" });

            contactForm.Status = status;
            contactForm.LastModified = DateTime.UtcNow;

            if (status == "Contacted" && !contactForm.ContactedDate.HasValue)
            {
                contactForm.ContactedDate = DateTime.UtcNow;
            }

            await _dbContext.SaveChangesAsync(cancellationToken);

            return Result<bool>.Success(true);
        }
        catch (Exception ex)
        {
            return Result<bool>.Failure(new[] { $"Error updating status: {ex.Message}" });
        }
    }

    public async Task<Result<bool>> AssignTo(
        string contactId,
        string userId,
        CancellationToken cancellationToken = default)
    {
        try
        {
            var contactForm = await _dbContext.ContactForms
                .FirstOrDefaultAsync(x => x.ContactId == contactId && !x.IsDeleted, cancellationToken);

            if (contactForm == null)
                return Result<bool>.Failure(new[] { "Contact form not found" });

            contactForm.AssignedTo = userId;
            contactForm.LastModified = DateTime.UtcNow;

            await _dbContext.SaveChangesAsync(cancellationToken);

            return Result<bool>.Success(true);
        }
        catch (Exception ex)
        {
            return Result<bool>.Failure(new[] { $"Error assigning contact form: {ex.Message}" });
        }
    }

    private async Task SendAdminNotificationEmail(ContactForm contactForm, List<string> services)
    {
        try
        {
            var adminEmail = _configuration["AdminEmail"] ?? "info@shifttechgs.com";
            var servicesText = string.Join(", ", services);
            var budgetText = contactForm.Budget.HasValue
                ? $"R{contactForm.Budget.Value:N0}"
                : "Not specified";

            var emailContent = $@"
<!DOCTYPE html>
<html>
<head>
    <style>
        body {{ font-family: Arial, sans-serif; line-height: 1.6; color: #333; }}
        .container {{ max-width: 600px; margin: 0 auto; padding: 20px; }}
        .header {{ background: linear-gradient(135deg, #002b22 0%, #0a3622 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 10px 10px 0 0; }}
        .content {{ background: #ffffff; padding: 30px; border: 1px solid #e0e0e0; }}
        .field {{ margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f0f0f0; }}
        .label {{ font-weight: bold; color: #0a3622; margin-bottom: 5px; }}
        .value {{ color: #555; }}
        .services-tag {{ display: inline-block; background: #74b812; color: white; padding: 4px 12px; border-radius: 15px; margin: 3px; font-size: 12px; }}
        .footer {{ background: #f8f9fa; padding: 20px; text-align: center; color: #666; font-size: 12px; border-radius: 0 0 10px 10px; }}
        .cta-button {{ display: inline-block; background: #74b812; color: white; padding: 12px 30px; text-decoration: none; border-radius: 25px; margin-top: 20px; }}
    </style>
</head>
<body>
    <div class=""container"">
        <div class=""header"">
            <h1 style=""margin: 0;"">New Contact Form Submission</h1>
            <p style=""margin: 10px 0 0 0; opacity: 0.9;"">ShiftTech Website</p>
        </div>
        <div class=""content"">
            <p style=""font-size: 16px; color: #74b812; font-weight: bold;"">Contact ID: {contactForm.ContactId}</p>

            <div class=""field"">
                <div class=""label"">Name:</div>
                <div class=""value"">{contactForm.Name}</div>
            </div>

            <div class=""field"">
                <div class=""label"">Email:</div>
                <div class=""value""><a href=""mailto:{contactForm.Email}"">{contactForm.Email}</a></div>
            </div>

            <div class=""field"">
                <div class=""label"">Phone:</div>
                <div class=""value"">{contactForm.Phone ?? "Not provided"}</div>
            </div>

            <div class=""field"">
                <div class=""label"">Company:</div>
                <div class=""value"">{contactForm.Company ?? "Not provided"}</div>
            </div>

            <div class=""field"">
                <div class=""label"">Company Stage:</div>
                <div class=""value"">{contactForm.CompanyStage ?? "Not specified"}</div>
            </div>

            <div class=""field"">
                <div class=""label"">Referral Source:</div>
                <div class=""value"">{contactForm.ReferralSource ?? "Not specified"}</div>
            </div>

            <div class=""field"">
                <div class=""label"">Estimated Budget:</div>
                <div class=""value"">{budgetText}</div>
            </div>

            <div class=""field"">
                <div class=""label"">Services Interested In:</div>
                <div class=""value"">
                    {string.Join("", services.Select(s => $"<span class=\""services-tag\"">{s}</span>"))}
                </div>
            </div>

            <div class=""field"">
                <div class=""label"">Message:</div>
                <div class=""value"" style=""white-space: pre-wrap;"">{contactForm.Message}</div>
            </div>

            <div class=""field"">
                <div class=""label"">Submitted:</div>
                <div class=""value"">{contactForm.Created:MMMM dd, yyyy 'at' h:mm tt}</div>
            </div>

            <div style=""text-align: center; margin-top: 30px;"">
                <a href=""https://crm.shifttechgs.com/contacts/{contactForm.ContactId}"" class=""cta-button"">View in CRM</a>
            </div>
        </div>
        <div class=""footer"">
            <p>This is an automated notification from your ShiftTech website contact form.</p>
            <p>Please respond to this inquiry within 24 hours.</p>
        </div>
    </div>
</body>
</html>";

            var message = new Message(
                to: new[] { adminEmail },
                subject: $"New Contact Form: {contactForm.Name} - {servicesText}",
                content: emailContent,
                attachments: null
            );

            await _emailService.SendEmailAsync(message);
        }
        catch (Exception ex)
        {
            // Log the error but don't fail the entire operation
            Console.WriteLine($"Failed to send admin notification email: {ex.Message}");
        }
    }
}
