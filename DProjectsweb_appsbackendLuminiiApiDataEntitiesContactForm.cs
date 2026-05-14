namespace LuminiiApi.Data.Entities;

public class ContactForm : BaseAuditableEntity
{
    public string ContactId { get; set; } = string.Empty;
    public string Name { get; set; } = string.Empty;
    public string Email { get; set; } = string.Empty;
    public string? Phone { get; set; }
    public string? Company { get; set; }
    public string? CompanyStage { get; set; }
    public string? ReferralSource { get; set; }
    public decimal? Budget { get; set; }
    public string Message { get; set; } = string.Empty;
    public string Services { get; set; } = string.Empty; // JSON array of selected services
    public string Status { get; set; } = "New"; // New, Contacted, Qualified, Converted, Closed
    public string? AssignedTo { get; set; }
    public string? Notes { get; set; }
    public bool IsRead { get; set; } = false;
    public DateTime? ContactedDate { get; set; }
}
