# crud-pacientes-om30
crud-pacientes-om30


CRUD para gerencamento de pacientes.

Instalação:

1.Clone o projeto

    git clone https://github.com/DurvalPaicheco/crud-pacientes-om30

2.renomear seu arquivo .env.example para .env, este passo abaixo é para linux, caso esteja em windows basta copiar colar e remear o arquivo.

    cp .env.example .env

3.Instale as dependências 

    composer install && npm install && npm run build dev

4.Crie o link simbólico 

    composer artisan storage:link

5.Rode o container

    docker-compose up -d --build


> Após subir todos os containers accesse:

<h4>127.0.0.1:8080</h4>


######  O arquivo de rotas(endpoint.json) se encontra na raiz do projeto.

###### Também é possivél editar configurações do nginx na pasta files/default.conf.  
