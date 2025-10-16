# Changelog

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Semantic Versioning](https://semver.org/lang/pt-BR/).

## [Unreleased]

### Adicionado
- 📄 Documentação completa do projeto (ANALISE_PROJETO.md)
- 📖 README.md abrangente com instruções de instalação e uso
- 🤝 Guia de contribuição (CONTRIBUTING.md)
- ⚡ Guia de início rápido (QUICK_START.md)
- 🗄️ Migrações do banco de dados para tabelas principais:
  - `conversations` - Armazenamento de conversas
  - `messages` - Armazenamento de mensagens
  - `pdf_files` - Armazenamento de metadados de PDFs
- 🧪 Suite de testes completa para ChatController (13 testes)
- 🏭 Factories para models (Conversation, Message, PdfFile)
- 🔒 Validação de chave API DeepSeek no serviço
- 🛡️ Sanitização de entrada de usuários (proteção XSS)
- ✅ Validação de tamanho máximo de mensagens (4000 caracteres)
- 📝 Configuração DeepSeek no .env.example

### Modificado
- 🔐 Removida chave de API hardcoded do config/deepseek.php
- 🧹 Corrigido package.json (removida dependência PHP incorreta)
- 💬 Melhorada validação no ChatController
- 📦 Atualizada documentação do README

### Segurança
- 🔒 Chave de API DeepSeek não possui mais valor padrão
- 🛡️ Implementada sanitização de HTML em mensagens de usuário
- ✅ Adicionada validação de comprimento de mensagem
- 🔐 Proteção contra XSS em inputs de usuário

## [1.0.0] - 2024-01-01

### Adicionado
- 🎉 Release inicial do Chat-Dev
- 💬 Sistema de chat com IA (Professor Jubileu)
- 🤖 Integração com DeepSeek AI API
- 📄 Upload e análise de documentos PDF
- 👤 Sistema de autenticação completo (Laravel UI)
- 💾 Persistência de conversas e mensagens
- 🎨 Interface moderna com tema dark mode
- 📱 Design responsivo com Bootstrap 5
- 🔄 Histórico de conversas
- 🗑️ Funcionalidade de deletar conversas
- ⚙️ Configuração via variáveis de ambiente

### Funcionalidades
- Chat em tempo real com indicador de digitação
- Contexto automático de PDFs nas conversas
- Formatação de mensagens (Markdown básico)
- Sidebar com histórico de conversas
- Títulos automáticos para conversas
- Extração de texto de PDFs com contagem de páginas
- Sistema de autenticação seguro

### Técnico
- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Frontend**: Bootstrap 5.3 + Tailwind CSS 4.0
- **Build Tool**: Vite 7.x
- **Database**: SQLite (padrão)
- **AI API**: DeepSeek

---

## Tipos de Mudanças

- `Adicionado` - Para novas funcionalidades
- `Modificado` - Para mudanças em funcionalidades existentes
- `Descontinuado` - Para funcionalidades que serão removidas
- `Removido` - Para funcionalidades removidas
- `Corrigido` - Para correções de bugs
- `Segurança` - Para correções de vulnerabilidades

## Versionamento

Este projeto usa [Semantic Versioning](https://semver.org/):
- **MAJOR** (X.0.0) - Mudanças incompatíveis na API
- **MINOR** (0.X.0) - Adição de funcionalidades compatíveis
- **PATCH** (0.0.X) - Correções de bugs compatíveis

## Links

- [Unreleased]: https://github.com/Decksterfox/Chat-Dev/compare/v1.0.0...HEAD
- [1.0.0]: https://github.com/Decksterfox/Chat-Dev/releases/tag/v1.0.0
