
# [fintech.co.mz](https://www.fintech.co.mz/)
[![js-standard-style](https://img.shields.io/badge/code%20style-standard-brightgreen.svg?style=flat)](http://standardjs.com/)

O [Fintech](https://www.fintech.co.mz/) é um plataforma focado focada em utilizar tecnologia para oferecer serviços financeiros de maneira mais eficiente, acessível e inovadora.

Esse repositório contém o código-fonte da plataforma e da API.

**Conteúdo**

- [Instalar e rodar o projeto](#instalar-e-rodar-o-projeto)
  - [Requisitos Minimos](#requisitos-minimos)
  - [Preparacao do Ambiente](#preparacao-ambiente)
  - [Clonar o projeto](#clonar-o-projeto)
  - [Criacao da Base de Dados](#criacao-da-base-de-dados)
- [Rodar os testes](#rodar-os-testes)
- [Histórico do desenvolvimento](#histórico-de-desenvolvimento)
  - [Início do projeto](#início-do-projeto)
  - [Milestones](#milestones)

## Instalar e rodar o projeto

Rodar o TabNews em sua máquina local é uma tarefa extremamente simples.

### Requisitos Minimos
Para rodar a plataforma sao necessarios os seguintes requisitos minimos:

- CPU: 2 gigahertz ou mais;
- RAM: 2GB ou mais;
- Armazenamento em Disco: 50 GB ou mais

### Preparacao do Ambiente
Preparacao do ambiente Ubuntu 20.04 + LTS:
- Instalacao do Servidor web Apache
 ```bash
sudo apt update
sudo apt -y upgrade
sudo apt install apache2
```

- Instalacao do Servidor MySQL
 ```bash
sudo apt install mysql-server
```

- Instalacao do PHP 8.2
 ```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt install php8.2
sudo php -v
sudo apt install php libapache2-mod-php php-mysql
sudo php -m
```

- Actualizacao do ficheiro 000-default.conf
 ```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

 ```bash
<VirtualHost *:80>
    # Define o diretório raiz para o site
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www

    # Configurações de log
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    # Outras diretivas podem ser configuradas aqui conforme necessário

    # Permitir acesso à pasta
    <Directory /var/www>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
 ```bash
sudo systemctl restart apache2
```


### Clonar o projeto

Para clonar o projecto acesse o link :

```bash
https://github.com/cleverdevelopper/fintech.git
```

```bash
cd /var/www
git clone https://github.com/cleverdevelopper/fintech.git
```

```bash
cd /var/www/fintech
sudo nano .env
```

- Modificar o ficheiro .env do sistema
```bash
URL=http://ip ou dominio/fintech
BD_HOST=127.0.0.1
BD_DATABASE=fintech_database
BD_CHARSET=utf8
DB_PORT=3306
BD_USERNAME=databse_username
BD_PASSWORD=databse_password
MAINTENANCE=false
```

- reiniciar o apache
```bash
sudo a2emod rewrite
sudo systemctl restart apache2
```

Observações:

- Você pode conferir o endereço dos outros serviços dentro do arquivo `.env` encontrado na raiz do projeto, como por exemplo o endereço e credenciais do Banco de Dados local ou o Frontend do Serviço de Email.

### Cadastro e Login de usuários

No ambiente de desenvolvimento você poderá tanto criar usuários manualmente (inclusive para receber e testar o email de ativação), quanto utilizar usuários pré-cadastrados e que já foram ativados para sua conveniência.

1. Após a clonagem do repositorio e a configuracao do .env
2. Cria-se a base de dados de acordo com o ficheiro .sql da raiz do projecto criando as tabelas e os trigers e as insercoes.


```bash
sudo mysql
CREATE DATABASE example_database;
CREATE USER 'example_user'@'%' IDENTIFIED WITH mysql_native_password BY 'password';
GRANT ALL ON example_database.* TO 'example_user'@'%';
exit
```

Acessando o mysql com o novo user
```bash
mysql -u example_user -p
```

Em seguida, criaremos as tabela.s A partir do console do MySQL, execute os comandos do ficheiro sql

## Rodar os testes

Há várias formas de rodar os testes dependendo do que você deseja fazer, mas o primeiro passo antes de fazer qualquer alteração no projeto é rodar os testes de forma geral para se certificar que tudo está passando como esperado.


## Histórico de Desenvolvimento

### Início do projeto

No início do projeto foram feitos brainstorms sobre o projecto que culminaram com o levantamento e analise dos requisitos do Sistema. Netes brainstorms colheu-se informações desde como a ideia iniciais do Fintech as contribuições no início do projeto, até as definições do layout e outras tomadas de decisão.

### Milestones

Milestones são marcos históricos do projeto para ajudar a guiar o desenvolvimento numa direção específica. 


Em caso do composer de ocorrer erros entre o php 8.2 e o 7.*
```bash
sudo apt-get purge php7.*
```
