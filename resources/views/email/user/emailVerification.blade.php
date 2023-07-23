@component('mail::message')
# Email Confirmation

Dear Sir <strong></strong>,<br>

You have successfully created a Fyxtr account. Please click on the button below to verify your email address and complete your registration.

@component('mail::button', ['url' => config('variable.frontend_base_url'). '/customer/email-verification/?token=' . $token . '&email=' . $email])
Verify Now
@endcomponent

Thank you,<br>
Sincerely,<br>
Fyxtr Team
@endcomponent
