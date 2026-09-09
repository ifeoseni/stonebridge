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
}
