<?php
 include_once'class.phpmailer.php';
 include_once'class.smtp.php';

if (isset($_POST['enviarContato'])) :
    $date = date('Y-m-d H:m:s');
    $nome = obrigatorio('name', $_POST['name']);
    $email = obrigatorio('email', $_POST['email']);
    $telefone = obrigatorio('phone', $_POST['phone']);
    $cidade = obrigatorio('cidade', $_POST['cidade']);
    $assunto = obrigatorio('assunto', $_POST['assunto']);
    $mensagem = obrigatorio('message', $_POST['message']);

    if (!isset($obrigatorio)) :
    
            /*$dbh = conectar();
            
            $stmt = $dbh->prepare("insert into tbContato (
            `idContato`, 
            `dataContato`, 
            `nome`, 
            `email`, 
            `telefone`, 
            `cidade`, 
            `assunto`, 
            `mensagem` 
            ) values (
            :idContato, 
            :dataContato, 
            :nome, 
            :email, 
            :telefone, 
            :cidade, 
            :assunto, 
            :mensagem 
            )");
            $stmt->bindParam(':idContato', $_POST['idContato'], PDO::PARAM_STR, 64);
            $stmt->bindParam(':dataContato', $date, PDO::PARAM_STR, 64);
            $stmt->bindParam(':nome', $_POST['nome'], PDO::PARAM_STR, 64);
            $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR, 64);
            $stmt->bindParam(':telefone', $_POST['telefone'], PDO::PARAM_STR, 64);
            $stmt->bindParam(':cidade', $_POST['cidade'], PDO::PARAM_STR, 64);
            $stmt->bindParam(':assunto', $_POST['assunto'], PDO::PARAM_STR, 64);
            $stmt->bindParam(':mensagem', $_POST['mensagem'], PDO::PARAM_STR, 64);
            $executed = $stmt->execute();
            if($executed){
                //$db_message = '<p class="db_success">Successfully saved <b>idContato : '.reverb($_POST['idContato']).'</b> to the database!!</p>';
                $sucesso = " ";
            }else{
                //$db_message = '<p class="db_error">There was a problem saving <b>idContato : '.reverb($_POST['idContato']).'</b> to the database!!</p>';
                $erro = 'Erro ao Cadastrar no Banco de dados';
            }
            */
    
        /* ENVIAR EMAIL */
        if (enviarEmail($nome, $email, $assunto, $telefone, $mensagem, $cidade)) :
            $sucesso = "E-mail enviado com sucesso!";
        else :
            $erro = 'Erro ao enviar email';
        endif;
    else :
        $erro = $obrigatorio;

    endif;

endif;
?><!-- Page Content -->
   <div class="jumbotron">

      

        <!-- Content Row -->
        <div class="row">
             
            <!-- Contact Details Column -->
            <div class="col-md-4">
                <h3>Contatos</h3>
                 <?php
          $dados = listar('paginas', ' WHERE idpage = "2" order by idpage DESC');
          if ($dados) {
          $d = new ArrayIterator($dados);
          while ($d->valid()):
          ?>
             
            <?php echo  utf8_encode($d->current()->conteudo); ?>
           
          <?php
          $d -> next();
          endwhile;
          }else{
          echo 'Aguardando conteudo...';
          }
          ?>  
                
                 
                
            </div>
        </div>
        <!-- /.row -->
<?php echo isset($erro) ? '<div class="btn btn-danger"><meta http-equiv="refresh" content="30">' . $erro . '</div>' : ''; ?>
                    <?php echo isset($sucesso) ? '<div class="btn btn-success" id="sendalert"><meta http-equiv="refresh" content="5">' . $sucesso . '</div>' : ''; ?>
        <!-- Contact Form -->
        <!-- In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
         
         <div class="row">
            <div class="col-md-8">
                <h3>Campos marcados com ( * ) são obrigatórios.</h3>
                <!--<form class="form-horizontal" name="sentMessage" id="contactForm" novalidate>-->
                <form  id="contactForm" action="" method="post">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Nome:( * )</label>
                            <input type="text" class="form-control" name="name"  id="name" required data-validation-required-message="Por favor seu nome é requerido.">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Telefone:( * )</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required data-validation-required-message="Por favor insira seu telefone.">
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Assunto:( * )</label>
                            <input type="text" class="form-control" id="assunto" name="assunto" required data-validation-required-message="Digite o assunto.">
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>E-mail:( * )</label>
                            <input type="email" class="form-control" id="email" name="email" required data-validation-required-message="Seu e-mail">
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Mensagem:</label>
                            <textarea rows="10" cols="100" class="form-control" name="message" id="message" maxlength="999" style="resize:none"></textarea>
                        </div>
                    </div>
                    <div id="success"></div>
                    
                    <!-- For success/fail messages -->
                    <button type="submit" name="enviarContato"  class="btn btn-primary">Enviar</button>
                </form>
            </div>

        </div>
         
        <!-- </form>/.row -->
  
    </div>
    <!-- /.jumbotron -->