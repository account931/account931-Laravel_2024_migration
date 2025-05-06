@component('mail::message')
# Hello {{ $user->name }}

{{ $text }}

Your invoice **{{ $invoice }}** has been paid successfully.

@component('mail::button', ['url' => url('/invoices/'.$invoice)])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.MAIL_FROM_NAME') }}
@endcomponent
