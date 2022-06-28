<p align="center"><img src="https://raw.githubusercontent.com/JuanCalavera/list_products/master/images/aztec-logo.png" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<img src="https://img.shields.io/static/v1?label=version&message=1.0&color=informational"/>
<img src="https://img.shields.io/static/v1?label=type&message=api&color=important"/>


## Sobre o Projeto

O projeto é simplesmente uma api de lista de compras em PHP usando o framework Laravel. Onde você tem uma lista nomeada, e dentro de cada lista há seus respectivos produtos.


## Iniciando o Projeto

Para iniciar a usar este projeto é necessário ter o composer instalado, e com ele instalado você insere o seguinte o comando em seu terminal na pasta raiz do seu projeto:

```
composer install
```
Após isso você irá pegar o arquivo <b>.env.example</b> e renomeá-lo para <b>.env</b> e fará uma conexão com uma base de dados configurando ele:

```
DB_CONNECTION=<TIPO DE TABELA>
DB_HOST=<HOST DA CONEXÃO>
DB_PORT=<PORTA>
DB_DATABASE=<NOME DA BASE DE DADOS>
DB_USERNAME=<USUÁRIO DA CONEXÃO>
DB_PASSWORD=<SENHA DA CONEXÃO>
```
E por último para que a base de dados esteja parametrizada ao projeto o camando a ser utilizado será:
```
php artisan migrate
```
## Usando o projeto

Inicie o servidor do projeto pelo comando:
```
php artisan serve
```
Use qualquer software de sua preferência para fazer requisições nas rotas que forem mostradas aqui.

# Lista
## Funções
### Adicionar Lista
Para iniciar nossa lista teremos que adiciona-lá pela url:
```
POST | http://127.0.0.1:8000/api/lista/add

{
    title: TITULO_DA_LISTA
}
```
Resposta:
```
{
	"title": "Lista da Vovó",
	"updated_at": "2022-06-28T13:48:25.000000Z",
	"created_at": "2022-06-28T13:48:25.000000Z",
	"id": 10
}
```
### Verficar todas as listas
```
GET | http://127.0.0.1:8000/api/lista/
```
Resposta:
```
[
	{
		"0": {
			"id": 10,
			"title": "Lista da Mamãe",
			"created_at": "2022-06-28T13:48:25.000000Z",
			"updated_at": "2022-06-28T14:18:53.000000Z"
		},
		"external_reference": [
			{
				"id": 14,
				"name_product": "Biscoito(não bolacha)",
				"quantity_product": 2,
				"list_id": 10,
				"created_at": "2022-06-28T14:04:53.000000Z",
				"updated_at": "2022-06-28T14:04:53.000000Z"
			}
		]
	}
]
```
Neste caso o <b>external_reference</b> retorna os produtos atrelados a lista.
### Checar uma única lista
Você pode buscar uma única lista pelo ID

```
GET | http://127.0.0.1:8000/api/lista/$LIST_ID
```
Resposta
```
{
	"list": {
		"id": 10,
		"title": "Lista da Vovó",
		"created_at": "2022-06-28T13:48:25.000000Z",
		"updated_at": "2022-06-28T13:48:25.000000Z"
	},
	"products": [
		{
			"id": 13,
			"name_product": "Toddy",
			"quantity_product": 2,
			"list_id": 10,
			"created_at": "2022-06-28T14:04:26.000000Z",
			"updated_at": "2022-06-28T14:04:26.000000Z"
		},
		{
			"id": 14,
			"name_product": "Biscoito(não bolacha)",
			"quantity_product": 2,
			"list_id": 10,
			"created_at": "2022-06-28T14:04:53.000000Z",
			"updated_at": "2022-06-28T14:04:53.000000Z"
		}
	]
}
```
Aqui ocorre a mesma coisa, ele retorna os produtos atrelados a lista.

### Atualizar a lista
```
POST | http://127.0.0.1:8000/api/lista/atualizar/$LIST_ID

{
    title: TITULO_DA_LISTA
}
```
Resposta
```
{
	"message": "Alterado o título de Lista da Vovó para Lista da Mamãe"
}
```
### Deletar Lista
Quando se deleta uma lista você estará também deletando os produtos atrelados a ela, então cuidado ao usar essa deleção.

```
DELETE | http://127.0.0.1:8000/api/lista/deletar/$LIST_ID
```
Resposta
```
{
	"message_list": "Deletado a lista Lista da Vovó",
	"0": [
		{
			"message_product": "Deletado o produto Kinder Ovo"
		},
		{
			"message_product": "Deletado o produto Toddy"
		}
	]
}
```
### Duplicar Lista
Você pode duplicar uma lista com seus respectivos produtos.
```
GET | http://127.0.0.1:8000/api/lista/duplicar/$LIST_ID
```
Resposta
```
[
	{
		"title": "Lista da Vovó",
		"updated_at": "2022-06-28T13:29:40.000000Z",
		"created_at": "2022-06-28T13:29:40.000000Z",
		"id": 8
	},
	[
		{
			"name_product": "Toddy",
			"quantity_product": 2,
			"list_id": 8,
			"updated_at": "2022-06-28T13:29:40.000000Z",
			"created_at": "2022-06-28T13:29:40.000000Z",
			"id": 9
		},
		{
			"name_product": "Kinder Ovo",
			"quantity_product": 1,
			"list_id": 8,
			"updated_at": "2022-06-28T13:29:40.000000Z",
			"created_at": "2022-06-28T13:29:40.000000Z",
			"id": 10
		}
	]
]
```
# Produtos

