# Guia de Contribuição

Obrigado por considerar contribuir com o Chat-Dev! Este documento fornece diretrizes para contribuir com o projeto.

## 🤝 Como Contribuir

### Reportando Bugs

Antes de criar uma issue de bug, verifique se já não existe uma issue similar. Ao criar uma issue, inclua:

- **Descrição clara** do problema
- **Passos para reproduzir** o bug
- **Comportamento esperado** vs **comportamento atual**
- **Screenshots** (se aplicável)
- **Ambiente**: SO, versão do PHP, versão do Laravel
- **Logs de erro** (se houver)

### Sugerindo Melhorias

Sugestões de melhorias são bem-vindas! Ao criar uma issue de feature request:

- Explique **por que** essa melhoria seria útil
- Forneça **exemplos de uso**
- Considere se **outras pessoas** também se beneficiariam

### Pull Requests

1. **Fork** o repositório
2. **Clone** seu fork localmente
3. **Crie uma branch** a partir de `main`:
   ```bash
   git checkout -b feature/minha-feature
   # ou
   git checkout -b fix/meu-bug-fix
   ```

4. **Faça suas alterações** seguindo os padrões do projeto
5. **Teste** suas alterações:
   ```bash
   composer test
   php artisan test
   ```

6. **Commit** suas mudanças com mensagens descritivas:
   ```bash
   git commit -m "feat: adiciona funcionalidade X"
   git commit -m "fix: corrige bug Y"
   git commit -m "docs: atualiza README"
   ```

7. **Push** para seu fork:
   ```bash
   git push origin feature/minha-feature
   ```

8. Abra um **Pull Request** no repositório original

## 📝 Padrões de Código

### PHP (PSR-12)

Seguimos o padrão PSR-12 para código PHP:

```php
<?php

namespace App\Services;

class MinhaClasse
{
    private $propriedade;

    public function __construct($propriedade)
    {
        $this->propriedade = $propriedade;
    }

    public function meuMetodo(): string
    {
        return $this->propriedade;
    }
}
```

### Laravel Best Practices

- Use **Eloquent ORM** em vez de queries SQL diretas
- Utilize **Form Requests** para validação complexa
- Mantenha **controllers enxutos**, mova lógica para Services
- Use **Resource Controllers** quando apropriado
- Siga as **convenções de nomenclatura** do Laravel

### JavaScript

- Use **camelCase** para variáveis e funções
- Use **PascalCase** para classes
- Documente funções complexas
- Evite variáveis globais

### CSS

- Prefira **classes utilitárias** do Tailwind/Bootstrap
- Use **nomenclatura descritiva**
- Mantenha **especificidade baixa**

## 🧪 Testes

Todo código novo deve incluir testes:

### Testes de Feature (Feature Tests)

```php
public function test_user_can_send_message(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->post('/chat/send', [
            'message' => 'Hello, Professor Jubileu!'
        ]);
    
    $response->assertStatus(200);
    $this->assertDatabaseHas('messages', [
        'content' => 'Hello, Professor Jubileu!',
        'sender' => 'user'
    ]);
}
```

### Testes Unitários (Unit Tests)

```php
public function test_deepseek_service_formats_message(): void
{
    $service = new DeepSeekService();
    $result = $service->formatMessage('Test message');
    
    $this->assertIsString($result);
    $this->assertNotEmpty($result);
}
```

## 📚 Documentação

- Documente **funções públicas** com PHPDoc
- Atualize o **README.md** se adicionar features
- Mantenha **comentários concisos** e úteis

```php
/**
 * Envia uma mensagem para o chat e obtém resposta da IA.
 *
 * @param string $message Mensagem do usuário
 * @param int|null $conversationId ID da conversa (opcional)
 * @return array Resposta contendo a resposta do bot
 * @throws \RuntimeException Se a API falhar
 */
public function sendMessage(string $message, ?int $conversationId = null): array
{
    // Implementação
}
```

## 🔍 Revisão de Código

Seu PR será revisado considerando:

- ✅ **Funcionalidade**: O código faz o que promete?
- ✅ **Testes**: Há cobertura de testes adequada?
- ✅ **Estilo**: Segue os padrões do projeto?
- ✅ **Performance**: É eficiente?
- ✅ **Segurança**: Não introduz vulnerabilidades?
- ✅ **Documentação**: Está bem documentado?

## 🚫 O Que Evitar

- ❌ Commits com mensagens vagas ("fix", "update")
- ❌ PRs muito grandes (divida em PRs menores)
- ❌ Código sem testes
- ❌ Hardcoded secrets ou credenciais
- ❌ Mudanças que quebram compatibilidade sem discussão
- ❌ Código comentado (remova código morto)

## 💡 Boas Práticas

### Mensagens de Commit

Use [Conventional Commits](https://www.conventionalcommits.org/):

```
feat: adiciona upload de múltiplos PDFs
fix: corrige erro ao deletar conversa
docs: atualiza guia de instalação
style: formata código com Laravel Pint
refactor: simplifica lógica do ChatController
test: adiciona testes para DeepSeekService
chore: atualiza dependências
```

### Branches

- `main` - código em produção
- `develop` - próxima versão em desenvolvimento
- `feature/*` - novas funcionalidades
- `fix/*` - correções de bugs
- `hotfix/*` - correções urgentes em produção

## 🏗️ Estrutura de um PR Ideal

```markdown
## Descrição
Breve descrição do que o PR faz.

## Motivação
Por que essa mudança é necessária?

## Mudanças
- Item 1
- Item 2
- Item 3

## Screenshots (se aplicável)
![Descrição](url-da-imagem)

## Checklist
- [ ] Código segue os padrões do projeto
- [ ] Testes foram adicionados/atualizados
- [ ] Documentação foi atualizada
- [ ] Todos os testes passam
- [ ] Sem conflitos de merge
```

## 🐛 Debugging

Para facilitar o debugging:

```bash
# Ativar modo debug
php artisan config:clear
php artisan cache:clear

# Ver logs em tempo real
php artisan pail

# Usar Tinker para testar código
php artisan tinker
```

## 📦 Dependências

Ao adicionar novas dependências:

1. **Justifique** a necessidade
2. Verifique a **licença**
3. Considere o **tamanho** do bundle
4. Avalie **alternativas** mais leves
5. Documente no **README**

## 🔒 Segurança

Se você descobrir uma vulnerabilidade de segurança:

- **NÃO** abra uma issue pública
- Envie um email para [segurança@email.com]
- Aguarde confirmação antes de divulgar
- Será creditado na correção

## 📞 Dúvidas?

- Abra uma **Discussion** no GitHub
- Consulte a **documentação** do Laravel
- Pergunte na **comunidade**

## 🎉 Reconhecimento

Contribuidores são reconhecidos:
- No arquivo **CONTRIBUTORS.md**
- Nos **release notes**
- Na seção de agradecimentos

---

**Obrigado por contribuir com o Chat-Dev!** 🚀

Cada contribuição, por menor que seja, faz diferença. Seja bem-vindo à comunidade!
