<?php

set_include_path('includes/');

function carregaUrlAmigavel($url) {

    $pasta = 'includes/';
    
    if (substr_count($url, "/") > 0):
        
        $explodeUrl = explode("/", $url);

        if (is_file($pasta.$explodeUrl[0] . '.php')):
            include_once $explodeUrl[0] . ".php";
        else:
            include_once '404.php';
        endif;

    else:

        if (is_file($pasta.$url . '.php')):
            include_once $url . ".php";
        else:
            include_once '404.php';
        endif;

    endif;
}