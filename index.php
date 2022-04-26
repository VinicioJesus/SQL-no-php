<?php 
    // Esta variavel foi criada para diferenciar no action do formulario
    // qual ação deveria ser levada para a router (innserir ou editar)
    // Nas condições abaixo, mudando o action dessa variavel para a açãode editar
    $form = (string) "router.php?component=contatos&action=inserir";

    //Valida se a utilização de variaveis de sessão está 
    //ativa no servidor
    if(session_status())
    {

        //Valida se a variavel de sessão dadosContato não está vazia  
        if (!empty($_SESSION['dadosContato']))
        {
            
            $id = $_SESSION['dadosContato']['id'];
            $nome = $_SESSION['dadosContato']['nome'];
            $telefone = $_SESSION['dadosContato']['telefone'];
            $celular = $_SESSION['dadosContato']['celular'];
            $email = $_SESSION['dadosContato']['email'];
            $obs = $_SESSION['dadosContato']['obs'];
            //Mudamos a ação do form para editar o registro no click do botão salvar
            $form = "router.php?component=contatos&action=editar&id=".$id;

            //Destruimos a variavel de sessão para evitar que o formulario
            unset($_SESSION['dadosContato']);
        }
    }
?>

 



<!DOCTYPE>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>               
        <div id="cadastro"> 
            <div id="cadastroTitulo"> 
                <h1> Cadastro de Contatos </h1>                
            </div>
            <div id="cadastroInformacoes">
                <!-- enctype="multipart/form-data" essa opção é obrigatória para enviar arquivos do formulario html para o servidor -->
                <form  action="<?= $form  ?>" name="frmCadastro" method="post" enctype="multipart/form-data" >
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="txtNome" value="<?= !empty($nome) ? $nome : null?>" placeholder="Digite seu Nome" maxlength="100">
                        </div>
                    </div>                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Telefone: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtTelefone" value="<?= !empty($telefone) ? $telefone : null?>" placeholder="Digite seu telefone" maxlength="100">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtCelular" value="<?= !empty($celular) ?  $celular : null?>" placeholder="Digite seu telefone" maxlength="100">
                        </div>
                    </div>                   
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="email" name="txtEmail" value="<?= !empty($email) ?  $email : null?>" placeholder="Digite seu telefone" maxlength="100">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Escolha um arquivo </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="file" name="fleFoto" accept=".jpg, .png, .jpeg, .gif">
                        </div>
                    </div>

                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="txtObs" cols="50" rows="7"></textarea>
                        </div>
                    </div>
                    <div class="enviar">
                        <div class="enviar">
                            <input type="submit" name="btnEnviar" value="Salvar">
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
        <div id="consultaDeDados">
            <table id="tblConsulta" >
                <tr>
                    <td id="tblTitulo" colspan="6">
                        <h1> Consulta de Dados.</h1>
                    </td>
                </tr>
                <tr id="tblLinhas">
                    <td class="tblColunas destaque"> Nome </td>
                    <td class="tblColunas destaque"> Celular </td>
                    <td class="tblColunas destaque"> Email </td>
                    <td class="tblColunas destaque"> Foto</td>
                    <td class="tblColunas destaque">  Opções </td>
                </tr>

                <?php 
                    //import do arquivo do controller para solicitar a listagem dos dados
                    require_once('controller/controllerContatos.php');
                    //chama a função que vai retornar os dados do contato
                    $listContato = listarContato();

                    // estrutura de repetição para retorar os dados do array
                    // e printar na tela
                    foreach ($listContato as $item)
                    {                  
                    
                ?>        
               
                <tr id="tblLinhas">
                    <td class="tblColunas registros"><?=$item['nome']?></td>
                    <td class="tblColunas registros"><?=$item['celular']?></td>
                    <td class="tblColunas registros"><?=$item['email']?></td>
                    <td class="tblColunas registros"> <img src="arquivos/<?=$item['foto']?>" class="foto" >  </td>
                    

                   
                    <td class="tblColunas registros">
                        <a href="router.php?component=contatos&action=buscar&id=<?=$item['id']?>">

                            <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                        </a>
                        <a href="router.php?component=contatos&action=deletar&id=<?=$item['id']?>">

                            <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir">

                        </a>
                        <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>