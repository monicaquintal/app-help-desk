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

## Aula 04: Protegendo páginas restritas com SESSION. 🔐