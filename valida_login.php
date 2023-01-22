<?php

session_start();

/*
print_r($_SESSION);
echo '<hr/>';
print_r($_SESSION['y']);
*/

// variável que verifica se a autenticação foi realizada
$usuario_autenticado = false;

// usuários do sistema
$usuarios_app = array(
  array('email' => 'adm@teste.com.br', 'senha' => '1234'),
  array('email' => 'user@teste.com.br', 'senha' => 'abcd'),
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
  }
}

if ($usuario_autenticado) {
  echo "Usuário autenticado";
  $_SESSION['autenticado'] = 'SIM';
  $_SESSION['x'] = 'um valor';
  $_SESSION['y'] = 'outro valor';
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