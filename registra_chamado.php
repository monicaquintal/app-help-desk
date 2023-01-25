<?php

session_start();

// trabalhando na montagem do texto
// para garantir que qualquer # digitada pelo usuário seja substiuída, não gerando conflitos:
$titulo = str_replace('#', '-', $_POST['titulo']);
$categoria = str_replace('#', '-', $_POST['categoria']);
$descricao = str_replace('#', '-', $_POST['descricao']);

$texto = $_SESSION['id'] . '#' . $titulo . '#' . $categoria . '#' . $descricao . PHP_EOL;

// abrindo o arquivo
$arquivo = fopen('./arquivo.hd', 'a');

// escrevendo o texto
fwrite($arquivo, $texto);

// fechando o arquivo
fclose($arquivo);

//echo $texto;
header('Location: ./abrir_chamado.php');

?>
