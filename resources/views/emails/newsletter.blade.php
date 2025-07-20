@component('mail::message')
# {{ $subject }}

{!! $content !!}

@component('mail::button', ['url' => url('/')])
Visit Our Website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent