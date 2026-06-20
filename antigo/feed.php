<?php
include_once"functions/conexao/conexao.php";
include_once"functions/helpers/utils.php";
header("content-type: text/xml");
echo '<?xml version="1.0"?>';
?>
<rss version="2.0">

<channel>
  	<title >Damásio Jundiaí</title>
  <link>http://damasiojundiai.com.br/</link>
  <description>Faça Diferença. Faça Damásio, Cursos OAB, Concursos Públicos, Pós Graduação.</description>
  
  
 
<?php
 
 $dados = listar('cursosdamasio', ' ORDER BY inicioCurso DESC LIMIT 40');
     if ($dados) {
     	# code...

    $d = new ArrayIterator($dados);
    while ($d->valid()):
    $cat = $d->current()->categoria;
 
        
		
		echo' 
	<item>
	  <title>'.$d -> current() -> titulo_curso.'</title> 
	  <link>http://damasiojundiai.com.br/detalhes/'.post_slug($d -> current() -> titulo_curso).'/'.$d -> current() -> id_curso.'/'.$d -> current() ->categoria.'</link> 
	  <description> 
		   
		  '.$new_str = strip_tags(str_replace("&nbsp;", '', $d -> current() -> sobre_curso)).'
	  </description>
	</item>';
		
		?>
		
<?php
$d -> next();
endwhile;

  }else{
            ?>
               <div class="alert alert-warning" role="alert">
                    <p>  Aguardando cursos ...</p>
                </div>
        <?
            }
        ?>  
 
</channel>
</rss>