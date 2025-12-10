<?php
	require_once 'php/Usuarios.php';
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
    <title>Editar Usuários</title>

  
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
        color: var(--cor-texto);
        text-decoration: none;
      }

      a:hover {
        color: var(--cor-hover);
        text-decoration: none;
      }


      .pt-3{

         text-align: center;
         
      }

      .col-md-8 {
        margin: 0 auto;
      }

      .background-body {
        text-align: left;
      }




    </style>

    
  </head>
  <body class="background-body">   
    <main>
      <div class="container py-4">
        <header class="pb-3 mb-4 border-bottom">
            <span class="fs-4">Editar Usuários</span>
          </a>
          <div class="nav-button">
              <a class="btn btn-dark" href="lista-usuario.php" role="button">Voltar</a>            
        </div>
        </header>
        <div class="row align-items-md-stretch">
          <div class="col-md-8">
            <div class="bd-example-snippet bd-code-snippet">

        <?php



        
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $id = $_POST['id'];
              $nome = $_POST['nome'];
              $usuario = $_POST['usuario'];
              $email = $_POST['email'];
              $tipo = $_POST['tipo'];
              $senha = !empty($_POST['senha']) ? $_POST['senha'] : null;
              
            
              $resultado = $usuarios->atualizar($id, $nome, $email, $usuario, $tipo, $senha);
              
              if ($resultado) {

                $msg = $_POST['nome'] . " Atualizado com sucesso!";
                header('Location: lista-usuario.php?msg=' . urlencode($msg));
                exit();

              } else {
                $msg = $_POST['nome'] . " Não Atualizado!";
                header('Location: lista-usuario.php?msg=' . urlencode($msg));
                exit();
              }
          }
                  
    
        
        if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
            $id = (int) $_GET['id'];
            
        }
            $usuario = $usuarios->buscarPorId($id);

        ?>

              <form method="post" class="bd-example-form">

              <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>" >

                <div class="mb-3">
                  <label for="inputNome" class="form-label">Nome</label>
                  <input type="text" class="form-control" id="inputNome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                </div>

                <div class="mb-3">
                  <label for="inputEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>

                <div class="mb-3">
                  <label for="inputUsuario" class="form-label">Usuário</label>
                  <input type="text" class="form-control" id="inputUsuario" name="usuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" required>
                </div>

                <div class="mb-3">
                  <label for="inputSenha" class="form-label">Senha</label>
                  <input type="password" class="form-control" id="inputSenha" name="senha">
                </div>

                <fieldset class="mb-3">
                  <label for="inputTipo" class="form-label">Tipo</label>
                  <div class="form-check">
                    <input type="radio" name="tipo" id="adm" value="adm" <?php echo ($usuario['tipo'] == 'adm') ? 'checked' : ''; ?>> <!-- Operador tenário -->
                    <label class="form-check-label" for="adm">Administrador</label>
                  
                    <input type="radio" name="tipo" id="user" value="user" <?php echo ($usuario['tipo'] == 'user') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="user">Usuário</label>
                  </div>
                </fieldset>
                <button type="submit" class="btn btn-dark">Confirma</button>
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
