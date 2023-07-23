@component('mail::message')
# Password Reset

Dear <strong> {{ $first_name->fname }}</strong>,<br><br>

If you have lost your password or wish to reset it, use the link below to get started.

@component('mail::button', ['url' => config('variable.frontend_base_url').'forgot-password/?token=' . $token . '&email=' . $email])
Reset Password
@endcomponent

Thank you,<br>
Sincerely,<br>
Ranji Team
@endcomponent
