# README - Uso do Código de Validação em PHP

Este código PHP demonstra como usar a classe `Validator` para validar um conjunto de payloads em um formato específico. Ele é útil quando você precisa garantir que os dados fornecidos atendam a critérios específicos antes de processá-los. O código utiliza a biblioteca Composer `Jhony\Validation\Validator` para simplificar o processo de validação.

## Requisitos

- PHP instalado (você deve estar executando pelo menos a versão 7.0)
- Composer instalado para gerenciar dependências (https://getcomposer.org/download/)

## Instalação

Certifique-se de ter o Composer instalado e siga estas etapas:

1. Clone ou faça o download do código-fonte para o seu ambiente.
2. No terminal, navegue até o diretório do código e execute o comando `composer install`. Isso instalará a biblioteca de validação necessária.

## Uso

1. Defina seus dados a serem validados no array `$payloads`. Cada elemento do array representa um conjunto de dados a ser validado.

2. Defina as regras de validação no array `$rules`. Cada chave no array `$rules` corresponde a um campo no array de dados e define as regras de validação para esse campo.

3. O código iterará pelos payloads e validará cada um de acordo com as regras definidas.

4. Se algum dos payloads não atender às regras de validação, os erros serão armazenados no array `$errors`.

5. Se houver erros de validação, o código retornará uma resposta JSON contendo uma mensagem de erro e os detalhes dos erros encontrados.

6. Se não houver erros de validação, o código continuará a execução sem interrupções.

## Exemplo de Uso

Você pode alterar a linguagem com o comando:

```php
$validator = new Validator('pt_BR');
```

Neste exemplo, dois conjuntos de dados são validados:

### Conjunto de Dados 1:

```php
[
    'returnStatus' => 0,
    'message'      => 123456,
    'partyNumber'  => '123',
    'partyId'      => 300000001,
    'logdate'      => '2023-01-01T00:00:00.000',
]
```

Este conjunto contém valores que não atendem às regras de validação definidas.

### Conjunto de Dados 2:

```php
[
    'returnStatus' => null,
    'message'      => 'asdfasdsadf',
    'partyNumber'  => 123,
    'partyId'      => '1231233',
    'logdate'      => '2023-01-01',
]
```

Este conjunto também contém valores que não atendem às regras de validação definidas.

O código finaliza a execução imprimindo os erros de validação em formato JSON, caso haja algum, ou continua a execução se todos os conjuntos de dados passarem na validação.

### Execução:

Você pode executar o código PHP em seu servidor web ou localmente. Certifique-se de que o Composer está instalado e todas as dependências estejam corretamente configuradas.

Para executar o código, basta acessar o arquivo PHP em seu navegador ou usar o terminal para executá-lo.

```php
use JhonyMiler\Validation

require_once './vendor/autoload.php';

$payloads = [
    [
        'returnStatus' => 0,
        'message'      => 123456,
        'partyNumber'  => '123',
        'partyId'      => 300000001,
        'logdate'      => '2023-01-01T00:00:00.000',
    ],
    [
        'returnStatus' => null,
        'message'      => 'asdfasdsadf',
        'partyNumber'  => 123,
        'partyId'      => '1231233',
        'logdate'      => '2023-01-01',
    ],
];

$rules = [
    'returnStatus' => 'required|integer',
    'message'      => 'required|string',
    'partyNumber'  => 'required|integer',
    'partyId'      => 'required|integer',
    'logdate'      => 'required|date_format:Y-m-d\TH:i:s.u',
];

$errors = [];

$validator = new Validator();

foreach ($payloads as $key => $data) {
    $validation = $validator->make($data, $rules);

    if ($validation->fails()) {
        $errors[$key] = $validation->errors()->toArray();
    }
}

if (!empty($errors)) {
    $response = [
        'message' => 'Erro de validação de dados.',
        'errors'  => $errors,
    ];

    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

```