<?php
require_once './validador_acesso.php'; 
?>

<?php

// declarar array dos chamados!
$chamados = array();

// abrir o arquivo .hd
$arquivo = fopen('../arquivo.hd', 'r');

// percorrer cada uma das linhas do arquivo, recuperando os registros (enquanto houver registros - ou linhas - a serem recuperados)
while(!feof($arquivo)) {
  $registro = fgets($arquivo); // recupera o que há na linha; podemos estabelecer (ou ñ) um n° de bits a serem recuperados
  $chamados[] = $registro;
}

//lembrar de fechar o arquivo após manipulação!
fclose($arquivo);

?>

<html>
  <head>
    <meta charset="utf-8" />
    <title>App Help Desk</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
      .card-consultar-chamado {
        padding: 30px 0 0 0;
        width: 100%;
        margin: 0 auto;
      }
    </style>
  </head>

  <body>

    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">
        <img src="../assets/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
        App Help Desk
      </a>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="./logoff.php">SAIR</a>
        </li>
      </ul>
    </nav>

    <div class="container">    
      <div class="row">

        <div class="card-consultar-chamado">
          <div class="card">
            <div class="card-header">
              Consulta de chamado
            </div>
            
            <div class="card-body">
              
            <?php
              foreach($chamados as $chamado) { 
            ?>
                
            <?php
            $chamado_dados = explode('#', $chamado);

            // identificar se o perfil é administrativo ou usuário
            if($_SESSION['perfil_id'] == 2) {
              // implementar controle de visualização
              // só exibe chamado se foi criado pelo usuário!
              if($_SESSION['id'] != $chamado_dados[0]) {
                //significa que chamado foi aberto por outro usuário
                continue; // para que o foreach desconsidere o restante das info.
              }
            }

            if(count($chamado_dados) < 3) {
              continue;
            }

            ?>

              <div class="card mb-3 bg-light">
                <div class="card-body">
                  <h5 class="card-title">
                    <?= $chamado_dados[1]; ?>
                  </h5>
                  <h6 class="card-subtitle mb-2 text-muted">
                    <?= $chamado_dados[2]; ?>
                  </h6>
                  <p class="card-text">
                    <?= $chamado_dados[3]; ?>
                  </p>
                </div>
              </div>

              <?php }; ?>

              <div class="row mt-5">
                <div class="col-6">
                  <a class="btn btn-lg btn-warning btn-block" href="./home.php">Voltar</a>  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>