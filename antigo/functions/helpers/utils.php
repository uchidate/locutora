<?php
ini_set('memory_limit', '256M');



function buscarCurso($categoria, $curso) {

    $pdo = conectar();
    try {
        $buscar = $pdo->prepare('SELECT * FROM cursosdamasio WHERE categoria = :categoria AND titulo_curso LIKE :titulo_curso');
        $buscar->bindValue(":categoria", $categoria);
        $buscar->bindValue(":titulo_curso", "%".$curso."%");
        $buscar->execute();

        if ($buscar->rowCount() > 0):
            return $buscar->fetchAll(PDO::FETCH_OBJ);
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function urlSEO($string){

    $string = preg_replace( '/-+/i', '-', $string );
    return strtolower(utf8_encode($string));


} 
function remove_accent($str) 
{ 
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'); 
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
  return str_replace($a, $b, $str); 
} 

function post_slug($str) 
{ 
  return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), 
  array('', '-', ''), remove_accent($str))); 
} 


function site_url(){
    $site=$_SERVER['SERVER_NAME'];
    //return 'http://'.$site.'/damasio/modelo2';
	return 'http://'.$site.'/';
}
function verificaCadastro($tabela, $nomeCampo, $cadastro) {

    $pdo = conectar();
    try {

        $verificaCadastro = $pdo->prepare("SELECT * FROM $tabela WHERE $nomeCampo = :cadastro");
        $verificaCadastro->bindValue(":cadastro", $cadastro);
        $verificaCadastro->execute();

        if ($verificaCadastro->rowCount() == 1) :
            return false;
        else :
            return true;
        endif;
    } catch (PDOException $e) {
        echo "Erro ao verificar registro cadastrado " . $e->getMessage();
    }
}

function validarCep($cep) {

    global $validou;

    if (preg_match("/^\d{5}-\d{3}$/i", $cep)) :
        return true;
    else :
        $validou = "O formato do cep, não foi aceito !";
    endif;
}

function validarTelefone($telefone) {
    global $validou;

    if (preg_match("/^[(]\d{2}[)]\d{4}-\d{4}$/i", $telefone)) :
        return true;
    else :
        $validou = "O formato do telefone ou celular, não foi aceito !";
    endif;
}

