<?php

namespace Tests\Feature;

use App\Mail\CustomerEnquiryMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ConnectPageEnquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_sends_a_professional_enquiry_email_to_the_business_address(): void
    {
        Mail::fake();

        Livewire::test('connect.index')
            ->set('fullName', 'Jane Doe')
            ->set('email', 'jane@example.com')
            ->set('phone', '08012345678')
            ->set('enquiryType', 'order')
            ->set('message', 'I would like to order a custom cake for a birthday celebration.')
            ->call('sendMessage');

        Mail::assertSent(CustomerEnquiryMail::class, function (CustomerEnquiryMail $mail) {
            return $mail->hasTo('enquiry@crumbsandcrown.com')
                && $mail->payload['fullName'] === 'Jane Doe'
                && $mail->payload['enquiryType'] === 'order';
        });
    }
}
