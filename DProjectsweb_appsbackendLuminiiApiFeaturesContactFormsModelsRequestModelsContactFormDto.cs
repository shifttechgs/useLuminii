using System.ComponentModel.DataAnnotations;

namespace LuminiiApi.Features.ContactForms.Models.RequestModels;

public class ContactFormDto
{
    [Required(ErrorMessage = "Name is required")]
    [StringLength(100, ErrorMessage = "Name cannot exceed 100 characters")]
    public string Name { get; set; } = string.Empty;

    [Required(ErrorMessage = "Email is required")]
    [EmailAddress(ErrorMessage = "Invalid email address")]
    [StringLength(150, ErrorMessage = "Email cannot exceed 150 characters")]
    public string Email { get; set; } = string.Empty;

    [Phone(ErrorMessage = "Invalid phone number")]
    public string? Phone { get; set; }

    [StringLength(100, ErrorMessage = "Company name cannot exceed 100 characters")]
    public string? Company { get; set; }

    public string? CompanyStage { get; set; }

    public string? ReferralSource { get; set; }

    [Range(0, 10000000, ErrorMessage = "Budget must be a positive number")]
    public decimal? Budget { get; set; }

    [Required(ErrorMessage = "Message is required")]
    [StringLength(2000, ErrorMessage = "Message cannot exceed 2000 characters")]
    public string Message { get; set; } = string.Empty;

    [Required(ErrorMessage = "At least one service must be selected")]
    public List<string> Services { get; set; } = new();

    public string? AssignedTo { get; set; }
    public string? Notes { get; set; }
}
