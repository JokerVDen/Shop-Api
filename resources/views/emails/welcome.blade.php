@component('mail::message')
    # Hello {{$user->name}}!
    Thank you for create an account. Please verify you email using this links:
    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verify Account
    @endcomponent()

    Thanks, <br>
    {{config('app.name')}}
@endcomponent