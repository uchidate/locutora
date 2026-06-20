<?php
@session_start();
 ob_start("ob_gzhandler");

include_once"functions/conexao/conexao.php";
include_once"functions/url/url.php";
include_once"functions/helpers/utils.php";
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Sou locutora profissional desde 1996, atuo no mercado publicitário há 12 anosgravações institucionais, spots, campanhas políticas, podcasts, chamadas, esperas telefônicas, uras, e-learnings, narrações, voz para softwares, aplicativos, jogos, mobile">
  <meta name="author" content="elvio.com.br">
  <link rel="icon" href="favicon.ico">

  <title>Adriana Rosa | Locutora.com </title>
 
	<meta property="og:locale" content="pt_BR" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Adriana Rosa | Locutora profissional " />
	<meta property="og:description" content="Sou locutora profissional desde 1996, atuo no mercado publicitário há 12 anosgravações institucionais, spots, campanhas políticas, podcasts, chamadas, esperas telefônicas, uras, e-learnings, narrações, voz para softwares, aplicativos, jogos, mobile" />
	<meta property="og:url" content="http://locutora.com/" />
	<meta property="og:site_name" content="locutora.com" />

	<link rel="canonical" href="http://locutora.com/" />

    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_url(); ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo site_url(); ?>css/jumbotron-narrow.css" rel="stylesheet">
 
	
	<script src="<?php echo site_url(); ?>js/ytembed.js"></script>
 

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <!-- google-analytics -->
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59182398-1', 'auto');
  ga('send', 'pageview');

</script>

    <div class="container">
      <div class="header">
       
          <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!--<a class="navbar-brand" href="">adriana@locutora.com (11)98440-4171</a>-->
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if (isset($_GET['p']) =="") {?> class="active" <?php } ?>><a href="http://www.locutora.com/">Home</a></li>
           
            <li <?php if (isset($_GET['p']) =="contato") {?> class="active" <?php } ?>><a href="contato">Contato</a></li>
             
          </ul>
           
        </div><!--/.nav-collapse -->
      </div>
    </div>
      </div>

      <?php
	  if (!isset($_GET['p'])):
		include_once 'includes/home.php';
	  else:
		carregaUrlAmigavel($_GET['p']);
	  endif;
	?>   
	<div class="col-lg-12">
	  <h2>Clientes</h2>
	  <?php //include_once 'pastas.php'; ?>
    <?php include "clientes.php";?>
	  </div>
	  
      <div class="footer">
        <p>&copy; 2014 - locutora.com - adrianarosa@locutora.com (11) 9 8440-4171</p>
        <div id="elvio-footnote-links" class="text-center" style=" font-size:10px">
        <br />Designed by <a href="http://elvio.com.br" title="Web Designer em Itu" target="_blank">elvio</a>.</div>
      </div>

    </div> <!-- /container -->


   
   
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo site_url(); ?>js/bootstrap.min.js"></script>

<script src="<?php //echo site_url(); ?>js/yunero.js"></script>
<!--<script src="<?php //echo site_url(); ?>js/yunero.min.js"></script>-->

 

<!-- Contact Form JavaScript -->
<!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
<script src="<?php echo site_url(); ?>js/jqBootstrapValidation.js"></script>
<!--<script src="<?php echo site_url(); ?>js/contact_me.js"></script>-->
  </body>
</html>
