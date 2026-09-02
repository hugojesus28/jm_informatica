# JM Informática

Sistema de gerenciamento de ordens de serviço desenvolvido em PHP e MySQL para o teste técnico da Titan Software.

## Tecnologias

- PHP Orientado a Objetos
- Arquitetura MVC
- PDO
- MySQL
- HTML5 / CSS3
- JavaScript

> Projeto desenvolvido sem frameworks e sem Composer, conforme solicitado no teste.

## Funcionalidades

- Login e logout de usuários
- Cadastro de usuários
- Cadastro de serviços
- Listagem de serviços
- Filtros por:
  - Descrição
  - Data inicial e final
  - Usuário
  - Status
- Dashboard com:
  - Dados do usuário logado
  - Valor total dos serviços
  - Serviços pendentes
  - Listagem dos serviços
- Finalização de serviços
- Possibilidade de desfazer a finalização
- Registro da data de finalização
- Cálculo de comissão
- Envio de e-mail ao finalizar um serviço

## Regras de comissão

A comissão é calculada de acordo com o valor do serviço:

| Valor do serviço | Comissão |
|---|---:|
| Até R$ 1.000,00 | 5% |
| Acima de R$ 1.000,00 | 10% |
| Acima de R$ 10.000,00 | 20% |

Os serviços sem data de finalização são considerados **Pendentes**. Serviços com data de finalização são considerados **Finalizados**.

## Estrutura do projeto
```text
jm_informatica/
├── components/
├── config/
├── controllers/
├── DAO/
├── database/
│   └── database.sql
├── models/
├── public/
├── services/
├── views/
└── index.php
```
## Banco de dados
O banco utilizado possui nome jm_informatica, usuario root e não é necessário senha.
O script para criação das tabelas está localizado em:
database/database.sql

## Como executar
1. Pré-requisitos
- XAMPP
- Apache
- MySQL
- PHP

2. Instalação

- Clone o projeto ou extraia o rar dentro da pasta htdocs do XAMPP: `C:\xampp\htdocs\jm_informatica`

- Inicie o Apache e o MySQL pelo XAMPP.

3. Banco de dados

- No phpMyAdmin, crie o banco: `jm_informatica`

- Depois, execute o script: `database/database.sql`

4. Acessar o sistema

- No navegador, acesse: `http://localhost/jm_informatica/index.php`

- O sistema será iniciado pela tela de login.

## Observação

O envio de e-mails depende da função nativa mail() do PHP por isso é necessário a configuração SMTP para funcionar. As demais funcionalidades podem ser executadas normalmente utilizando o XAMPP.
Abaixo deixarei a configuração, caso seja necessário:
No XAMPP, configure o arquivo `php.ini` com os dados do servidor SMTP utilizado e reinicie o Apache após as alterações.
`Caminho: C:/xampp/php/php.ini`

## Exemplo de configuração:
```ini
[mail function]
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = seu-email@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
```
Após isso, configure o `sendmail.ini` com os dados necessários para concluir sua configuração SMTP.
`Caminho: C:xampp/sendmail/sendmail.ini`

## Exemplo de configuração:
```ini
[sendmail]
smtp_server=smtp.gmail.com 
smtp_port=587 
error_logfile=error.log
debug_logfile=debug.log
auth_username=seu-email@gmail.com 
auth_password=sua-senha-de-app 
force_sender=seu-email@gmail.com
```


