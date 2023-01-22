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
