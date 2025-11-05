<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Handle the contact form submission.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function submitForm(Request $request)
    {
        // Dump everything received from the form
        //dd($request->all());

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'package' => 'required|string|max:255',
            'message' => 'nullable|string|max:255',
        ]);

        // To debug validator results, comment out the previous dd and use this:
        // dd($validator);

        if ($validator->fails()) {
            return redirect('/contact')
                ->withErrors($validator)
                ->withInput();
        }

        // Extract validated data
        $data = $validator->validated();

       // dd($data);

        // Send the contact form data via email
        $contactEmail = env('CONTACT_EMAIL');

        try {
            Mail::to($contactEmail)->send(new ContactFormMail($data));
        } catch (\Exception $e) {
            //dd($e->getMessage());
            //  logger()->error('Mail sending failed: ' . $e->getMessage());
            return redirect('/contact')->with('error', 'An error occurred while sending your message. Please try again later.');
        }
   //  dd();
        return redirect('/contact')->with('success', 'Your message has been sent successfully. Our team will contact you shortly!');
    }

}
