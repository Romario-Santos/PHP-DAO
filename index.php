<?php
require_once("config.php");

/*
$sql = new Sql();
$usuarios = $sql->select("SELECT * FROM tb_usuarios");
echo json_encode($usuarios);
*/

/*
Carrega apenas um usuario
$usuario = new Usuario();
$usuario->loadById(2);
echo $usuario;
*/

//carrega todos os usuarios
//$lista = Usuario::getList();
//echo json_encode($lista);

//procura um usuario
//$search = Usuario::search("Ro");
//echo json_encode($search);


//carrega um usuario usando um login e a senha
$usuario = new Usuario();
$usuario->login("Romario","1234");
echo $usuario;