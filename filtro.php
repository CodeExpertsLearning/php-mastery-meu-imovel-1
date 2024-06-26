<?php 


//A base de montagem dos filtros|buscas|ordenacao
//param filtros= | ordenacao param ordenacao= 
// | filtro propriedade recurso colunas= | 

// Forma como agente vai lidar com cada um deles:

// filtros=titulo:LIKE:%imovel%;preco:>:10
//colunas=titulo,preco
//ordernacao=id:DESC;

//titulo:LIKE:%imovel%;preco:>:10 // explode(';', $filtros) // [filtros...]
//titulo:LIKE:%imovel% => explode(':', $filtroLinha) => [campo, operador, valor]