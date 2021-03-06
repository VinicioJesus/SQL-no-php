<?php

    /**************************************************
     * Objetivo: Arquivo responsável pela manipulação de dados de contatos
     * Obs( Este arquivo fará a ponte entre a View e a Model)
     * Autor: Vinicio
     * Data: 04/03/2022
     * Versão: 1.0 
     *************************************************/
    
     //função para receber dados da View e encaminhar para a model (inserir)
    function inserirContato($dadosContato, $file)
    
    {   

        $nomeFoto = (String) null;
        //Validação para verificar se o objeto está vazio
        if(!empty($dadosContato))
        {
            //Validação de caixa vazia dos elementos nome, celular e email, pois são campos de preenchimento 
            //Obrigatórios no Banco de Dados 
            //Se o nome não estiver vazio
            if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail']))
            {
                //validação para verificar se chegou um arquivo para uppload
                if ($file ['flefoto']['name'] != null)
                {   

                    
                   //import da função de upload de arquivos
                   require_once('modulo/upload.php');
                   //chama a fução de upload
                   $nomeFoto = uploadFile($file['fleFoto']); 
                   
                   if (is_array($nomeFoto)) 
                   {    
                       //Caso ocorra algum erro no processo de  upload, a função irá
                       // retornar um array com a mensagem de erro. Esse array será retornado paa
                       // a router e ele irá exibir a mensagem de erro para o usuario.
                       return $nomeFoto;
                   }
                }
                
                
                
                //Criação de um array de dados que será encaminhado a model
                    // para inserir no BD, é importante criar este array conforme
                    // as necessidades de manipulação do BD.
                // OBS: criar as chaves do aray conforme os nomes dos atributos
                // do BD
                $arrayDados = array (
                    "nome"      => $dadosContato['txtNome'],
                    "telefone"  => $dadosContato['txtTelefone'],
                    "celular"   => $dadosContato['txtCelular'],
                    "email"     => $dadosContato['txtEmail'],
                    "obs"       => $dadosContato['txtObs'],
                    "foto"      => $nomeFoto
                );
                
                //import do arquivo de modelagem para manipular o BD
                require_once('model/bd/contato.php');
                //Chama a função que fara o insert no BD 
                if(insertContato($arrayDados)){
                    return true;
                
                }else{
                    return array('idErro' => 1,
                                 'message' => 'não foi possivel inserir os dados no Banco de Dados' );
                }

            }else {
                echo('Dados incompletos');
                return array('idErro'   => 2,
                             'message' => 'Existem campos obrigatórios que não foram preenchidos'  );
            }   
        }
    }

    //função para receber dados da View e encaminhar para a model (atualizar)
    function atualizarContato($dadosContato,$arrayDados)
    {
        // recebe o id enviado pelo arrayDaddos
        $id = $arrayDados['id'];

        // Recebe a foto enviado pelo arrayDados (Nome da foto que ja existe no BD)
        $foto = $arrayDados['foto'];
        // Recebe o objeto do array referente a nova foto que poderia ser enviada ao servidor
        $file = $arrayDados ['file'];

        //Validação para verificar se o objeto está vazio
        if(!empty($dadosContato))
        {
            //Validação de caixa vazia dos elementos nome, celular e email, pois são campos de preenchimento 
            //Obrigatórios no Banco de Dados 
            //Se o nome não estiver vazio
            if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail']))
            {   //validação para verificar que o id seja valido
                if (!empty($id) && $id != 0 && is_numeric($id)) 
                {               

                    //validação para identificar se será enviado ao servidor uma nova foto
                    if ($file ['flefoto']['name'] != null) 
                    {
                        
                         //import da função de upload de arquivos
                         require_once('modulo/upload.php');
                         //chama a fução de upload para enviar a nova foto ao servidor
                         $novaFoto = uploadFile($file['fleFoto']); 
                        
                    }else
                    {
                        //Permanece a mesma foto no BD
                        $novaFoto = $foto;
                    }
                
                    //Criação de um array de dados que será encaminhado a model
                        // para inserir no BD, é importante criar este array conforme
                        // as necessidades de manipulação do BD.
                    // OBS: criar as chaves do aray conforme os nomes dos atributos
                    // do BD
                    $arrayDados = array (
                        "id"        => $id,
                        "nome"      => $dadosContato['txtNome'],
                        "telefone"  => $dadosContato['txtTelefone'],
                        "celular"   => $dadosContato['txtCelular'],
                        "email"     => $dadosContato['txtEmail'],
                        "obs"       => $dadosContato['txtObs'],
                        "foto"      => $novaFoto
                    );
                    
                    //import do arquivo de modelagem para manipular o BD
                    require_once('model/bd/contato.php');
                    //Chama a função que fara o insert no BD 
                    if(updateContato($arrayDados)){
                        return true;
                    
                    }else{
                        return array('idErro' => 1,
                                    'message' => 'não foi possivel atualizar os dados no Banco de Dados' );
                    }
                }else{
                        return array('idErro'   => 4,
                                     'message'   => 'não é possivel editar um registro sem informar um id valido' );
                }
                     
            }else 
            {
                    echo('Dados incompletos');
                    return array('idErro'   => 2,
                                 'message' => 'Existem campos obrigatórios que não foram preenchidos'  );
            }
               
        }                  
    }

    //função para realizar a exclusão de um contato
    function excluirContato($arrayDados)
    {   
        
        //recebe o id do registro que será excluido
        $id = $arrayDados['id'];
        
        //recebe o nome da foto que será excluida da pasta do servidor
        $foto = $arrayDados['foto'];
        //validação para verificar se o id contem um numero valido
        if($id != 0 && !empty($id) && is_numeric($id))
        {   
            require_once('model/bd/contato.php');
        
            require_once('modulo/config.php');
            //import do arquivo de contato
            
            //chama a função da model e valida se o retorno foi verdadeiro ou false
            if(deleteContato($id))
            {   
                //validação para caso a foto não exista no registro
                if ($foto != null) {
                    //unlink() -  função para apagar um arquivo de um diretório
                    //permite apagar a foto fisicamente do diretorio no servidor
                    if(unlink(DIRETORIO_FILE_UPLOAD.$foto))
                    {
                        return true;
                    
                    }else{
                        return array('idErro' => 5,
                                    'message' => 'O registro do Banco de Dados foi excluído com sucesso porèm a imagem 
                                    não foi excluida do diretório do servidor!' );
                    };
                }else{
                    return true;
                }

               
            }
            else
            {
                return array('idErro'   => 3,
                             'message'   => 'não foi possivel excluir o registro' );
                
            }
        }
        else
        {
            return array('idErro'   => 4,
                        'message'   => 'não é possivel excluir um registro sem informar um id valido' );
        }
    }
    //Bucar um contato através de um contato por ID
    function buscarContato($id)
    {
        //validação para verificar se o id contem um numero valido
        if($id != 0 && !empty($id) && is_numeric($id))
        {
            //import do arquivo de contato
            require_once("model/bd/contato.php");
            //Chama a função na model que vai buscar no BD
            $dados = selectByIdContato($id);
            //Valida se existem dados para serem deovolvidos 
            if(!empty($dados))
            {
                return $dados;
            }else
            {
                return array('idErro'   => 4,
                             'message'  => 'não é possivel excluir um registro sem informar um id valido' );
                
            }
        }
    }

    //função para solicitar os dados da model e encaminhar a lista 
    //de contatos para a View
    function listarContato()
    {   
        //importa do arquivo que vai buscar os dados no BD
        require_once('model/bd/contato.php');
        //Chama a função que vai buscar os dados no BD
        $dados = selectAllContatos();

        

        if (!empty($dados)) 
        {
            return $dados;
            
        }else
        {
            return false;
        }
    }


?>