@component('mail::message')
# Verify Your Subscription

Click the button below to verify your email address and confirm your subscription.

@component('mail::button', ['url' => route('verify-subscription', $subscriber->verification_token)])
Verify Email
@endcomponent

If you did not request this subscription, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent