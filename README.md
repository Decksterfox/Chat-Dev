# Chat-Dev - Professor Jubileu

## 📖 Sobre o Projeto

**Chat-Dev** é uma aplicação web educacional que implementa um assistente de IA especializado em ensinar programação. O "Professor Jubileu" é um chatbot inteligente desenvolvido para auxiliar estudantes de Análise e Desenvolvimento de Sistemas em seu aprendizado, com capacidade de analisar documentos PDF e fornecer explicações contextualizadas.

## ✨ Funcionalidades

- 💬 **Chat em Tempo Real**: Interface moderna e intuitiva inspirada em editores de código
- 🤖 **Assistente de IA**: Integração com DeepSeek AI para respostas inteligentes
- 📄 **Análise de PDF**: Upload e extração de texto de documentos PDF (até 10MB)
- 💾 **Histórico Persistente**: Todas as conversas são salvas e podem ser acessadas posteriormente
- 👤 **Sistema de Autenticação**: Registro, login e gerenciamento de usuários
- 🎨 **Interface Dark Mode**: Design moderno com tema escuro
- 📱 **Responsivo**: Funciona perfeitamente em desktop e dispositivos móveis

## 🛠️ Tecnologias

### Backend
- **Laravel 12.x** - Framework PHP
- **PHP 8.2+** - Linguagem de programação
- **SQLite** - Banco de dados (padrão)
- **DeepSeek AI** - API de inteligência artificial

### Frontend
- **Bootstrap 5.3** - Framework CSS
- **Tailwind CSS 4.0** - Utility-first CSS
- **Vite 7.x** - Build tool
- **Font Awesome 6.0** - Ícones
- **JavaScript Vanilla** - Interatividade

### Bibliotecas Principais
- `smalot/pdfparser` - Extração de texto de PDFs
- `laravel/ui` - Interface de autenticação
- `laravel/tinker` - Console interativo

## 📋 Pré-requisitos

- PHP 8.2 ou superior
- Composer
- Node.js 18+ e npm
- SQLite (ou MySQL/PostgreSQL)
- Chave de API do DeepSeek

## 🚀 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/Decksterfox/Chat-Dev.git
cd Chat-Dev
```

### 2. Instale as dependências

```bash
# Dependências PHP
composer install

# Dependências JavaScript
npm install
```

### 3. Configure o ambiente

```bash
# Copie o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 4. Configure o banco de dados

Para SQLite (padrão):
```bash
# Crie o arquivo do banco de dados
touch database/database.sqlite
```

Para MySQL/PostgreSQL, edite o arquivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chatdev
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Configure a API DeepSeek

Edite o arquivo `.env` e adicione sua chave de API:
```env
DEEPSEEK_API_KEY=sua_chave_api_aqui
DEEPSEEK_BASE_URL=https://api.deepseek.com/v1
```

Para obter uma chave de API, visite: [https://platform.deepseek.com](https://platform.deepseek.com)

### 6. Execute as migrações

```bash
php artisan migrate
```

### 7. Crie o link simbólico para storage

```bash
php artisan storage:link
```

### 8. Compile os assets

```bash
# Para desenvolvimento
npm run dev

# Para produção
npm run build
```

### 9. Inicie o servidor

```bash
php artisan serve
```

A aplicação estará disponível em: `http://localhost:8000`

## 📱 Uso

1. **Registro**: Acesse `/register` e crie uma conta
2. **Login**: Faça login em `/login`
3. **Chat**: Comece a conversar com o Professor Jubileu
4. **Upload de PDF**: Clique no ícone de anexo para fazer upload de documentos
5. **Histórico**: Suas conversas ficam salvas na barra lateral

## 🧪 Testes

```bash
# Executar todos os testes
php artisan test

# Executar testes com cobertura
php artisan test --coverage

# Executar testes específicos
php artisan test --filter=ChatControllerTest
```

## 📂 Estrutura do Projeto

```
Chat-Dev/
├── app/
│   ├── Http/Controllers/
│   │   └── ChatController.php       # Lógica principal do chat
│   ├── Models/
│   │   ├── Conversation.php         # Modelo de conversas
│   │   ├── Message.php              # Modelo de mensagens
│   │   └── PdfFile.php              # Modelo de PDFs
│   └── Services/
│       └── DeepSeekService.php      # Integração com IA
├── database/migrations/             # Migrações do banco
├── resources/
│   └── views/chat/app.blade.php    # Interface do chat
├── routes/web.php                  # Rotas da aplicação
└── config/deepseek.php             # Configuração da API
```

## 🔐 Segurança

- ✅ Autenticação Laravel padrão
- ✅ Proteção CSRF em todos os formulários
- ✅ Validação de uploads de arquivos
- ✅ Sanitização de entrada de usuários
- ✅ Proteção contra SQL Injection (Eloquent ORM)
- ⚠️ **Importante**: Nunca commite o arquivo `.env` com suas chaves de API

## 🤝 Contribuindo

Contribuições são bem-vindas! Para contribuir:

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

## 📝 Roadmap

- [ ] Implementar WebSockets para chat em tempo real
- [ ] Adicionar suporte para múltiplos modelos de IA
- [ ] Exportação de conversas (PDF, TXT)
- [ ] Temas personalizáveis
- [ ] Suporte multilíngue
- [ ] Sistema de busca em conversas
- [ ] Integração com GitHub Copilot
- [ ] Modo de colaboração entre usuários

## 🐛 Problemas Conhecidos

- Não há paginação no histórico de conversas
- Sem cache de respostas frequentes
- Falta de testes de integração completos

Veja a [lista de issues](https://github.com/Decksterfox/Chat-Dev/issues) para mais detalhes.

## 📄 Licença

Este projeto está licenciado sob a [Licença MIT](https://opensource.org/licenses/MIT).

## 👥 Autores

- **Decksterfox** - *Desenvolvimento inicial* - [GitHub](https://github.com/Decksterfox)

## 🙏 Agradecimentos

- Laravel Framework
- DeepSeek AI
- Bootstrap e Tailwind CSS
- Comunidade open source

## 📞 Contato

Para dúvidas ou sugestões, abra uma [issue](https://github.com/Decksterfox/Chat-Dev/issues) no GitHub.

---

**Desenvolvido com ❤️ para estudantes de programação**
