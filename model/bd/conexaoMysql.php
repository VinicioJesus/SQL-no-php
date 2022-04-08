<?php 
/********************************************************
* Objetivo: Arquivo para criar a conexão com o BD mysql
* Autor: Vinicio
* Data: 25/02/2022
* Versão:
*********************************************************/

// constantes para estabelecer a conexaõ com o BD (local do BD, usuário, senha e database)
const SERVER = 'localhost';
const USER = 'root';
const PASSWORD = 'bcd127';
const DATABASE = 'dbcontatos';



// echo "<pre>";
//  $resultado = conexaoMysql();
//  print_r($resultado);
// echo "</pre>";

//Abre a conexão com o BD Mysql
function conexaoMysql ()
{   
    $conexao = array();

    //Se a conexão for estabelecida com o BD, iremos ter um array de dados sobre a conexão
    $conexao = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);

    //validação para verificar se a conexão foi realizao com sucesso
    if($conexao)
        return $conexao;
    else
        return false;
    
}

function fecharConexaoMysql($conexao)
{
    mysqli_close($conexao);
}


/*   quando tiver numero inteiro, não coloque aspas simples, coloque aspas duplas. o RESTO é simples       */

/*
  Existem 3 formas de criar a conexão com o BD Mysql

    mysql_connect() - versão antiga do PHP de fazer a conexão com o BD 
        (Não oferece performance e segurança)
    mysqli_connect() - versão mais atualizada do PHP de fazer a conexão com BD
        (ela permite ser utilizada para programação estruturada e POO - Programação Orientada à Objeto)
    PDO() - versão mais completa e eficiente para conexão com BD
        (é indicada pela segurança e POO - Programação Orientada à Objeto)



*/

?>