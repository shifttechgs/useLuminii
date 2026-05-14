namespace LuminiiApi.Features.ContactForms.Models.ResponseModels;

public class ContactFormViewModel
{
    public long Id { get; set; }
    public string ContactId { get; set; } = string.Empty;
    public string Name { get; set; } = string.Empty;
    public string Email { get; set; } = string.Empty;
    public string? Phone { get; set; }
    public string? Company { get; set; }
    public string? CompanyStage { get; set; }
    public string? ReferralSource { get; set; }
    public decimal? Budget { get; set; }
    public string Message { get; set; } = string.Empty;
    public List<string> Services { get; set; } = new();
    public string Status { get; set; } = string.Empty;
    public string? AssignedTo { get; set; }
    public string? Notes { get; set; }
    public bool IsRead { get; set; }
    public DateTime? ContactedDate { get; set; }
    public DateTime Created { get; set; }
    public string? CreatedBy { get; set; }
    public DateTime? LastModified { get; set; }
    public string? LastModifiedBy { get; set; }
}
