# Contact Center (PHP Package)

Esta lib tem como objetivo integrar os sistemas com o serviço Contact Center de uma forma mais simples e eficaz. Com algumas linhas de código, já será possível enviar e-mail e/ou sms de formas separadas, ou exatamente no mesmo momento.

## Instalação (via composer)

Primeiro, vamos adicionar a dependência e o repositório do pacote no nosso arquivo composer.json:


```json
{
    "require": {
        "eduzz/contact-center-php": "^1.0"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@bitbucket.org:eduzz/contact-center-php.git"
        }
    ]
}
```

Importante: este é um repositório PRIVADO, logo, você precisa ter acesso de leitura para a instalação.

## Projetos Laravel

Após realizado os passos anteriores, é necessário realizar o seguinte comando no terminal

```sh
    php artisan vendor:publish --tag="config"
```

No arquivo **config/app.php**

```php
// ...
'providers' => [
    // ...
    Eduzz\Hermes\HermesLaravelServiceProvider::class,
],
```
