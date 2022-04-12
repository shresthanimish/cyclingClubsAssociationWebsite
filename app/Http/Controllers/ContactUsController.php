<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactUs;

class ContactUsController extends Controller
{

	/**
	 * Create a new controller instance.
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/*
	 * Display the contact us form (used by route directly)
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function showContactUsForm(Request $request) {
		return view('contact');
	}

	/*
	 * Display the contact us form (used by route directly)
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function processContactUsForm(Request $request) {
		$contact = NULL;

		if ( $request->isMethod('post') )
		{
			// Validate form submission
			$this->validate($request, [
				'name' => ['required', 'string', 'max:150'],
				'email' => ['required', 'email', 'max:255'],
				'phone' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:8', 'max:12'],
				'subject'=> ['required', 'string', 'max:255'],
				'message' => ['required', 'string', 'max:1000'],
			]);

			//  Store contact message in database
			$contact = Contact::create($request->all());

			if ( !empty($contact) && $contact->exists )
			{
				try
				{
					//  Send mail to admin
					$parameters = [
						'name' => $contact->name,
						'email' => $contact->email,
						'phone' => $contact->phone,
						'subject' => $contact->subject,
						'message' => $contact->message,
					];

					Mail::to(config('mail.from.address'))->send(new ContactUs($parameters));
				}
				catch ( exception $ex )
				{
					$rv = back()->with($exception->getMessage())->withInput();
				}
			}
		}

		if ( empty($contact) || !$contact->exists )
		{
			$rv = back()->with('error', 'An error occurred processing your contact request. Failed saving contact message.')->withInput();
		}
		else
		{
			$rv = back()->with('success', 'We have received your message and one of our representatives will be in contact with you shortly.');
		}
		return $rv;
	}
}
