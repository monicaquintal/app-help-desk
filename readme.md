<div align="center">

<h1>App Help Desk 💻</h1>
<p>Desenvolvimento Web Completo 2022</p>
<p>Seção 11 - PHP 7</p>

</div>

## Aula 01: Iniciando o projeto 🚀

Preparando o ambiente.

## Aula 02: Formulários (Desvendando os métodos GET e POST). 🗯

O objetivo é encaminhar os dados de e-mail e senha para um script do servidor. Para isso:

- criação do arquivo `valida_login.php`.
- comunicação do front (index.php - requisição http) com o servidor e a resposta (valida_login.php - Apache).
- incluindo atributo `name` às tags de input (login e senha), informações que serão encapsuladas pelo browser e disparadas com a requisição.
- métodos de envio do formulário:

  a) GET: `$_GET`

    - é o padrão, quando não definimos um método.
    - as informações do formulário (a partir do name) serão encaminhadas ao servidor a partir da própria URL.
    - é uma superglobal (variável nativa que está sempre disponível em todos escopos).
    - é um array! Cada parâmetro encaminhado à URL torna-se um índice nesse array!!!
    - cria uma grande vulnerabilidade, pois expõe até mesmo a senha na URL.

  b) POST: `$_POST`

    - anexa os dados do formulário dentro da própria requisição, retirando da URL.
    - também é um array.

## Aula 03: Autenticando usuário. ✔

Através dos scripts PHP, do lado do servidor, podemos implementar lógicas que resolvam nossos problemas. Neste caso, como autenticar o usuário.

Inicialmente, é necessário ter acesso a uma relação de usuários do sistema. Como ainda não foi abordado Banco de Dados, foi criada a array `$usuarios_app`, para listá-los.

Para autenticar o usuário:

- Verificar se os dados preenchidos no front end (email e senha) são compatíveis com as informações que temos no back end (se correspondem a um usuário válido).
  - Se sim, informar que o usuário está autenticado.
  - Se não, retornar ao index.php e apresentar erro de usuário ou senha!
- Lembrar que a autenticação é um processo que habilita o controle de visualização de páginas restritas. Primeiro precisamos autenticar, para posteriormente controlar a visualização.
- Utilizar foreach para parcorrer os arrays, e if/else para verificar se há correspondência.
- Criação de uma variável que verifica se a autenticação foi realizada.

Em caso de erro de autenticação, será realizado o redirecionamento para index.php, com mensagem de erro de autenticação.
  - Utilizada a `função header()`, que espera uma string com definição de uma location, que será o destino para o qual encaminharemos a aplicação quando a instrução for interpretada (é um desvio).
  - Encaminhado o parâmetro "?login=erro" via GET.

A função nativa `isset()`, por sua vez, verifica se determinado índice de um array está settado. Com isso, verificamos a existência de um índice antes de tentar utilizá-lo!

A lógica da mensagem de erro na autenticação do usuário foram inseridas no arquivo index.php, utilizando tags curtas, para tornar a leitura mais amigável. Inclusive, o bloco HTML é inserido ENTRE as tags curtas, sendo executado apenas em caso de true (usuário inválido).

~~~php
<?php if(isset($_GET['login']) && $_GET['login'] == 'erro'){?>

<div class="text-danger">
  Usuário ou senha inválido(s)!
</div>

<?php } ?>
~~~

## Aula 04: Protegendo páginas restritas com SESSION. 🔐

A função é proteger algumas páginas (ou rotas) de serem acessadas via requisição HTTP! A ideia é que o acesso passe por um processo de autenticação.

A `Sessão` é um recurso que faz com que uma instância do browser, a partir de um identificador único, tenha condições de acessar uma determinada seção (espaço de memória) no lado do servidor. Ou seja, cria-se uma ponte (através de cookie ou URL). Pode ser usada dentro de qualquer script!

