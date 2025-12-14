<?php
	require_once 'php/Usuarios.php';
    $usuarios=new Usuarios();
    $usuarios->protege();
    $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Listar Usuários</title>

  
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/dist/css/custom.css" rel="stylesheet">

	<script>

	function confirmaExclusao(id){

		if(confirm("Deseja realmente excluir este Usuário?")){
			location.href = "delete.php?id="+id; //redireciona
		}

	}

    var mensagem = <?php echo json_encode($msg); ?>;
        if (mensagem) {
            alert(mensagem);
        }

	</script>

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

    .col-md-12 {
    	margin: 0 auto;
    }

    

    .table {
      background-color: rgba(253, 253, 253, 1);
    }

    table .editar {
      background-color: rgba(29, 32, 214, 1);
      text-align: center;
    }

    table .excluir {
      background-color: rgba(214, 41, 29, 1);
      text-align: center;
    }

    table a {
      color: white;
    }

    table a:hover {
      color: yellow;
    }



    </style>

    
  </head>

  <body class="text background-body">   
    <main>
      <div class="container py-4">
        <header class="pb-3 mb-4 border-bottom">
            <span class="fs-4">Lista Usuários</span>
          </a>
          <div class="nav-button">
              <a class="btn btn-dark" href="pagina-protegida.php" role="button">Voltar</a>            
        </div>
        </header>
        <div class="row align-items-md-stretch">
          <div class="col-md-12">
            <div class="bd-example-snippet bd-code-snippet">

              <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th scope="col">NOME</th>
            <th scope="col">USUÁRIO</th>
            <th scope="col">EMAIL</th>
            <th scope="col">TIPO</th>
          </tr>
		  <?php 
        
			$lista = $usuarios->listarUsuarios();
			foreach ($lista as $usuario) {
			
			?>
          </thead>
          <tbody>
			<tr>
			<td class="list"><?php echo $usuario['nome'];?></td>
      <td class="list"><?php echo $usuario['usuario'];?></td>
			<td class="list"><?php echo $usuario['email'];?></td>
			<td class="list"><?php echo $usuario['tipo'];?></td>
			<td class="list editar">
				<a class="" href="editar.php?id=<?php echo $usuario['id']; ?>">Editar</a>
			</td>
			<td class="list excluir">
				<a class="" href="#" onclick='confirmaExclusao(<?php echo $usuario["id"]; ?>)' >Excluir</a>
			</td>
			</tr>
			<?php  } ?>
			<!-- Finaliza o loop -->
		</tbody>
        </table>

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