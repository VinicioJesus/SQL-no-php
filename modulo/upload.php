<?php 
  
/******************************************************************************
 * Objetivo: Arquivo responsável por realizar uploads de arquivos
 * Data: 25/04/2022
 * Autor: Vinicio
 * Versão: 1.0
 *******************************************************************************/
//função para realizar upload de imagens
 function uploadfile ($arrayfile)
 {
  //import do arquivo de configurações do projeto 
  require_once('config.php');

  $arquivo = $arrayfile;
  $sizefile = (int) 0;
  $typefile = (string) null;
  $namefile = (string) null;
  $tempfile = (string) null;
  
  //validação para identificar se existe um arquivo valido (Maior que 0 e que tenha uma extesão)
  if($arquivo['size'] > 0 && $arquivo['type'] != "" )
  { 
    //recupera o tamanho do arquivo que é em bytes e converte para kb ( /1024)
    $sizefile = $arquivo['size'] /1024; //converte o tamanho em KB
    //recupera o tipo do arquivo
    $typefile = $arquivo['type'];
    //recupera o nome do arquivo
    $namefile = $arquivo['name'];
    //recupera o diretorio temporario que está o arquivo
    $tempfile = $arquivo['tmp_name'];


    //validação para permitir o upload apenas de arquivos no maximo 5mb
    if ($sizefile <= MAX_FILE_UPLOAD)
    { 
      //validação para permtir somente as extensões validas
      if (in_array($typefile, EXT_FILE_UPLOAD)) 
      {
        //separa somente o nome do arquio sem a sua extensão
        $nome = pathinfo($namefile, PATHINFO_FILENAME);

        //separa somente a extensão do arquivo sem o nome
        $extensão = pathinfo($namefile, PATHINFO_EXTENSION);

        //existem diversos algoritmos para criptografia de dados
          //md5()
          //sha1()
          //hash ()

        //md5 gerando uma criptografia de dados
        //uniqid gerando uma sequencia numérica diferentes tendo com base, configuração da maquina
        //time() pega a hora, minuto e segundo que está sendo feito o upload da foto  
        $nomeCripty = md5($nome.uniqid(time()));
        //montamos novamente o nome do arquivo com a extensão e o nome criptografado
        $foto = $nomeCripty.".".$extensão;

        if(move_uploaded_file($tempfile, DIRETORIO_FILE_UPLOAD.$foto))
        {
          return $foto;
        }else {
          return array ('idErro' => 13,
                        'msgErro' => 'Não foi possivel mover o arquivo para o servidor');
        }
      }else{
        return array ('idErro' => 12,
                      'message' => 'A extensão do arquivo selecionado não é permitida no upload');
      }
    }else{
      return array ('idErro' => 10,
                    'message' => 'Tamaho de arquivo invalido no upload' );
    }

  }else{
    return array ('idErro' => 11,
                  'message' => 'Não é possível realizar o upload sem um arquivo selecionado');
  }
 }

?>