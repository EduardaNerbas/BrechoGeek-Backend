# BrechoGeek-Backend
API REST em PHP para e-commerce geek com integração à API do Gemini para moderação de conteúdo, PHPMailer e banco de dados MySQL.

Este repositório contém a API back-end desenvolvida para o Brechó Geek, um sistema de e-commerce voltado para o público nerd. O projeto funciona como uma API REST estruturada em PHP, responsável por gerenciar as regras de negócio, autenticação de usuários, persistência de dados e integrações com serviços externos.

## Funcionalidades Principais

* **API RESTful:** Endpoints estruturados para comunicação assíncrona com o front-end em React, lidando com requisições HTTP e respostas em formato JSON.
* **Autenticação e Controle de Acesso:** Lógica de backend para cadastro, login e encerramento de sessão (logout) de usuários.
* **Controle de Produtos (CRUD):** Endpoints para criação, leitura, atualização e exclusão de produtos, garantindo que usuários editem apenas seus próprios itens.
* **Moderação de Conteúdo com IA:** Integração com a API do Gemini (Google) para analisar as descrições dos produtos no momento do cadastro, impedindo automaticamente textos ofensivos ou inadequados.
* **Disparo de E-mails:** Sistema "Fale Conosco" totalmente funcional utilizando a biblioteca PHPMailer para o envio de mensagens diretamente para a administração.

## Tecnologias Utilizadas

* **PHP:** Linguagem principal no desenvolvimento da API e lógica de negócio.
* **MySQL:** Banco de dados relacional para armazenamento de usuários, produtos e sessões.
* **PHPMailer:** Biblioteca utilizada para a estruturação e disparo seguro de e-mails via SMTP.
* **Gemini API:** SDK/Integração HTTP para validação inteligente de conteúdo.

## Banco de Dados

A estrutura relacional do banco de dados está documentada no arquivo `banco.sql` (ou equivalente) incluído na raiz deste repositório. Ele contém as definições de tabelas (`CREATE TABLE`), chaves primárias e estrangeiras necessárias para a inicialização do ambiente.

## Segurança e Variáveis de Ambiente

Por motivos de segurança e cumprimento das boas práticas de desenvolvimento, nenhuma credencial sensível está exposta neste repositório. Dados como chaves de API do Gemini, senhas de banco de dados e credenciais SMTP do e-mail são gerenciados localmente por meio de variáveis de ambiente (`.env`).

Para fins de configuração, um modelo estrutural das variáveis necessárias pode ser encontrado no arquivo `.env.example`.

## Próximos Passos de Desenvolvimento

1. Implementação de autenticação via JWT (JSON Web Tokens) para substituir ou robustecer o controle de sessão atual.
2. Configuração de políticas estritas de CORS (Cross-Origin Resource Sharing) para aumentar a segurança na comunicação direta com o front-end.
3. Tratamento avançado de erros e logs de requisições.
