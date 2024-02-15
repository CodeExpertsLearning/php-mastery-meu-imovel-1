# Projeto Meu Imovel Roteamento

Url -> (http://localhost:3030)/imoveis/1

Colecao de rotas:

```
[
    [
        'route'  =>  'imoveis',
        'callback' = > 'ImovelController@index',
        'method' => 'GET'
    ],
]

```

Criar um resolver para as rotas, de forma a chamar o callback correto do controller mapeado para aquele acesso.
