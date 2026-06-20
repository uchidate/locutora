 
  <?php
 $pasta = 'clientes/';

 $arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp}", GLOB_BRACE);
 echo'<marquee>';
 foreach($arquivos as $img){?>&nbsp;&nbsp;&nbsp;<img src="<?php echo $img; ?>" alt="<?php echo $img[0]; ?>" />
 <?php  }
echo '</marquee> ';
?>
 
