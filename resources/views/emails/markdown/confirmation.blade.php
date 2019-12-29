@component('mail::message')
    # Спасибо за регистрацию!

    @component('mail::panel')
        Необходимо подтвердить E-mail адрес.
    @endcomponent

    @component('mail::button', ['url' => route('clients.confirm', $token)])
        Подтвердить
    @endcomponent

    С уважением,<br>
    # {{ config('app.name') }}
@endcomponent
