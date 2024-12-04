# Starsoft API
### Api para gerenciar tarefas de usuários

## Instruções
1. Crie um arquivo .env a partir do .env.example utilizando o comando abaixo:

``cp .env.example .env``

2. Inicialize os containers

``docker-compose up``

3. Acesse o container do laravel

``docker-compose exec -it laravel-app bash``

4. Execute as migrations

``php artisan migrate``

## Documentação da API
A documentação da API pode ser visualizada na rota:

``http://localhost:8080/api/docs``

## **CRUD Tasks**
1. Faça o registro de um usuário
2. Após isso, efetue login e copie o token retornado
3. Inclua o token no Authorization Bearer Token
4. Agora você já pode cadastrar, editar, visualizar e excluir suas tarefas