function listar($tabela, $parametros = null) {

    $pdo = conectar();
    try {

        if (is_null($parametros)) :
            $listar = $pdo->prepare("SELECT * FROM " . $tabela);
        else :
            $listar = $pdo->prepare("SELECT * FROM " . $tabela . $parametros);
        endif;
        $listar->execute();

        if ($listar->rowCount() > 0) :
            $dados = $listar->fetchAll(PDO::FETCH_OBJ);
            return $dados;
        else :
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function pegarPeloId($tabela, $campoTabela, $id) {
    $pdo = conectar();
    try {

        $listarDados = $pdo->prepare("SELECT * FROM " . $tabela . " WHERE " . $campoTabela . " = :id");
        $listarDados->bindValue(":id", $id);
        $listarDados->execute();

        if ($listarDados->rowCount() > 0) :
            $dados = $listarDados->fetch(PDO::FETCH_ASSOC);
            return $dados;
        else :
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}


function deletar($id, $tabela, $campoTabela) {
    $pdo = conectar();
    try {
        $deletar = $pdo->prepare("DELETE FROM $tabela WHERE $campoTabela = :id");
        $deletar->bindValue(":id", $id);
        $deletar->execute();

        if ($deletar->rowCount() == 1) :
            return true;
        else :
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function listarBusca($tabela, $campoBusca, $busca) {
    $pdo = conectar();
    try {

        $listarBusca = $pdo->prepare("SELECT * FROM $tabela  WHERE $campoBusca LIKE :b");
        $listarBusca->bindValue(":b", $busca . '%');
        $listarBusca->execute();

        if ($listarBusca->rowCount() > 0) :
            $dados = $listarBusca->fetchAll(PDO::FETCH_ASSOC);
            return $dados;
        else :
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function obrigatorio($nomeCampo, $campo = null) {

    global $obrigatorio;

    if ($campo !== null) :
        if (empty($campo)) :
            $obrigatorio = "O campo $nomeCampo é obrigatório !";
        else :
            $valor = filter_var($campo, FILTER_SANITIZE_STRIPPED);
            return trim($valor);
        endif;
    endif;
}

function enviarEmail($nome, $email, $assunto, $telefone, $mensagem, $cidade) {

    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->CharSet = "UTF-8";
    /*$mail->Mailer = "smtp";
    $mail->SMTPSecure = "ssl";
    $mail->IsSMTP();
    $mail->Host = "smtp.locutora.com";
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = "noreply@locutora1.hospedagemdesites.ws";
    $mail->Password = "noreply1987878";
    */$mail->IsHTML(true);

    //EMAIL DE QUEM ESTA ENVIANDO
    $mail->SetFrom('noreply@locutora.com');
	//$mail->SetFrom($email);
    //NOME PRINCIPAL QUE APARECE AO RECEBER O EMAIL
    $mail->FromName = "locutora.com";
	//$mail->FromName = $nome;

    
    //ENVIAR UMA COPIA PARA
    $mail->AddAddress('adrianarosa@locutora.com');
	$mail->AddReplyTo($email, $nome);
    //$mail->AddCC('adrianarosa@locutora.com', 'adrianarosa');
    $mail->AddCC('drix.rox@gmail.com', 'Adriana Gmail');    
	//$mail->AddBCC('oculto@oculto.com.br', 'oculto.com.br'); 
 	
	 
	
	
    //ASSUNTO DO EMAIL APARECE LOGO ABAIXO DO NOME PRINCIPAL
    $mail->Subject = $assunto;

    //MENSAGEM DO EMAIL
  
    $mensagemEnviada.= "<p>Nome: $nome</p>";    
    $mensagemEnviada.= "<p>Telefone: $telefone</p>";
    $mensagemEnviada.= "<p>E-mail: $email</p>";
    //$mensagemEnviada.= "<p>Mensagem: $mensagem</p>"; 
     

    $mensagemEnviada.=$mensagem;

    $mail->Body = $mensagemEnviada;

    if ($mail->Send()):
        /* CADASTRAR CONTATO NO BANCO */
        return true;
    else:
        return false;
    endif;
}

 

function verificaCep($cep) {

    $pdo = conectar();
    $verificaCep = $pdo->prepare("SELECT * FROM cep WHERE :cep between cep_inicio and cep_fim");
    $verificaCep->bindValue(':cep', $cep);
    $verificaCep->execute();

    if ($verificaCep->rowCount() == 1):
        $dados = $verificaCep->fetch(PDO::FETCH_OBJ);
        if ($dados->nome != 'SP - INTERIOR'):
            return false;
        else:
            return true;
        endif;
    else:
        return false;
    endif;
}

function get_base_url()
    {
        /* First we need to get the protocol the website is using */
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';

        /* returns /myproject/index.php */
        $path = $_SERVER['PHP_SELF'];

        /*
         * returns an array with:
         * Array (
         *  [dirname] => /myproject/
         *  [basename] => index.php
         *  [extension] => php
         *  [filename] => index
         * )
         */
        $path_parts = pathinfo($path);
        $directory = $path_parts['dirname'];
        /*
         * If we are visiting a page off the base URL, the dirname would just be a "/",
         * If it is, we would want to remove this
         */
        $directory = ($directory == "/") ? "" : $directory;

        /* Returns localhost OR mysite.com */
        $host = $_SERVER['HTTP_HOST'];

        /*
         * Returns:
         * http://localhost/mysite
         * OR
         * https://mysite.com
         */
        return $protocol . $host . $directory;
    }

    function listaCursos($categoria, $pizza) {

    $pdo = conectar();
    try {
        $buscar = $pdo->prepare('SELECT cursosdamasio.*, categoriadamasio.* FROM cursosdamasio INNER JOIN categoriadamasio ON categoriadamasio.idcategoria = cursosdamasio.categoriaiden');
        $buscar->bindValue(":categoria", $categoria);
        $buscar->bindValue(":pizzaDesejada", "%".$pizza."%");
        $buscar->execute();

        if ($buscar->rowCount() > 0):
            return $buscar->fetchAll(PDO::FETCH_OBJ);
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function resumo($string,$chars) {
	if (strlen($string) > $chars) {
		while (substr($string,$chars,1) <> ' ' && ($chars < strlen($string))){
			$chars++;
		};
	};
		return substr($string,0,$chars)."...";
	};

/**
    * Retorna os nomes dos arquivos de um diretório
    * @author Rafael Wendel Pinheiro
    * @param String $dir Caminho do diretório a ser utilizado
    * @return array
*/
function get_files_dir($dir, $tipos = null){
      if(file_exists($dir)){
          $dh =  opendir($dir);
          while (false !== ($filename = readdir($dh))) {
              if($filename != '.' && $filename != '..'){
                  if(is_array($tipos)){
                      $extensao = get_extensao_file($filename);
                      if(in_array($extensao, $tipos)){
                          $files[] = $filename;
                      }
                  }
                  else{
                      $files[] = $filename;
                  }
              }
          }
          if(is_array($files)){
              sort($files);
          }
          return $files;
      }
      else{
          return false;
      }
}
 
/**
    * Retorna a extensão de um arquivo
    * @author Rafael Wendel Pinheiro
    * @param String $nome Nome do arquivo a se capturar a extensão
    * @return resource Caminho onde foi salvo o arquivo, ou false em caso de erro
*/
function get_extensao_file($nome){
    $verifica = explode('.', $nome);
    return $verifica[count($verifica) - 1];
}