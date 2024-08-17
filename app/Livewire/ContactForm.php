<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Validator;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;
    public $recaptchaResponse;
	public $formSubmitted = false;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|in:Report an error,advertise on study nexus,cooperate/business proposition,suggestions,media enquiry,others',
        'message' => 'required|string',
        
    ];

    // In your ContactForm component
public function submit()
{
	
    // Validate the form data
   $this->validate();

    try {
		
        // Attempt to send the email
        Mail::to('support@studynexus.ng')->send(new ContactFormSubmitted([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]));
        //dd('reached try block');
        // If email sent successfully, reset the form and show success message
		$this->formSubmitted = true;
		
        $this->reset(['name', 'email', 'subject', 'message']);
        session()->flash('message', 'Your message has been sent successfully!');

    } catch (\Exception $e) {
        \Log::error('Contact form email failed to send: ' . $e->getMessage());
        session()->flash('error', 'There was an error sending your message. Please try again later.');
    }
}

	public function resetForm()
    {
        $this->formSubmitted = false;
        $this->reset(['name', 'email', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form')->extends('layouts.backend');
    }
}