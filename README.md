# Autenticao.Gov OAuth2 Provider for Laravel Socialite

** This component is under development. **

## Requirements

* PHP >= 7.2.5 | ^8.0
* Laravel/Socialite >= 5.1.0

## Usage

### Autenticao.Gov Developer Portal

Request CLIENT_ID and CLIENT_SECRET at https://www.autenticacao.gov.pt/

### Install

```
composer require noopstudios/autenticacaogov
```

### Configure

config/services.php
```
'autenticacaogov' => [
    'client_id' => env('AUTENTICACAO_GOV_CLIENT_ID'),
    'client_secret' => env('AUTENTICACAO_GOV_SECRET'),
    'redirect' => env('AUTENTICACAO_GOV_REDIRECT')
]
```

.env
```
AUTENTICACAO_GOV_AUTHORIZATION_ENDPOINT=
AUTENTICACAO_GOV_TOKEN_ENDPOINT=
AUTENTICACAO_GOV_RESOURCE_API=
AUTENTICACAO_GOV_DOMAIN=
```

### Implemenetation

```php
// Redirect to Sign in with Apple in controller.
return Socialite::driver('autenticacaogov')->redirect();

// Handle callback, fetch user information from `code` in controller.
$user = Socialite::driver('autenticacaogov')->user();
```

## License

socialite-apple is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
