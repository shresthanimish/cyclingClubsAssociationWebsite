<?php
/**
 * View that let's the user know that the verification email was sent to them to confirm the password reset
 */
?>
@extends('layouts.app')

@section('title') {{'Verify Email Address'}} @endsection

@section('content')

	<div class="content-container">

	@if (session('resent'))
		<p class="alert alert-success">A verification link has been successfully sent to your email address.</p>
	@endif

		<h1>Verify your email address</h1>

		<p>Before we can proceed we need to verify your email address. Please check your email for your verification link.</p>

		<p>If you did not receive the email, <a href="{{ route('verification.resend') }}">Click here to send another verification link</a>.</p>
	</div>

@endsection
