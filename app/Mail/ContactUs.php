<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
	use Queueable, SerializesModels;

	public $parameters;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($parameters)
	{
		$this->parameters = $parameters;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->markdown('emails.contactUsMail')
			->with('parameters', $this->parameters);
	}
}
