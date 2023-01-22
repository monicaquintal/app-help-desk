<?php

session_start();
/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

  // remover índices do array de sessão 
  // unset():

  /*
  unset($_SESSION['x']);

  echo '<pre>';
  print_r($_SESSION);
  echo '</pre>';  
  */


  // destruir a variável de sessão (removendo todos os índices ao mesmo tempo)
  // session_destroy()

  /*
session_destroy();

echo '<pre>';
print_r($_SESSION);
echo '</pre>';  
*/

session_destroy();
header('Location: ./index.php');

?>