<marquee><?php
          $dados = listar('clientes', ' order by idcli DESC');
          if ($dados) {
          $d = new ArrayIterator($dados);
          while ($d->valid()):
          ?>
             
            &nbsp;&nbsp;&nbsp;<img src="administrar/files/<?php echo  utf8_encode($d->current()->foto); ?>" alt="<?php echo  utf8_encode($d->current()->nomeCliente); ?>" />
           
          <?php
          $d -> next();
          endwhile;
          }else{
          echo 'Aguardando foto...';
          }
          ?></marquee>