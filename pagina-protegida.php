<?php
	require 'php/Usuarios.php';
	$usuarios=new Usuarios();
	$usuarios->protege();
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Menu Usuários</title>

  
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/dist/css/custom.css" rel="stylesheet">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

    
      .nav-button {
        position: relative; 
        float: right;
        text-decoration: none;
      }

      a {
        color: #030303ff;
        text-decoration: none;
      }

      a:hover {
        color: #ec0b0bff;
        text-decoration: none;
      }


      .pt-3{

         text-align: center;
         
      }

    </style>

    
  </head>
  <body class="background-body">   
    <main>
      <div class="container py-4">
        <header class="pb-3 mb-4 border-bottom">
            <span class="fs-4">Menu Usuários</span>
          </a>
          <div class="nav-button">
              <a class="btn btn-danger" href="logout.php" role="button">Sair</a>             
        </div>
        </header>
        <div class="row align-items-md-stretch">
          <div class="col-md-4">
            <div class="h-100 p-5 text-bg-success rounded-3">
              <h2>Cadastro Usuários</h2>
              <hr>
              <br>
              <p>Clique no botão abaixo para cadastrar um novo usuário.</p>
              <button class="btn btn-light" type="button"><a href="cadastrar.php">Cadastrar</a></button>
            </div>
          </div>
          <div class="col-md-4">
            <div class="h-100 p-5 text-bg-primary border rounded-3">
              <h2>Listar Usuários</h2>
              <hr>
              <br>
              <p>Clique no botão abaixo para listar todos os usuários cadastrados.</p>
              <button class="btn btn-light" type="button"><a href="lista-usuario.php">Listar Usuários</a></button>
            </div>
          </div>
          <div class="col-md-4">
            <div class="h-100 p-5 text-bg-dark border rounded-3">
              <h2>Painel Financeiro</h2>
              <hr>
              <br>
              <p>Clique no botão abaixo para acessar o painel financeiro.</p>
              <button class="btn btn-light" type="button">Acessar</button>
            </div>
          </div>
        </div>
        <footer class="pt-3 mt-4 text-muted border-top">
          &copy; 2025
        </footer>
      </div>
    </main>   
  </body>
</html>