### Criar produtos a partir de uma lista
Neste caso em específico é possível inserir um produto diretamente a lista usando a rota da lista:
```
POST | http://127.0.0.1:8000/api/lista/$LIST_ID/adicionar-produto/

{
    "name_product": NOME_DO_PRODUTO,
	"quantity_product": QUANTIDADE_DO_PRODUTO,
}
```
Resposta
```
{
	"name_product": "Biscoito(não bolacha)",
	"quantity_product": "2",
	"list_id": 10,
	"updated_at": "2022-06-28T14:04:53.000000Z",
	"created_at": "2022-06-28T14:04:53.000000Z",
	"id": 14
}
```
Outra maneira é criar por outra rota mas especificando o id da lista nas requisições
```
POST | http://127.0.0.1:8000/api/produtos/add

{
    "name_product": NOME_DO_PRODUTO,
	"quantity_product": QUANTIDADE_DO_PRODUTO,
	"list_id": ID_DA_LISTA
}
```
Resposta
```
{
	"name_product": "Energético",
	"quantity_product": "40",
	"list_id": "5",
	"updated_at": "2022-06-28T21:43:08.000000Z",
	"created_at": "2022-06-28T21:43:08.000000Z",
	"id": 15
}
```
### Listar todos os produtos

```
GET | http://127.0.0.1:8000/api/produtos/
```
Resposta
```
[
	{
		"0": {
			"id": 13,
			"name_product": "Toddy",
			"quantity_product": 2,
			"list_id": 10,
			"created_at": "2022-06-28T14:04:26.000000Z",
			"updated_at": "2022-06-28T14:04:26.000000Z"
		},
		"external_reference": {
			"id": 10,
			"title": "Lista da Mamãe",
			"created_at": "2022-06-28T13:48:25.000000Z",
			"updated_at": "2022-06-28T14:18:53.000000Z"
		}
	},
	{
		"0": {
			"id": 14,
			"name_product": "Biscoito(não bolacha)",
			"quantity_product": 2,
			"list_id": 10,
			"created_at": "2022-06-28T14:04:53.000000Z",
			"updated_at": "2022-06-28T14:04:53.000000Z"
		},
		"external_reference": {
			"id": 10,
			"title": "Lista da Mamãe",
			"created_at": "2022-06-28T13:48:25.000000Z",
			"updated_at": "2022-06-28T14:18:53.000000Z"
		}
	}
]
```
Veja que como na lista aqui temos o <b>external_reference</b> que aqui nos produtos ele indica a qual lista ele pertence.

### Buscando um produto por ID

```
GET | http://127.0.0.1:8000/api/produtos/$PRODUCT_ID
```
Resposta
```
{
	"0": {
		"id": 13,
		"name_product": "Toddy",
		"quantity_product": 2,
		"list_id": 10,
		"created_at": "2022-06-28T14:04:26.000000Z",
		"updated_at": "2022-06-28T14:04:26.000000Z"
	},
	"external_reference": {
		"id": 10,
		"title": "Lista da Mamãe",
		"created_at": "2022-06-28T13:48:25.000000Z",
		"updated_at": "2022-06-28T14:18:53.000000Z"
	}
}
```
### Atualizar Produto
```
POST | http://127.0.0.1:8000/api/produtos/atualizar/$PRODUCT_ID

{
    name_product: NOME_DO_PRODUTO,
    quantity_product: QUANTIDADE_DO_PRODUTO
}
```
Não necessariamente precisa ter simultaneamente ter as duas requisições e sim inserir só aquela a qual queira alterar em seu produto.

Resposta
```
[
	{
		"name_message": "O nome do produto foi atualizado de Biscoito(não bolacha) para Nescau"
	},
	{
		"quantity_message": "A quantidade do produto foi atualizada de 2 para 4"
	}
]
```
### Deletar Produto

```
DELETE | http://127.0.0.1:8000/api/produtos/deletar/$PRODUCT_ID
```
Resposta
```
{
	"message": "Deletado o produto Toddy"
}
```

<h2><a href="https://github.com/JuanCalavera/list_products/tree/master/images">Imagens com as requisições feitas</a></h2>

# Testes Unitários Feitos
Só inserir o terminal rodando na raiz do projeto.
```
vendor/bin/phpunit --filter duplicate_list_via_route
```
```
vendor/bin/phpunit --filter delete_in_db_by_id
```
```
vendor/bin/phpunit --filter creation_list_in_base_db  
```
```
vendor/bin/phpunit --filter update_list_by_id 
```
```
vendor/bin/phpunit --filter list_all_in_db
```
```
vendor/bin/phpunit --filter list_all_in_db
```
