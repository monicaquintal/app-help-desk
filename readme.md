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

1. include: 

Traz o conteúdo do script em que nos encontramos, bem como o conteúdo daquele que foi incorporado.

~~~php
include('menu.php');
~~~

Podemos também omitir os parentes na sintaxe, em qualquer um dos construtores.

Quando o include produz um erro no processo de inclusão de script (como no caso de não localizar o script que queremos adicionar), ele gera um warning (apenas um alerta, não afetando o processamento do script).

2. include_once: 

Permite a inclusão de um script apenas uma vez!

~~~php
include_once 'menu.php';
~~~

3. require:

Quando o require produz um erro no processo de inclusão de script (como no caso de não localizar o script que queremos add), ele gera um fatal error (interrompendo completamente o funcionamento do script).

~~~php
require('menu2.php'); 
~~~

4. require_once:

Permite a inclusão de um script apenas uma vez!

~~~php
require_once 'menu.php';
~~~

## Aula 06: Refactoring do projeto com require_once.