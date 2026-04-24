<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Display the Contact page.
     */
    public function index(): View
    {
        $faqs = [
            [
                'q' => 'How far in advance should I reserve my rental items?',
                'a' => 'We recommend booking at least 3–6 months in advance, especially for peak wedding season (May–October). Popular items like arches and lounge sets book up quickly.',
            ],
            [
                'q' => 'Do you offer delivery and setup services?',
                'a' => 'Yes! We offer full white-glove delivery, professional setup, and end-of-event breakdown and pickup. Delivery fees depend on your venue location and order size.',
            ],
            [
                'q' => 'Can I visit your showroom to see the items in person?',
                'a' => 'Absolutely — we love in-person consultations! Our showroom is open Monday–Saturday, 10am–5pm. We recommend scheduling an appointment for a dedicated consultation.',
            ],
            [
                'q' => 'What is your cancellation policy?',
                'a' => 'Cancellations made 60+ days before your event receive a full deposit refund. Cancellations within 30–60 days receive a 50% refund. No refunds within 30 days of the event.',
            ],
            [
                'q' => 'Do you serve areas outside of Knoxville?',
                'a' => 'Yes! We serve a 60-mile radius around Knoxville, including Oak Ridge, Maryville, Morristown, and surrounding Tennessee communities. Additional delivery fees may apply.',
            ],
            [
                'q' => 'Can I customize rental packages or mix and match items?',
                'a' => 'Absolutely. We love creating custom packages tailored to your event vision and budget. Contact us for a free consultation and personalized quote.',
            ],
        ];

        return view('pages.contact', compact('faqs'));
    }

    /**
     * Handle the contact form submission.
     */
    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|max:150',
            'phone'        => 'nullable|string|max:20',
            'event_type'   => 'nullable|string|max:100',
            'event_date'   => 'nullable|date|after:today',
            'message'      => 'required|string|min:10|max:2000',
        ]);

        // TODO: Send email notification (Mail::to('hello@skrentals.com')->send(...))
        // TODO: Store enquiry in database (Enquiry::create($validated))

        return redirect()->route('contact')
                         ->with('success', 'Thank you, ' . $validated['name'] . '! We\'ve received your message and will be in touch within 24 hours.');
    }
}
