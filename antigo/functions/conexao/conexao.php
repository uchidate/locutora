<?php
define("USER", "locutora11");
define("PASS", "locuto58ra11");
define("HOST", "mysql01.locutora1.hospedagemdesites.ws");
define("DBNAME", "locutora11");

//CONEXAO COM O BANCO DE DADOS
function conectar() {
      $dsn = "mysql:host=" . HOST . ";dbname=" . DBNAME . ";charset=utf8";
      
    try {
        $conectar = new PDO($dsn, USER, PASS);
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco " . $e->getMessage();
    }
    return $conectar;
}
