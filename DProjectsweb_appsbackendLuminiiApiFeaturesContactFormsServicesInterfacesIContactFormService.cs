using LuminiiApi.Features.ContactForms.Models.RequestModels;
using LuminiiApi.Features.ContactForms.Models.ResponseModels;
using LuminiiApi.Helpers;

namespace LuminiiApi.Features.ContactForms.Services.Interfaces;

public interface IContactFormService : ITransient
{
    Task<Result<ContactFormViewModel>> SubmitContactForm(
        ContactFormDto contactFormDto,
        CancellationToken cancellationToken = default);

    Task<List<ContactFormViewModel>> GetAllContactForms(
        CancellationToken cancellationToken = default);

    Task<List<ContactFormViewModel>> GetContactFormsByStatus(
        string status,
        CancellationToken cancellationToken = default);

    Task<ContactFormViewModel?> GetContactFormById(
        string contactId,
        CancellationToken cancellationToken = default);

    Task<Result<ContactFormViewModel>> UpdateContactForm(
        string contactId,
        ContactFormDto contactFormDto,
        CancellationToken cancellationToken = default);

    Task<Result<bool>> MarkAsRead(
        string contactId,
        CancellationToken cancellationToken = default);

    Task<Result<bool>> UpdateStatus(
        string contactId,
        string status,
        CancellationToken cancellationToken = default);

    Task<Result<bool>> AssignTo(
        string contactId,
        string userId,
        CancellationToken cancellationToken = default);
}
