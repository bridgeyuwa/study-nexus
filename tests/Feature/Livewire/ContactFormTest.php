<?php

use App\Livewire\ContactForm;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

// -------------------------------------------------------------------------
// Validation — required fields
// -------------------------------------------------------------------------

it('name is required', function () {
    Livewire::test(ContactForm::class)
        ->set('name', '')
        ->set('email', 'user@example.com')
        ->set('subject', 'Report an error')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['name' => 'required']);
});

it('email is required', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', '')
        ->set('subject', 'Report an error')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['email' => 'required']);
});

it('email must be a valid address', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'not-an-email')
        ->set('subject', 'Report an error')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['email' => 'email']);
});

it('subject is required', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'user@example.com')
        ->set('subject', '')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['subject' => 'required']);
});

it('subject must be one of the allowed values', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'user@example.com')
        ->set('subject', 'Invalid subject')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['subject' => 'in']);
});

it('message is required', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'user@example.com')
        ->set('subject', 'Report an error')
        ->set('message', '')
        ->call('submit')
        ->assertHasErrors(['message' => 'required']);
});

// -------------------------------------------------------------------------
// Successful submission
// -------------------------------------------------------------------------

it('valid submission sends email', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Report an error')
        ->set('message', 'I found an error on the site.')
        ->call('submit')
        ->assertHasNoErrors();

    Mail::assertSent(ContactFormSubmitted::class);
});

it('valid submission sets form submitted flag', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'suggestions')
        ->set('message', 'Here is my suggestion.')
        ->call('submit')
        ->assertSet('formSubmitted', true);
});

it('valid submission clears form fields', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'media enquiry')
        ->set('message', 'Media enquiry message.')
        ->call('submit')
        ->assertSet('name', null)
        ->assertSet('email', null)
        ->assertSet('subject', null)
        ->assertSet('message', null);
});

it('all allowed subjects are accepted', function () {
    Mail::fake();

    $allowedSubjects = [
        'Report an error',
        'advertise on study nexus',
        'cooperate/business proposition',
        'suggestions',
        'media enquiry',
        'others',
    ];

    foreach ($allowedSubjects as $subject) {
        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('subject', $subject)
            ->set('message', 'Test message.')
            ->call('submit')
            ->assertHasNoErrors(['subject']);
    }
});

// -------------------------------------------------------------------------
// resetForm
// -------------------------------------------------------------------------

it('reset form clears all fields and resets submitted flag', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'others')
        ->set('message', 'Some message.')
        ->call('submit')               // Sets formSubmitted = true
        ->call('resetForm')
        ->assertSet('formSubmitted', false)
        ->assertSet('name', null)
        ->assertSet('email', null)
        ->assertSet('message', null);
});
