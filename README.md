# OLW-1-FILAMENT

Projeto Laravel/Filament para consumo da API de cerveja Punk API. Este projeto foi baseado na OLW (Open Laravel Week) promovida pela equipe do Beer and Code.

![screenshot]()

## Introdução

Neste projeto, o usuário pode consultar as cervejas no menu Beers e realizar filtros de busca. Ao exportar os resultados, um arquivo Excel é gerado e salvo no bucket do Minio. Uma notificação é enviada para o usuário via email com o arquivo anexo.

## Instalação

Clonar o repositório:

```bash
git clone https://github.com/leandrocfe/olw-1-filament.git
```

Acessar a pasta do repositório:

```bash
cd olw-1-filament
```

Copiar o arquivo env.example e nomear para .env:

```bash
cp .env.example .env
```

O projeto utiliza o Laravel Sail. Para mais informações, acesse [https://laravel.com/docs/9.x/sail](https://laravel.com/docs/9.x/sail).

Rode os seguintes comandos para instalar os pacotes necessários e configurar os serviços da aplicação:

```bash
composer install
sail up -d
```

Serviços utilizados:
laravel.test
mysql
redis
minio
mailhog

Execute as migrações necessárias com o comando:

```bash
sail php artisan migrate --seed
```

Crie uma conta de acesso do Painel Administrativo do Filament:

```bash
sail php artisan make:filament-user
```

Compile os assets:

```bash
sail npm install
sail npm run build
```

Acesse o Minio [http://localhost:9000](http://localhost:9000) com as credenciais *sail | password*

Crie um bucket com o nome *local*
Mude o Access Policy do bucket para *public*.

## Acessando a aplicação

Com o projeto instalado e configurado, você pode acessar no browser a url [http://localhost/admin](http://localhost/admin) e logar.

O projeto utiliza filas para processar o arquivo xls e enviar a notificação por email. Desta forma, você precisa deixar esse comando ativo:
```bash
sail php artisan queue:work
```

Caso tenha alguma dúvida ou problema, envie um email: *leandrocfe@gmail.com*

## License
[MIT](https://choosealicense.com/licenses/mit/)