É incluída a instrução `session_start();` no início do script, antes de qualquer outra instrução que emita pro navegador uma saída (output de dados, como echo)!!! O comando session_start() inicia uma nova sessão ou resume uma sessão existente.

A superglobal `$_SESSION` (variáveis de sessão) consiste em um  array associativo contendo variáveis de sessão disponíveis para o atual script. Por tratar-se de uma 'superglobal' (ou variável global automática), está disponível em todos escopos pelo script. 

Por default, cada sessão em PHP dura 3 horas (podemos fechar o navegador e abrir novamente, com a sessão ainda ativa, pois o cookie ainda estará presente).

O compartilhamento de variáveis entre scripts permite, por exemplo, criar uma variável de controle no processo de autenticação, passível de ser acessada pelos demais scripts, com o objetivo de decidir se aquele determinado script deve ou não ser retornado em função do resultado do processo de autenticação.

No arquivo `valida_login.php`, verificando se foi autenticado:

~~~php
if ($usuario_autenticado) {
  echo 'Usuário autenticado';
  $_SESSION['autenticado'] = 'SIM';
} else {
  $_SESSION['autenticado'] = 'NAO';
  header('Location: ./index.php?login=erro');
}
~~~

E, em cada um dos demais scripts, redirecionando para o index (indicando erro) caso o usuário não seja autenticado:

~~~php
session_start();

if (!isset($_SESSION['autenticado'])|| $_SESSION['autenticado'] != 'SIM') {
  header('Location: ./index.php?login=erro2');
  echo $_SESSION['autenticado'];
}
~~~

E, por fim, imprimindo a mensagem de erro2 no arquivo index.php:

~~~php
<?php if(isset($_GET['login']) && $_GET['login'] == 'erro2'){?>

<div class="text-danger">
  Faça login antes de acessar as páginas protegidas!
</div>

<?php } ?>
~~~

## Aula 05: Incorporando scripts com include, include_once, require e require_once. 💡

Nesta aula, o objetivo é aprender a incorporar scripts dentro de outros scripts, a fim de evitar redundância de código dentro das aplicações.

> criação do diretório incorporando_scripts, para estudo do assunto!

Os 4 construtores do PHP são:

### 1. include: 

Traz o conteúdo do script em que nos encontramos, bem como o conteúdo daquele que foi incorporado.

~~~php
include('menu.php');
~~~

Podemos também omitir os parentes na sintaxe, em qualquer um dos construtores.

Quando o include produz um erro no processo de inclusão de script (como no caso de não localizar o script que queremos adicionar), ele gera um warning (apenas um alerta, não afetando o processamento do script).

### 2. include_once: 

Permite a inclusão de um script apenas uma vez!

~~~php
include_once 'menu.php';
~~~

### 3. require:

Quando o require produz um erro no processo de inclusão de script (como no caso de não localizar o script que queremos add), ele gera um fatal error (interrompendo completamente o funcionamento do script).

~~~php
require('menu2.php'); 
~~~

### 4. require_once:

Permite a inclusão de um script apenas uma vez!

~~~php
require_once 'menu.php';
~~~

## Aula 06: Refactoring do projeto com require_once. 🧩

Refatorando com o objetivo de isolar a lógica de validação de acesso para aproveitar essa lógica nas páginas que serão protegidas.

Para tal finalidade, inserido no início dos scripts `home.php`, `abrir_chamado.php` e `consultar_chamado.php` o seguinte comando:

~~~php
require_once './validador_acesso.php'; 
~~~

Optou-se pelo require_once pois o desejado nesse caso é que, em caso de qualquer problema na recuperação do script, ocorra um fatal error, evitando abertura de brechas (já que a validação é crucial).

## Aula 07: Navegação entre páginas. ⛵

Em caso de usuário autenticado, o script valida_login.php irá redirecionar para o arquivo home.php. Além disso, foi incluída a navegação dos links/botões.

## Aula 08: Encerrando a sessão (logoff). ❌

