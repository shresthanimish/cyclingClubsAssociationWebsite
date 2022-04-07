<?php

namespace App\Exceptions;

use App\Mail\ExceptionOccured;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Mail;
use Response;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 * @var array<int, string>
	 */
	protected $dontFlash = [
		'current_password',
		'password',
		'password_confirmation',
	];

	/**
	 * Register the exception handling callbacks for the application. Currently reports or logs an exception.
	 * @param  \Throwable $exception
	 * @return void
	 * @throws \Exception
	 */
	public function report(Throwable $exception)
	{
		$enableEmailExceptions = config('exceptions.emailExceptionEnabled');

		if ($enableEmailExceptions === '') {
			$enableEmailExceptions = config('exceptions.emailExceptionEnabledDefault');
		}

		if ($enableEmailExceptions && $this->shouldReport($exception)) {
			$this->sendEmail($exception);
		}

		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Throwable $exception
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @throws \Throwable
	 */
	public function render($request, Throwable $exception)
	{
		return parent::render($request, $exception);
	}
}
