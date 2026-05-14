using AutoMapper;
using LuminiiApi.Data.Entities;
using LuminiiApi.Features.ContactForms.Models.RequestModels;
using LuminiiApi.Features.ContactForms.Models.ResponseModels;

namespace LuminiiApi.Features.ContactForms;

public class ContactFormMappingProfile : Profile
{
    public ContactFormMappingProfile()
    {
        CreateMap<ContactForm, ContactFormViewModel>();
        CreateMap<ContactFormDto, ContactForm>();
    }
}
