<?php

	require 'php/Usuarios.php';
	$usuarios=new Usuarios();
	$usuarios->login();

?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Sistema de login e gerenciamento de usuários em PHP orientado a objetos.">
    <meta name="author" content="Moiśes Feliciano">
    <meta name="generator" content="">
    <title>Login</title>

    
    <link rel="stylesheet" type="text/css" href="assets/dist/css/sign.css">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/dist/css/custom.css" rel="stylesheet">

    <script>
	    //função que marca o tempo em que a mensagem ficará na tela
      setTimeout(function() {
        document.getElementById("mensagem").remove();
      }, 5000); // Remove a mensagem após 5 segundos  
    </script>


    <style>
       .form-border {
            border: 1px solid rgb(0, 0, 0);
            border-radius: 20px;
            background-color: rgb(255, 254, 254); 
        } 

        #mensagem, h1, h2{
            text-align: center;
            color: red;
        }

    </style>

  </head>
  <body class="background-body">  
    <main class="form-signin w-100 m-auto form-border">
      <img class="mb-4" src="assets/brand/user.jpg" alt="user" width="72" height="72">
      <form action="login.php" method="post" class="form-signin">
        
        <h1 class="h3 mb-3 fw-normal">Login</h1>

        <div class="form-floating">
          <input type="text" class="form-control" id="floatingInput" name="usuario" placeholder="name@example.com" required autofocus>
          <label for="floatingInput">Usuário</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" name="senha" placeholder="Password" required>
          <label for="floatingPassword">Senha</label>
        </div>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" name="lembrar" value="remember-me"> Lembrar de mim
          </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Acessar!</button>
      </form>
      <div id="mensagem"> 
          <?php
              //mensagem do sistema alertando "Login/Senha inválido(s)" ou "Logout"
              if(isset($_GET["msg"])){
                  echo $_GET["msg"];
              }
          ?>
      </div>
    </main>    
  </body>
</html>