A intenção dessa aula é aprender a remover ou destruir variáveis, a fim de implementar recursos como logoff (sair intencionalmente da sessão). Há duas possibilidades:

### 1. remover índices do array de sessão:

Utilizar a função nativa `unset(<array>, <índice>)`. Essa função não é exclusiva para a superglobal $_SESSION, podendo ser utilizada para excluir índices de qualquer array, incuindo get e post.

Exemplo:

~~~php
unset($_SESSION['x']);
~~~

Tem inteligência para remover o índice *apenas* se este existir.

### 2. destruir a variável de sessão (removendo todos os índices ao mesmo tempo):

Utilizar a função específica `session_destroy()`, que remove todos os índices contidos na superglobal $_SESSION.

~~~php
session_destroy();
~~~

Nesse caso, a sessão será destruída, mas apenas numa próxima requisição é que não teremos acesso às variáveis de sessão. 

Portanto, após o destroy, forçar um redirecionamento, para que seja necessária uma nova requisição HTTP, onde a sessão já não conterá os índices.

~~~php
session_destroy();
header('Location: ./index.php');
~~~

## Aula 09: Registrando chamados. 📋

Como ainda não estudamos Banco de Dados, para registrar os chamados no App, faremos através da criação de um **arquivo txt**.

No arquivo `abrir_chamado.php`, definir o método de envio do formulário (no caso, $_POST) e action (destino para o qual será feito o submit do formulário quando o botão for clicado) que, neste caso, será `registra_chamado.php`.

Lembrar de atribuir `name`s aos inputs, para que crie uma associação chave-valor, a ser encaminhada ao servidor!

Criar o script **registra_chamado.php**, que recuperará os valores dos inputs.

Para `criar o arquivo de texto`, há algumas funções nativas. A seguir, faremos:

### 1. para abrir novo arquivo de texto:

~~~php
fopen('nome_do_arquivo.extensão', 'indicar_a_ação');
~~~

