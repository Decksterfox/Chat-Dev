# Guia de Início Rápido - Chat-Dev

Este guia ajudará você a configurar e executar o projeto Chat-Dev em minutos.

## ⚡ Início Rápido (5 minutos)

### Pré-requisitos

Certifique-se de ter instalado:
- ✅ PHP 8.2+
- ✅ Composer
- ✅ Node.js 18+
- ✅ Git

### Passo a Passo

```bash
# 1. Clone o projeto
git clone https://github.com/Decksterfox/Chat-Dev.git
cd Chat-Dev

# 2. Instale dependências
composer install && npm install

# 3. Configure o ambiente
cp .env.example .env
php artisan key:generate
touch database/database.sqlite

# 4. Configure sua chave DeepSeek no .env
# DEEPSEEK_API_KEY=sua_chave_aqui

# 5. Execute migrações
php artisan migrate

# 6. Link de storage
php artisan storage:link

# 7. Build dos assets
npm run build

# 8. Inicie o servidor
php artisan serve
```

Acesse: http://localhost:8000

## 🔑 Obtendo Chave da API DeepSeek

1. Visite: https://platform.deepseek.com
2. Crie uma conta ou faça login
3. Navegue até "API Keys"
4. Clique em "Create API Key"
5. Copie a chave e adicione ao seu `.env`:
   ```env
   DEEPSEEK_API_KEY=sk-seu-token-aqui
   ```

## 🚀 Modo Desenvolvimento

Para desenvolvimento ativo com hot reload:

```bash
# Terminal 1 - Servidor Laravel
php artisan serve

# Terminal 2 - Vite (hot reload)
npm run dev
```

Ou use o comando combinado:

```bash
composer dev
```

Isso iniciará:
- 🌐 Servidor web (porta 8000)
- 📦 Queue worker
- 📊 Logs em tempo real
- ⚡ Vite com hot reload

## 🧪 Executando Testes

```bash
# Todos os testes
php artisan test

# Testes específicos
php artisan test --filter=ChatControllerTest

# Com cobertura
php artisan test --coverage
```

## 📝 Primeiro Uso

1. **Registre-se**: Acesse `/register` e crie uma conta
2. **Faça Login**: Entre com suas credenciais
3. **Comece a Conversar**: Pergunte algo ao Professor Jubileu!
4. **Upload de PDF**: Clique no ícone 📎 para anexar documentos

## 🐛 Problemas Comuns

### Erro: "DEEPSEEK_API_KEY not configured"

**Solução**: Configure a chave de API no arquivo `.env`

### Erro: "SQLSTATE[HY000]: General error: 1 no such table"

**Solução**: Execute as migrações
```bash
php artisan migrate
```

### Erro: "The stream or file could not be opened"

**Solução**: Configure permissões
```bash
chmod -R 775 storage bootstrap/cache
```

### Assets não carregam

**Solução**: Execute o build
```bash
npm run build
php artisan storage:link
```

## 📦 Estrutura de Pastas

```
Chat-Dev/
├── app/                    # Código da aplicação
│   ├── Http/Controllers/   # Controladores
│   ├── Models/             # Modelos Eloquent
│   └── Services/           # Lógica de negócio
├── database/
│   ├── migrations/         # Schemas do banco
│   └── factories/          # Factories para testes
├── resources/
│   ├── views/              # Templates Blade
│   └── js/                 # JavaScript
├── routes/                 # Definição de rotas
└── tests/                  # Testes automatizados
```

## 🎯 Comandos Úteis

```bash
# Limpar caches
php artisan optimize:clear

# Ver rotas
php artisan route:list

# Console interativo
php artisan tinker

# Logs em tempo real
php artisan pail

# Executar queue
php artisan queue:work

# Verificar código (linting)
./vendor/bin/pint
```

## 🔧 Configuração Avançada

### MySQL/PostgreSQL

Edite `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chatdev
DB_USERNAME=root
DB_PASSWORD=senha
```

### Redis (Cache/Queue)

```bash
# Instalar Redis
sudo apt install redis-server

# Configurar no .env
CACHE_STORE=redis
QUEUE_CONNECTION=redis
```

### Docker (Opcional)

```bash
# Iniciar com Laravel Sail
./vendor/bin/sail up -d

# Executar comandos
./vendor/bin/sail artisan migrate
./vendor/bin/sail composer install
```

## 📚 Próximos Passos

1. 📖 Leia a [Documentação Completa](README.md)
2. 🔍 Explore a [Análise do Projeto](ANALISE_PROJETO.md)
3. 🤝 Veja o [Guia de Contribuição](CONTRIBUTING.md)
4. 💻 Comece a desenvolver!

## 🆘 Precisa de Ajuda?

- 📖 [Documentação do Laravel](https://laravel.com/docs)
- 🐛 [Issues do Projeto](https://github.com/Decksterfox/Chat-Dev/issues)
- 💬 [Discussões](https://github.com/Decksterfox/Chat-Dev/discussions)

## 🎓 Recursos de Aprendizado

### Laravel
- [Laravel Bootcamp](https://bootcamp.laravel.com)
- [Laracasts](https://laracasts.com)
- [Laravel News](https://laravel-news.com)

### PHP
- [PHP: The Right Way](https://phptherightway.com)
- [PHP.net Documentation](https://www.php.net/docs.php)

### Frontend
- [Bootstrap Docs](https://getbootstrap.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)

---

**Pronto para começar!** 🚀

Se encontrar problemas, abra uma [issue](https://github.com/Decksterfox/Chat-Dev/issues) no GitHub.
