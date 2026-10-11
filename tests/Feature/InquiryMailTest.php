<?php

namespace Tests\Feature;

use App\Mail\PrivateInquiryReceivedMail;
use App\Models\PrivateInquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InquiryMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_inquiry_submission_stores_data_and_dispatches_email_to_recipient(): void
    {
        Mail::fake();

        $recipientEmail = 'inquiries@stonebridgeadvisory.com';
        config(['mail.contact_recipient' => $recipientEmail]);

        $payload = [
            'full_name' => 'Alexander Vance',
            'email' => 'alexander.vance@example.com',
            'phone' => '+44 20 7946 0912',
            'circumstances' => 'Managing family office transition with cross-border advisory requirements.',
            'motivation' => 'Seeking discreet strategic counsel for executive restructuring.',
        ];

        $response = $this->postJson(route('inquiry.store'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('private_inquiries', [
            'full_name' => 'Alexander Vance',
            'email' => 'alexander.vance@example.com',
            'phone' => '+44 20 7946 0912',
        ]);

        Mail::assertSent(PrivateInquiryReceivedMail::class, function (PrivateInquiryReceivedMail $mail) use ($recipientEmail) {
            return $mail->hasTo($recipientEmail) &&
                $mail->inquiry->full_name === 'Alexander Vance' &&
                $mail->inquiry->email === 'alexander.vance@example.com';
        });
    }

    public function test_inquiry_submission_succeeds_even_if_mail_fails(): void
    {
        $payload = [
            'full_name' => 'Victoria Sterling',
            'email' => 'victoria.sterling@example.com',
            'circumstances' => 'Confidential portfolio restructuring inquiry for private assets.',
        ];

        $response = $this->post(route('inquiry.store'), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('private_inquiries', [
            'full_name' => 'Victoria Sterling',
            'email' => 'victoria.sterling@example.com',
        ]);
    }

    public function test_future_rendered_timestamp_is_ignored_not_punished(): void
    {
        // Regression: a visitor whose device clock runs ahead of the server
        // used to be clamped to "0 seconds" and trapped in the retry error.
        Mail::fake();
        config(['mail.contact_recipient' => 'inquiries@stonebridgeadvisory.com']);

        $response = $this->postJson(route('inquiry.store'), [
            'full_name' => 'Ifeoluwa Tester',
            'email' => 'ifeoluwa.tester@example.com',
            'phone' => '08175461196',
            'circumstances' => 'Lovely',
            'motivation' => 'Final testing',
            'form_rendered_at' => now()->addHour()->timestamp,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('private_inquiries', [
            'email' => 'ifeoluwa.tester@example.com',
            'is_spam' => false,
        ]);

        Mail::assertSent(PrivateInquiryReceivedMail::class);
    }

    public function test_instant_client_measurement_still_triggers_retry(): void
    {
        Mail::fake();

        $response = $this->postJson(route('inquiry.store'), [
            'full_name' => 'Speedy Bot',
            'email' => 'speedy@example.com',
            'circumstances' => 'Submitted the instant the page loaded.',
            'fill_seconds' => 0,
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.form.0', 'Please take a moment to complete the form, then submit again.');

        $this->assertDatabaseMissing('private_inquiries', [
            'email' => 'speedy@example.com',
        ]);

        Mail::assertNothingSent();
    }

    public function test_human_client_measurement_passes_and_sends_email(): void
    {
        Mail::fake();
        config(['mail.contact_recipient' => 'inquiries@stonebridgeadvisory.com']);

        $response = $this->postJson(route('inquiry.store'), [
            'full_name' => 'Patient Visitor',
            'email' => 'patient.visitor@example.com',
            'circumstances' => 'Took three quarters of a minute to write this thoughtfully.',
            'fill_seconds' => 45,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('private_inquiries', [
            'email' => 'patient.visitor@example.com',
            'is_spam' => false,
        ]);

        Mail::assertSent(PrivateInquiryReceivedMail::class);
    }
}