Dentre as ações possíveis: abrir arquivo, ler arquivo, posicionar cursor para escrita no início ou fim do arquivo, etc. Na [documentação](https://www.php.net/manual/en/function.fopen.php) podemos conferir as possibilidades de parâmetros a serem definidos!

Neste caso usamos o 'a', que abre o arquivo.

### 2. Para definir o que será escrito no arquivo:

O post é um array (objeto); devemos formatá-lo em uma estrutura de texto que seja mais simples.

Exemplo:

~~~php
// para garantir que qualquer # digitada pelo usuário seja substiuída, não gerando conflitos:
$titulo = str_replace('#', '-', $_POST['titulo']);
$categoria = str_replace('#', '-', $_POST['categoria']);
$descricao = str_replace('#', '-', $_POST['descricao']);
 
$texto = $titulo . '#' . $categoria . '#' . $descricao;

echo $texto;
~~~

Outra possibilidade é o uso da função nativa `implode()`, que com base em determinado caracter, transforma um array em uma string.

### 3. Escrevendo no arquivo de texto:

Podemos utilizar outra função nativa, chamada `fwrite()`. Exemplo:

~~~php
fwrite('referência_do_arquivo_que_abrimos', 'o_que_queremos_escrever');
~~~

No projeto:

~~~php
fwrite($arquivo, $texto);
~~~

### 4. Para fechar o arquivo:
Função nativa `fclose()`, como utilizada abaixo:

~~~php
fclose('referência_do_arquivo_aberto');
~~~

### 5. Delimitando chamados:

Delimitar um caractere especial OU usar a constante `PHP_EOL`, que armazena o caractere de quebra de linha de acordo com o SO que o programa está rodando!

### 6. Redirecionando a página:

Após abertura do chamado, redirecionar para o script "abrir_chamado.php".


## Aula 10: Consultando chamados. 🔍

Como recuperar as informações do back-end e apresentá-las no front-end? Ou seja, implementaremos a tela `consultar_chamado.php`.

Inicialmente, utilizar a função `fopen();` para abrir o arquivo hd. Porém, desta vez utilizaremos o parâmetro **'r'**, o qual executará apenas a leitura do arquivo.

Na sequência, percorrer cada uma das linhas do arquivo, recuperando os registros. Para isso, utilizar uma estrutura de repetição - nesse caso, o while.

A função `feof()` testa pelo fim de um arquivo; ou seja, percorre o arquivo, recuperando cada uma de suas linhas, até que identifique o fim do arquivo (end of file). Lembrar de utilizar o **operador de negação** para que entremos no laço ('not' feof => entra no laço).

Lembrar de fechar o arquivo após manipulação/leitura!

Exemplo:

~~~php
// abrir o arquivo .hd
$arquivo = fopen('arquivo.hd', 'r');

// percorrer cada uma das linhas do arquivo, recuperando os registros (enquanto houver registros - ou linhas - a serem recuperados)
while(!feof($arquivo)) {
  $registro = fgets($arquivo); // recupera o que há na linha; podemos estabelecer (ou ñ) um n° de bits a serem recuperados
  echo $registro . '<br>';
}

//lembrar de fechar o arquivo após manipulação!
fclose($arquivo);
~~~

Criar um array ($chamados) que conterá cada um dos $registros recuperados do arquivo .hd!

Utilizar a estrutura `foreach()` para percorrer array (dentro do script consultar_chamado.php).

A função nativa `explode()`, por sua vez, permitirá criar um novo array com base em um delimitador (no caso, o #)!

Substitir os itens "título", "categoria" e "descrição" pelos respectivos índices do array após explode!

Incluir a verificação se o array possui as informações necessárias para impressão (instrução continue, função count() e estrutura if/else).

~~~php
<?php
foreach($chamados as $chamado) { 
?>
  
<?php
$chamado_dados = explode('#', $chamado);

if(count($chamado_dados) < 3) {
continue;
}
?>

<div class="card mb-3 bg-light">
  <div class="card-body">
    <h5 class="card-title">
      <?= $chamado_dados[0]; ?>
    </h5>
    <h6 class="card-subtitle mb-2 text-muted">
      <?= $chamado_dados[1]; ?>
    </h6>
    <p class="card-text">
      <?= $chamado_dados[2]; ?>
    </p>
  </div>
</div>

<?php }; ?>
~~~

## Aula 11: Aplicando controle de perfil de usuários. 👩‍💻

### Metas: 

1. Criar dois perfis: 
- perfil administrativo: qualquer usuário adm pode visualizar **todos** os chamados;
- perfil do usuário: visualiza apenas seus próprios chamados.

2. Incluir no chamado quem foi o usuário responsável por sua abertura!

### Etapas:

1. Inclusão dos novos logins e senhas no script `valida_login.php`.

2. Definir ids para cada um dos usuários, no array $usuarios_app.

~~~php
$usuarios_app = array(
  array('id' => 1, 'email' => 'adm@teste.com.br', 'senha' => '1234'),
  array('id' => 2, 'email' => 'user@teste.com.br', 'senha' => '1234'),
  array('id' => 3, 'email' => 'jose@teste.com.br', 'senha' => '1234'),
  array('id' => 4, 'email' => 'maria@teste.com.br', 'senha' => '1234')
);
~~~

3. Garantir que o id possa ser utilizado em qualquer ponto da lógica da aplicação. Para isso, criar a variável `$usuario_id`, que a princípio receberá o valor "null".

~~~php
$usuario_id = null;
~~~

4. Após a lógica de identificação do usuário, recuperar a variável $usuario_id e atribuir a ela o índice específico. 

~~~php
if ($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {
  $usuario_autenticado = true;
  $usuario_id = $user['id'];
}
~~~

5. Utilizar a superglobal `$_SESSION` para associar o valor do id ($usuario_id), disponibilizando essa informação no escopo global da aplicação.

~~~php
if ($usuario_autenticado) {
  echo "Usuário autenticado";
  $_SESSION['autenticado'] = 'SIM';
  $_SESSION['id'] = $usuario_id;
  header('Location: ./home.php');
} else {
  $_SESSION['autenticado'] = 'NAO';
  header('Location: ./index.php?login=erro');
}
~~~

6. No script `registra_chamado.php`, executar `session_start();` e incluir na variávei $texto a instrução $_SESSION['id'].

~~~php
session_start();
<...>
$texto = $_SESSION['id'] . '#' . $titulo . '#' . $categoria . '#' . $descricao . PHP_EOL;
~~~

7. No script `consultar_chamado.php`, rearrajar os índices nas áreas corretas dos cards (já que os índices mudaram quando incuímos o id).

~~~php
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
~~~

8. Para **definir os perfis**, no script `valida_login.php`, criar um array chamado $perfis[], como abaixo:

~~~php
$perfis = array(1 => 'Administrativo', 2 => 'Usuário');

// atribuindo mais um associativo (para os id, no caso)
$usuarios_app = array(
  array('id' => 1, 'email' => 'adm@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
  array('id' => 2, 'email' => 'user@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
  array('id' => 3, 'email' => 'jose@teste.com.br', 'senha' => '1234', 'perfil_id' => 2),
  array('id' => 4, 'email' => 'maria@teste.com.br', 'senha' => '1234', 'perfil_id' => 2)
);
~~~

9. Incluir o `$perfil_id` na superglobal $_SESSION.

~~~php
$usuario_perfil_id = null;
<...>
if ($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {
  $usuario_autenticado = true;
  $usuario_id = $user['id'];
  $usuario_perfil_id = $user['perfil_id'];
}
<...>
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
~~~

10. Em `consultar_chamado.php`, implementar as regras de exibição dos chamados.

~~~php
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
~~~

## Aula 12: Segurança no back-end de aplicações web. 🔑

A fim de evitar vulnerabilidades na nossa aplicação, nessa aula foi abordada a segurança no back-end de aplicações web, a fim de evitar sua exposição (que informações sigilosas possam ser acessadas de forma indevida).

Na prática, tudo que está no diretório público de um servidor HTTP está disponível para o mundo, o que é inadequado, pois há scripts que implementam regras de negócio que são sigilosas, que devem ser protegidos!

O documento `arquivo.hd` e o repositório `valida_login.php` são arquivos que possuem informções sigilosas e detalhes de acesso, e estão expostos no script de forma hardcode.

Portanto, para contornar a vulnerabilidade:

### Para etirar os arquivos e scripts do diretório público do servidor HTTP:

- acessar o Explorer do XAMPP, e no diretório C:, criar uma nova pasta, chamada "app_help_desk" (fora do diretório público htdocs).

~~~
C:/xampp
  - app_help_desk 
    // (será o diretório de arquivos e scripts sigilosos)
  - htdocs/app_help_desk
    // diretório público
~~~

- recortar os arquivos e script sigilosos (valida_login.php e arquivo.hd) e colá-los no diretório app_help_desk.

- para que a aplicação tenha a inteligência de executar um código externo ao script, podem ser utilizados os comandos de inclusão, como `include`, `include_once`, `require` e `require_once`.

- dentro de htdocs/app_help_desk, criar um novo arquivo chamado `valida_login.php` (NOVO, o antigo estará no diretório sigiloso).

- neste novo arquivo `valida_login.php` , incluir:

~~~php
require "../../app_help_desk/valida_login.php";
~~~

- quanto ao arquivo `arquivo.hd`, este é utilziado nos scripts registra_chamado.php e consultar_chamado.php. Nestes casos, para ajustar a referência do arquivo:

~~~php
$arquivo = fopen('../../app_help_desk/arquivo.hd', 'r');
~~~
