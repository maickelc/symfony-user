2taps
=====

API Usuário

### [ **GET** ] `/user` ou `/getRecords`
#### Listar todos usuários
+ Response `200` (application/json)
    + Body
    ```json
    [
        {
            "id": 1,
            "name": "2taps",
            "username": "2taps",
            "password": "2taps"
        }
    ]
    ```

### [ **POST** ] `/user`
#### Inserir novo usuários
+ Request (application/json)
    ```json
        {
            "name": "2taps",
            "username": "2taps",
            "password": "2taps"
        }
    ```
+ Response `201` (application/json)
    + Body
    ```json
        {
            "id": 1,
            "name": "2taps",
            "username": "2taps",
            "password": "2taps"
        }
    ```

### [ **GET** ] `/user/{id}` 
#### Exibir informações do usuário `id` informado
+ Parameter
    + `id` - Identificador do usuário
+ Response `200` (application/json)
    + Body
    ```json
        {
            "id": 1,
            "name": "2taps",
            "username": "2taps",
            "password": "2taps"
        }
    ```
### [ **PATCH** ] `/user/{id}` 
#### Editar usuário com o `id` informado
+ Parameter
    + `id` - Identificador do usuário
+ Request (application/json)
    ```json
    {
        "username": "maickelc"
    }
+ Response `200` (application/json)
    + Body
    ```json
        {
            "id": 1,
            "name": "2taps",
            "username": "maickelc",
            "password": "2taps"
        }
    ```

### [ **DELETE** ] `/user/{id}`
#### Remover usuário 
+ Parameter
    + `id` - Identificador do usuário
+ Response `204` (application/json)
    + Body
    ```json
    []
    ```

### [ **POST** ] `/user/login`
#### Efetuar login

+ Parameter
    + `username` - Username
    + `password` - Senha do usuário

+ Request (application/json)
    ```json
    {
        "username": "2taps",
        "password": "2taps"
    }
    ```
+ Response `200`
    Em caso de sucesso
    + Body
    ```json
    {
        "id": 1,
        "name": "2taps",
        "username": "2taps",
        "password": "2taps"
    }
    ```

+ Response `401`
    Em caso de falha