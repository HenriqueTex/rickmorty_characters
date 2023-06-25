
# Rick and Morty Characters

Este projeto é uma api simples com um Crud dos personagens da série animada Rick an Morty. O projeto foi desenvolvido utilizando o banco de dados Mysql, framework Laravel, PhpUnit e Swagger.


## Tecnologias

- Linguagem: Php
- Framework: Laravel
- Tecnologia: Mysql, FakerPhp, PHPUnit

## Instalação

1. Clone o repositório: `git clone https://github.com/HenriqueTex/Products-Parser`
2. Acesse o diretório do projeto: `cd Products-Parser`
3. Instale as dependências: `composer install`
4. Configure as variáveis de ambiente: crie um arquivo `.env` e `.env.testing` com base no arquivo `.env.example` e configure as informações necessárias.
5. Execute as migrations: `php artisan migrate`
6. Execute as seeds: `php artisan db:seed`
7. Crie o arquivo do banco de dados sqlite: `touch database/database.sqlite`
8. Inicie o servidor local: `php artisan serve`

## Uso

    Para utilizar o projeto basta acessar a documentação do Swagger em http://localhost:8000/api/documentation testando as rotas disponíveis ou utilizando como guia para consumir a api. A rota de autenticação é a única que não necessita de autenticação.
    Para conseguir um token de autenticação basta acessar a rota de autenticação e utilizar o usuário e senha padrão: email:`test@example.com` e password:`password`.
    Para executar os testes basta executar o comando `php artisan test` no terminal.
