<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ContactForm;
use App\Mail\ContactFormSubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Validation — required fields
    // -------------------------------------------------------------------------

    public function test_name_is_required(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', '')
            ->set('email', 'user@example.com')
            ->set('subject', 'Report an error')
            ->set('message', 'Test message')
            ->call('submit')
            ->assertHasErrors(['name' => 'required']);
    }

    public function test_email_is_required(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('email', '')
            ->set('subject', 'Report an error')
            ->set('message', 'Test message')
            ->call('submit')
            ->assertHasErrors(['email' => 'required']);
    }

    public function test_email_must_be_a_valid_address(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'not-an-email')
            ->set('subject', 'Report an error')
            ->set('message', 'Test message')
            ->call('submit')
            ->assertHasErrors(['email' => 'email']);
    }

    public function test_subject_is_required(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'user@example.com')
            ->set('subject', '')
            ->set('message', 'Test message')
            ->call('submit')
            ->assertHasErrors(['subject' => 'required']);
    }

    public function test_subject_must_be_one_of_the_allowed_values(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'user@example.com')
            ->set('subject', 'Invalid subject')
            ->set('message', 'Test message')
            ->call('submit')
            ->assertHasErrors(['subject' => 'in']);
    }

    public function test_message_is_required(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'user@example.com')
            ->set('subject', 'Report an error')
            ->set('message', '')
            ->call('submit')
            ->assertHasErrors(['message' => 'required']);
    }

    // -------------------------------------------------------------------------
    // Successful submission
    // -------------------------------------------------------------------------

    public function test_valid_submission_sends_email(): void
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('subject', 'Report an error')
            ->set('message', 'I found an error on the site.')
            ->call('submit')
            ->assertHasNoErrors();

        Mail::assertSent(ContactFormSubmitted::class);
    }

    public function test_valid_submission_sets_form_submitted_flag(): void
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('subject', 'suggestions')
            ->set('message', 'Here is my suggestion.')
            ->call('submit')
            ->assertSet('formSubmitted', true);
    }

    public function test_valid_submission_clears_form_fields(): void
    {
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
    }

    public function test_all_allowed_subjects_are_accepted(): void
    {
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
    }

    // -------------------------------------------------------------------------
    // resetForm
    // -------------------------------------------------------------------------

    public function test_reset_form_clears_all_fields_and_resets_submitted_flag(): void
    {
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
    }
}
