# Projeto Login e Cadastro PHP

Este projeto é um sistema simples de **login** e **cadastro** em PHP, usando MySQL e testes automatizados com Node.js.

---

## 1. Pré-requisitos

Antes de rodar o projeto, você precisa ter instalado:

- [XAMPP](https://www.apachefriends.org/pt_br/index.html)
- Node.js (para rodar os testes automatizados)

---

## 2. Instalação

### Passo 1 — Instalar o XAMPP

Baixe e instale o XAMPP em seu computador.

### Passo 2 — Colocar a pasta do projeto dentro de `htdocs`

Copie a pasta do projeto para a pasta `htdocs` dentro da instalação do XAMPP.  
Exemplo no Windows:

### Passo 3 — Criar o banco de dados

1. Abra o **XAMPP** e inicie o **Apache** e o **MySQL**.
2. Acesse o **phpMyAdmin** no navegador:

3. Crie um banco de dados novo.
4. Importe o script `db.sql` presente na pasta do projeto para criar as tabelas necessárias.

---

## 3. Rodando o Projeto

No navegador, acesse:

---

## 4. Testes Automatizados

Para rodar os testes automatizados, use o terminal (ou prompt de comando) e execute:

- Para testar o **login**:

- Para testar o **cadastro**:

Certifique-se de que o Node.js esteja instalado em sua máquina.

---

## Estrutura do Projeto

seu-projeto/
│
├── assets/css/style.css
├── cadastro.php
├── conexao.php
├── db.sql
├── login.php
├── pagina-inicial.php
├── testeAutomatizado.js
└── testeAutomatizadoCadastro.js

---

## Autor

Victor Luiz Koba Batista
Miguel Francisco da Silva Sales
