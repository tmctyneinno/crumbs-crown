<?php

namespace Tests\Feature;

use App\Mail\CustomerEnquiryMail;
use App\Models\ContactEnquiry;
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
            ->call('sendMessage')
            ->assertDispatched('toast');

        Mail::assertSent(CustomerEnquiryMail::class, function (CustomerEnquiryMail $mail) {
            $envelope = $mail->envelope();

            return $mail->hasTo('enquiry@crumbsandcrown.com')
                && $envelope->to[0]->address === 'enquiry@crumbsandcrown.com'
                && $envelope->to[0]->name === 'Crumbs & Crown'
                && $envelope->replyTo[0]->address === 'jane@example.com'
                && $envelope->replyTo[0]->name === 'Jane Doe'
                && $mail->payload['fullName'] === 'Jane Doe'
                && $mail->payload['enquiryType'] === 'order';
        });

        $this->assertDatabaseHas('contact_enquiries', [
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '08012345678',
            'enquiry_type' => 'order',
            'message' => 'I would like to order a custom cake for a birthday celebration.',
        ]);
    }

    public function test_storefront_layout_includes_the_global_toast(): void
    {
        $this->get(route('connect'))
            ->assertOk()
            ->assertSee('x-on:toast.window', false);
    }
}
