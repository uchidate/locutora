 <div class="jumbotron">
     
      <div class="row marketing">
        <div class="col-lg-6">
           <img class="img-responsive" src="images/logo.png" alt="">
          <?php
          $dados = listar('paginas', ' WHERE idpage = "1" order by idpage DESC');
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
           
 <br />
<div class="videoContainer" style="width:100% ; "> 
 <?php include"./teste-listvideo.php" ?>     
</div>


        </div>

        <div class="col-lg-6">
          <h2>Locuções</h2>
          <p><iframe width="100%" height="725" scrolling="no" frameborder="no" src="http://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Fusers%2F12694227&amp;auto_play=false&amp;show_artwork=true&amp;color=ff0035"></iframe></p>

           
        </div>
		
		 
		
      </div>
	  
	  
	 
	  
 </div>