<?php

namespace Tests\Feature;

use App\Mail\PrivateInquiryReceivedMail;
use App\Models\PrivateInquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SpamInquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_honeypot_spam_is_quarantined_without_email(): void
    {
        Mail::fake();

        $response = $this->postJson(route('inquiry.store'), [
            'full_name' => 'Bot Sender',
            'email' => 'bot@spam-example.com',
            'circumstances' => 'Managing family office transition.',
            'hp_note' => 'I am a bot filling every field',
        ]);

        // Still looks like success to the sender.
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $record = PrivateInquiry::where('email', 'bot@spam-example.com')->first();
        $this->assertNotNull($record);
        $this->assertTrue($record->is_spam);
        $this->assertSame('honeypot', $record->spam_reason);

        Mail::assertNothingSent();
    }

    public function test_scam_content_is_quarantined_without_email(): void
    {
        Mail::fake();

        $response = $this->postJson(route('inquiry.store'), [
            'full_name' => 'John Lottery',
            'email' => 'john.claims@example.com',
            'circumstances' => 'You have won the international lottery. To release your inheritance funds, please arrange a wire transfer to cover the release fee.',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $record = PrivateInquiry::where('email', 'john.claims@example.com')->first();
        $this->assertNotNull($record);
        $this->assertTrue($record->is_spam);
        $this->assertSame('scam_content', $record->spam_reason);

        Mail::assertNothingSent();
    }

    public function test_link_flooding_is_quarantined_without_email(): void
    {
        Mail::fake();

        $response = $this->postJson(route('inquiry.store'), [
            'full_name' => 'Link Farmer',
            'email' => 'links@spam-example.com',
            'circumstances' => 'See https://spam-one.example and https://spam-two.example for cheap offers.',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $record = PrivateInquiry::where('email', 'links@spam-example.com')->first();
        $this->assertNotNull($record);
        $this->assertTrue($record->is_spam);
        $this->assertSame('link_flooding', $record->spam_reason);

        Mail::assertNothingSent();
    }

    public function test_spam_is_discarded_when_quarantine_disabled(): void
    {
        Mail::fake();
        config(['inquiry.store_spam' => false]);

        $response = $this->postJson(route('inquiry.store'), [
            'full_name' => 'Bot Sender',
            'email' => 'bot@spam-example.com',
            'circumstances' => 'Managing family office transition.',
            'hp_note' => 'I am a bot filling every field',
        ]);

        // Sender still sees success, but nothing is stored and no mail goes out.
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('private_inquiries', [
            'email' => 'bot@spam-example.com',
        ]);

        Mail::assertNothingSent();
    }

    public function test_legitimate_inquiry_is_not_flagged_and_sends_email(): void
    {
        Mail::fake();
        config(['mail.contact_recipient' => 'inquiries@stonebridgeadvisory.com']);

        $response = $this->postJson(route('inquiry.store'), [
            'full_name' => 'Alexander Vance',
            'email' => 'alexander.vance@example.com',
            'circumstances' => 'Managing family office transition with cross-border advisory requirements.',
            'motivation' => 'Seeking discreet strategic counsel for executive restructuring.',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $record = PrivateInquiry::where('email', 'alexander.vance@example.com')->first();
        $this->assertNotNull($record);
        $this->assertFalse($record->is_spam);

        Mail::assertSent(PrivateInquiryReceivedMail::class);
    }

    public function test_admin_can_view_quarantined_spam_inbox(): void
    {
        $this->seed();

        PrivateInquiry::create([
            'full_name' => 'Bot Sender',
            'email' => 'bot@spam-example.com',
            'circumstances' => 'Managing family office transition.',
            'status' => 'new',
            'is_spam' => true,
            'spam_reason' => 'honeypot',
        ]);

        $admin = User::first();

        $response = $this->actingAs($admin)->get(route('admin.inquiries.index', ['status' => 'spam']));

        $response->assertStatus(200);
        $response->assertSee('Bot Sender');
        $response->assertSee('Spam');
    }
}
