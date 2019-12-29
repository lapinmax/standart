@component('mail::message')
    # Восстановление пароль!

    @component('mail::panel')
        С вашего аккаунта был отправлен запрос на восстановление пароля. Ваш новый пароль: {{ $password }}
    @endcomponent

    С уважением,<br>
    # {{ config('app.name') }}
@endcomponent
