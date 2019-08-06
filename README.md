# Contact Center (PHP Package)

Esta lib tem como objetivo integrar os sistemas com o serviço Contact Center de uma forma mais simples e eficaz. Com algumas linhas de código, já será possível enviar e-mail e/ou sms de formas separadas, ou exatamente no mesmo momento.

## Instalação (via composer)

Primeiro, vamos adicionar a dependência e o repositório do pacote no nosso arquivo composer.json:


```json
{
    "require": {
        "eduzz/contact-center-php": "~1.0"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:eduzz/contact-center-php.git"
        }
    ]
}
```

Após configurado o composer, utilize o comando abaixo para instalar os pacotes do projeto.

```sh
    composer install
```

## Projetos Laravel

Após realizado os passos anteriores, é necessário realizar o seguinte comando no terminal, que gerará o arquivo **config/contactcenter.php**.

```sh
    php artisan vendor:publish --tag="config"
```

No arquivo **config/app.php**

```php
// ...
'providers' => [
    // ...
    Eduzz\ContactCenter\ContactCenterServiceProvider::class,
],
```

## Projetos Lumen

No Lumen o arquivo config deve ser copiado manualmente. Após a instalação dos pacotes do composer, crie uma pasta **config** na raíz do projeto, e copie o arquivo **vendor/eduzz/contact-center-php/src/config/contactcenter.php** para o diretório criado.

No arquivo **bootstrap/app.php**

```php
// ...
$app->configure('contactcenter');
// ...
$app->register(Eduzz\ContactCenter\ContactCenterServiceProvider::class);
// ...
```
##

## Configurando o Contact Center

No arquivo **config/contactcenter.php**, tem duas configurações iniciais a se fazer:

* **ApplicationKey** => é o hash da aplicação que usará o Contact Center. Necessário entrar em contato com a equipe para adquirir esta chave.
* **BaseUrl** => Endpoint do contact center fornecido pela equipe. 

## Usando o Contact Center

Para realizar o envio de email simples utilize a seguinte estrutura:

```php
    $contaccenter
        ->createEmailMessage() //Cria mensagem de email
        ->to(new Person('email@dominio.com.br', 'Nome do destinatario')) // Destinatario
        ->from('no-reply@dominio.com', 'Nome da empresa') // Remetente
        ->template('HRGJJDIISIW3424') // fornecido pela equipe 
        ->params([
            'saudacao' => 'Olá ContactCenter',
            'link_acesso'=> 'http://github.com'
        ]) // Parametros para montar o email
        ->metadata([
            'track_id' => '123'
        ]) // Usado para colocar qualquer informação relevante para rastreio
        ->onError(function($e) {
            echo "Envio de email não realizado" . $e->getMessage()
        }) // Suprime o erro dentro de uma rotina de fallback
        ->send();
```

Para realizar o envio de vários e-mails simultaneamente, recomendamos a utilizacao do **DeliveryManager**

```php
    $deliveryManager = $contaccenter->delivery();

    for ($i = 1; $i <= 10; $i++) {
        $emailMessage = $contactCenter->createEmailMessage();
    
        $emailMessage->to(new Person('email@dominio.com.br', 'Nome do destinatario'))
        ->from('no-reply@dominio.com', 'Nome da empresa')
        ->templateId('HRGJJDIISIW3424')
        ->params([
            'saudacao' => 'Olá ContactCenter',
            'link_acesso'=> 'http://github.com'
        ])
        ->metadata([
            'track_id' => $i
        ]);

        $deliveryManager->add($emailMessage);
    }

    $deliveryManager->send();
```

Com o **DeliveryManager**, você pode mandar tanto email como SMS ao mesmo tempo

```php
    $deliveryManager = $contaccenter->delivery();

    $emailMessage = $contactCenter->createEmailMessage();
    $smsMessage = $contactCenter->createSMSMessage();

    $emailMessage->to(new Person('email@dominio.com.br', 'Nome do destinatario'))
    ->from('no-reply@dominio.com', 'Nome da empresa')
    ->templateId('HRGJJDIISIW3424')
    ->params([
        'saudacao' => 'Olá ContactCenter',
        'link_acesso'=> 'http://github.com'
    ])
    ->metadata([
        'track_id' => $i
    ]);

    $smsMessage
        ->to(new Phone('+55', '15', '99999999'))
        ->templateId('HRGJJDIISIWadsad')
        ->params([
            'nome' => 'Contact Center'
        ]);

    $deliveryManager->add($emailMessage);
    $deliveryManager->add($smsMessage);
    $deliveryManager->send();
```

## Políticas para criação de templates

O **Contact Center** possui todos os templates de e-mails, SMS, push notification e outros. Por se tratar de algumas mensagens diretamente direcionadas aos clientes, entre em contato com a equipe responsável para saber o codigo de template utilizado em determinada situação, e os par6Ametros necessários para envio. Assim garantimos uma comunicação mais uniforme de todos os produtos da empresa.