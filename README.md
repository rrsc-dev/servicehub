## Sobre o Sistema
 
O **ServiceHub** é uma aplicação web para gestão de ordens de serviço. Usuários autenticados podem cadastrar empresas, organizar projetos por empresa e abrir tickets por projeto. Cada ticket possui um detalhe técnico associado e suporta upload de anexos que são processados de forma assíncrona via fila.

## Funcionalidades
 
**Autenticação**
- Registro e login de usuários via Laravel Breeze
- Perfil de usuário com dados adicionais (telefone, cargo)
**Empresas (Companies)**
- Listar todas as empresas
- Criar nova empresa
- Editar empresa existente
- Excluir empresa
**Projetos (Projects)**
- Listar projetos vinculados a uma empresa
- Criar projeto associado a uma empresa
- Editar projeto existente
- Excluir projeto
**Tickets**
- Listar tickets de um projeto
- Criar ticket com upload opcional de anexo (JSON ou texto)
- Editar ticket existente
- Excluir ticket
- Cada ticket possui um `TicketDetail` com informações técnicas detalhadas
**Processamento Assíncrono (Queue)**
- Job que processa o anexo enviado no ticket
- Adiciona automaticamente mais informações ao `TicketDetail`

| Tecnologia | Versão |
|---|---|
| PHP | 8.5 |
| Laravel | 13 |
| Laravel Breeze | — |
| Laravel Sail | — |
| Inertia.js | — |
| Vue.js | 3 |
| MySQL | 8 |
| Queue Driver | database |
| Node.js | ≥ 20 |
| Docker | ≥ 24 |

## Requisitos
 
- **Windows 11** com **WSL2 + Ubuntu** habilitado
- **Docker Desktop** instalado e com integração WSL2 ativa
- **Git** instalado no WSL
- Portas `80`, `3306` e `6379` disponíveis na máquina
> ⚠️ Todos os comandos abaixo devem ser executados dentro do terminal **WSL/Ubuntu**.
 
---

## Instalação e Configuração
 
### 1. Clone o repositório
 
```bash
git clone git@github.com:seu-usuario/servicehub.git
cd servicehub
```
 
### 2. Instale as dependências PHP (sem precisar do PHP local)
 
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php85-composer:latest \
    composer install --ignore-platform-reqs
```
 
### 3. Copie o arquivo de ambiente
 
```bash
cp .env.example .env
```
 
### 4. Configure o `.env`
 
Abra o `.env` e ajuste as variáveis abaixo:
 
```env
APP_NAME=ServiceHub
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080
APP_PORT=8080
 
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=servicehub
DB_USERNAME=sail
DB_PASSWORD=password
 
CACHE_DRIVER=redis
QUEUE_CONNECTION=database
 
REDIS_HOST=redis
REDIS_PORT=6379
 
WWWUSER=1000
WWWGROUP=1000
```
 
---
 
## Executando o Projeto
 
Execute os comandos **nesta ordem** para iniciar o ambiente completo:
 
### 1. Suba os containers
 
```bash
./vendor/bin/sail up -d
```
 
### 2. Gere a chave da aplicação
 
```bash
./vendor/bin/sail artisan key:generate
```
 
### 3. Execute as migrations
 
```bash
./vendor/bin/sail artisan migrate
```
 
### 4. (Opcional) Popule o banco com dados de exemplo
 
```bash
./vendor/bin/sail artisan db:seed
```
 
### 5. Instale as dependências do Node.js
 
```bash
./vendor/bin/sail npm install
```
 
### 6. Compile os assets — abra um terminal e deixe rodando
 
```bash
./vendor/bin/sail npm run dev
```
 
### 7. Inicie o worker da fila — abra outro terminal e deixe rodando
 
```bash
./vendor/bin/sail artisan queue:work
```
 
> ✅ A aplicação estará disponível em **http://localhost:8080**
 
---
 
## Comandos Úteis
 
### Sail
 
```bash
# Iniciar containers em background
./vendor/bin/sail up -d
 
# Parar containers
./vendor/bin/sail down
 
# Parar e remover volumes (reseta o banco)
./vendor/bin/sail down -v
 
# Ver logs dos containers
./vendor/bin/sail logs
 
# Acessar shell do container
./vendor/bin/sail shell
```
 
### Artisan
 
```bash
# Listar todas as rotas
./vendor/bin/sail artisan route:list
 
# Criar migration
./vendor/bin/sail artisan make:migration create_example_table
 
# Executar migrations
./vendor/bin/sail artisan migrate
 
# Reverter última migration
./vendor/bin/sail artisan migrate:rollback
 
# Resetar e reexecutar todas as migrations
./vendor/bin/sail artisan migrate:fresh
 
# Resetar, reexecutar migrations e rodar seeders
./vendor/bin/sail artisan migrate:fresh --seed
 
# Limpar todos os caches
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear
 
# Criar um novo Job
./vendor/bin/sail artisan make:job NomeDoJob
 
# Iniciar worker da fila
./vendor/bin/sail artisan queue:work
 
# Iniciar worker com número máximo de tentativas
./vendor/bin/sail artisan queue:work --tries=3
 
# Reprocessar jobs falhos
./vendor/bin/sail artisan queue:retry all
 
# Limpar jobs falhos
./vendor/bin/sail artisan queue:flush
```
 
### NPM
 
```bash
# Instalar dependências
./vendor/bin/sail npm install
 
# Ambiente de desenvolvimento com hot reload
./vendor/bin/sail npm run dev
 
# Build para produção
./vendor/bin/sail npm run build
```
 
### Composer
 
```bash
# Instalar dependências
./vendor/bin/sail composer install
 
# Adicionar pacote
./vendor/bin/sail composer require nome/pacote
 
# Atualizar dependências
./vendor/bin/sail composer update
```
 
---
 
## Testes
 
O projeto utiliza **PHPUnit** com cobertura de modelos, serviços, jobs e rotas.
 
### Executar todos os testes
 
```bash
./vendor/bin/sail artisan test
```
 
### Executar com saída detalhada
 
```bash
./vendor/bin/sail artisan test --verbose
```
 
### Executar apenas testes unitários
 
```bash
./vendor/bin/sail artisan test --testsuite=Unit
```
 
### Executar apenas testes de feature
 
```bash
./vendor/bin/sail artisan test --testsuite=Feature
```
 
### Filtrar por nome de teste
 
```bash
# Apenas testes de modelos
./vendor/bin/sail artisan test --filter ModelTest
 
# Apenas testes de jobs
./vendor/bin/sail artisan test --filter JobTest
```
 
### Executar com relatório de cobertura
 
```bash
./vendor/bin/sail artisan test --coverage
```