<?php

session_start();

/*
print_r($_SESSION);
echo '<hr/>';
print_r($_SESSION['y']);
*/

// variável que verifica se a autenticação foi realizada
$usuario_autenticado = false;
$usuario_id = null;
$usuario_perfil_id = null;

$perfis = array(1 => 'Administrativo', 2 => 'Usuário');

// usuários do sistema
$usuarios_app = array(
  array('id' => 1, 'email' => 'adm@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
  array('id' => 2, 'email' => 'user@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
  array('id' => 3, 'email' => 'jose@teste.com.br', 'senha' => '1234', 'perfil_id' => 2),
  array('id' => 4, 'email' => 'maria@teste.com.br', 'senha' => '1234', 'perfil_id' => 2)
);

/*
echo '<pre>';
echo print_r($usuarios_app);
echo '</pre>';
*/


foreach($usuarios_app as $user) {

  /*
  echo 'Usuário app: ' . $user['email'] . ' / ' . $user['senha'];
  echo '<br />';
  echo 'Usuário form: ' . $_POST['email'] . ' / ' . $_POST['senha'];
  echo '<hr />';
  */

  if ($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {
    $usuario_autenticado = true;
    $usuario_id = $user['id'];
    $usuario_perfil_id = $user['perfil_id'];
  }
}

if ($usuario_autenticado) {
  echo "Usuário autenticado";
  $_SESSION['autenticado'] = 'SIM';
  $_SESSION['id'] = $usuario_id;
  $_SESSION['perfil_id'] = $usuario_perfil_id;
  header('Location: ./home.php');
} else {
  $_SESSION['autenticado'] = 'NAO';
  header('Location: ./index.php?login=erro');
}


/*

  Método GET:

  print_r($_GET);

  echo '<br />';
  echo $_GET['email'];
  echo '<br />';
  echo $_GET['senha'];
*/

/*

  Método POST:

  print_r($_POST);

  echo '<br />';
  echo $_POST['email'];
  echo '<br />';
  echo $_POST['senha'];

*/

?>