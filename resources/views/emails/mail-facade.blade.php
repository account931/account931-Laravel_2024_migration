@component('mail::message')
# Hello {{ $user->name }}

Message: <span style="color:red">{{ $text }} </span>


@component('mail::button', ['url' => url('/')])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.MAIL_FROM_NAME') }}
@endcomponent
