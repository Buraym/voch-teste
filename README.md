📌 Voch TECH Teste - Documentação

Este projeto foi desenvolvido em Laravel e utiliza MySQL como banco de dados.

🚀 1. Requisitos

Antes de instalar a aplicação, certifique-se de ter instalado:

PHP 8.1+

Composer

MySQL 5.7+ ou MariaDB

Node.js + npm

📥 2. Clonar o Repositório

# Clone este repositório

git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio

🔧 3. Instalar Dependências

# Instalar pacotes PHP

composer install

# Instalar pacotes do frontend Livewire

npm install && npm run build

⚙️ 4. Configurar o Banco de Dados

Criar o banco de dados MySQL:

CREATE DATABASE vochtestedb;

Configurar o arquivo .env (já está configurado para MySQL, mas confira os detalhes):

APP_TIMEZONE="America/Sao_Paulo"

APP_LOCALE=pt_BR

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vochtestedb
DB_USERNAME=root
DB_PASSWORD=root

Executar as migrations e seeders:

php artisan migrate --seed

Isso criará as tabelas necessárias no banco de dados.

🔑 5. Gerar a Chave da Aplicação

php artisan key:generate

🚀 6. Iniciar o Servidor

php artisan serve

A aplicação estará disponível em http://127.0.0.1:8000.

🛠 7. Comandos Úteis

Limpar caches

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
