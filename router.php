<?php 
 /******************************************************************************
 * Objetivo: Arquivo de rota, para segmentar as ações encaminhadas pela view
 *      (dados do form, listagem de dados, ação de excluir ou atualizar).
 *      Esse arquivo será responsável por encaminhar as solicitações para
 *      a Controller
 * Data: 04/03/2022
 * Autor: Vinicio
 * Versão: 1.0
 *******************************************************************************/
// O que chegar aqui a gente vai mandar pra controller
// O arquivo de rota é o maestro 
 $action = (string) null;
 $component = (string) null;
 
    
    //Validação para verificar se a requisição é um POST  de um formulário
    if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) 
    {
        //Recebendo dados via URL para saber quem esta solicitando e qual ação será realizada
        $component = strtoupper($_GET['component']);
        $action = strtoupper ($_GET['action']);       

        switch ($component) 
        {
            case 'CONTATOS':
                //Import do controllerContatos
                require_once('Controller/controllerContatos.php');
                
                //Validação para identificar o tipo de ação que será realizada
                if($action == 'INSERIR'){                    
                    //Chama a função de inserir no controller 
                    $resposta = inserirContato($_POST);
                    //Valida o tipo de dados que a controller retornou
                    if(is_bool($resposta))//Se for boleano 
                    {   
                        //Verificar se i retorno foi verdadeiro
                        if($resposta)
                        echo ("<script>
                              alert('Registro inserido com suceso!');
                              window.location.href = 'index.php';
                              </script> ");
                    //Se o retorno for um array significa houve erro no processo de inserção
                    }elseif (is_array($resposta)){
                        echo ("<script>
                              alert('".$resposta['message']."');
                              window.history.back();
                              </script> "); // window.location.hfef = 'index.php';
                    }
                }elseif ($action == 'DELETAR') 
                {
                    //recebe o id do registro que deverá ser excluido, que foi enviado 
                    //pela URL no link da imagem do excluir que foi acionado na index
                    $idContato = $_GET['id'];      

                    
                    $resposta = excluirContato($idContato);

                    if(is_bool($resposta))
                    {                        
                        if ($resposta) {
                            echo("<script>
                                    alert('Registro excluido com suceso!');
                                    window.location.href = 'index.php';
                                  </script> ");
                        }
                    }elseif (is_array($resposta)) 
                    {
                        echo ("<script>
                        
                                alert('".$resposta['message']."');
                                window.history.back();
                              </script> ");
                    }
                
                }elseif ($action == 'BUSCAR') 
                {
                    //recebe o id do registro que deverá ser editado, que foi enviado 
                    //pela URL no link da imagem do editar que foi acionado na index
                    $idContato = $_GET['id'];      

                    $dados = buscarContato($idContato);

                    session_start();
                    //Guar em uma variavel de sessão os dados que o BD retornou para a busca d od 
                    //Obs(essa variavel de sessão será utilizada na index.php, para colocar os 
                    //dados nas ciaxas de texto
                    
                    $_SESSION['dadosContato'] = $dados;
                    //Utilizando o header também podemos chamar a index.php,
                    //porém haverá uma ação de carregamento no navegador
                    //(piscando a ela novamente)
                    
                    //header('location: index.php');
                    
                    //utilizando o require iremos apenas importar a tela do a index,
                    //assim não havendo um novo carregamento da página.
                    require_once('index.php');
                }
                

            break;
        }
        
    }

?>