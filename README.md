# Projeto para controlar estoque de cerveja 1.0

### Projeto criando com Laravel Sail(Docker) é também Filament para criação do front.

---
### CONFIGURANDO PROJETO EM UM NOVO AMBIENTE
1. Copie o seu `.env.example` para `.env`
2. Instale as dependências do composer com o seguinte comando:
```bash
docker run --rm \
   -u "$(id -u):$(id -g)" \
   -v "$(pwd):/var/www/html" \
   -w /var/www/html \
   laravelsail/php83-composer:latest \
   composer install --ignore-platform-reqs
```
3. Suba o seu projeto com o comando `sail up -d` lembrando que o -d, o terminal não fique travado.
caso o camando não funcione, tente esse `./vendor/bin/sail up -d`

4. Agora vamos gerar a APP_KEY do Laravel usando o camando 
`sail artisan key:generate` 
5. Acesse o browser em `hhtp://localhost` para conferir o resultado

6. Agora vamos criar o bando de dados usando o camando `sail artisan migrate --seed` 
ou `./vendor/bin/sail artisan migrate --seed`
---

### Pendencias

1.adicionar campos CPF, Celular,Data de Nascimento, na tela de cadastro `http://localhost/app/register`
2. Ao cadastrar só maiores de 18 anos
