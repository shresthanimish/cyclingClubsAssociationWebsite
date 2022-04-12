@component('mail::message')
# Introduction

The body of your message.

Inquiry from: {{ $parameters['name'] }}
Email: {{ $parameters['email'] }}
Phone: {{ $parameters['phone'] }}
Message: {{ $parameters['message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
