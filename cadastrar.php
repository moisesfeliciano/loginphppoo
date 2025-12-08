<?php
	require 'php/Usuarios.php';
	$usuarios=new Usuarios();
	$usuarios->cadastrar();
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
    <title>Cadastrar Usuários</title>

  
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

      .col-md-8 {
        margin: 0 auto;
      }
    
    </style>

    
  </head>

  <body class="text background-body">   
    <main>
      <div class="container py-4">
        <header class="pb-3 mb-4 border-bottom">
            <span class="fs-4">Cadastrar Usuários</span>
          </a>
          <div class="nav-button">
              <a class="btn btn-dark" href="pagina-protegida.php" role="button">Voltar</a>            
        </div>
        </header>
        <div class="row align-items-md-stretch">
          <div class="col-md-8">
            <div class="bd-example-snippet bd-code-snippet">

              <form action="cadastrar.php" method="post" class="bd-example-form">

                <div class="mb-3">
                  <label for="inputNome" class="form-label">Nome</label>
                  <input type="text" class="form-control" id="inputNome" name="nome"  autofocus required>
                </div>

                <div class="mb-3">
                  <label for="inputEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" id="inputEmail" name="email" required>
                </div>

                <div class="mb-3">
                  <label for="inputUsuario" class="form-label">Usuário</label>
                  <input type="text" class="form-control" id="inputUsuario" name="usuario" required>
                </div>

                <div class="mb-3">
                  <label for="inputSenha" class="form-label">Senha</label>
                  <input type="password" class="form-control" id="inputSenha" name="senha">
                </div>

                <fieldset class="mb-3">
                  <label for="inputTipo" class="form-label">Tipo</label>
                  <div class="form-check">
                    <input type="radio" name="tipo" id="adm" value="adm">
                    <label class="form-check-label" for="inputTipo">Administrador</label>
                  
                    <input type="radio" name="tipo" id="user" value="user">
                    <label class="form-check-label" for="inputTipo">Usuário</label>
                  </div>
                </fieldset>
                <button type="submit" class="btn btn-dark">Cadastrar</button>
              </form>

            </div> <!-- /bd-example-snippet -->
          </div><!-- /.col --> 
        </div><!-- /.row -->

        <footer class="pt-3 mt-4 text-muted border-top">
          &copy; 2025
        </footer>

      </div><!-- /.container -->
    </main>   
  </body>
</html>
