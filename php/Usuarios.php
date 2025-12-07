<?php

class Usuarios
{

    private $table_name = "usuarios";

    
    protected $mysql;
    protected $db = array(
        'servidor'=>'localhost',
        'database'=>'blog_usuario',
        'usuario'=>'moises',
        'senha'=>'39138431',
    );
    

    public function __construct()
    {
        $this->conectaBd();
    }


    protected function conectaBd()
    {
        $this->mysql = new PDO(
            'mysql:host='.$this->db['servidor'].';dbname='.$this->db['database'], $this->db['usuario'], $this->db['senha']
        );
        $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }



    

    public function login()
    {

        
        session_start();

        if ($_SERVER['REQUEST_METHOD']=='POST') {


            $usuario=$this->retUsuario($_POST['usuario']);

            if (password_verify($_POST['senha'], $usuario['senha'])) {

                if (password_needs_rehash($usuario['senha'], PASSWORD_DEFAULT)) {
                    $novoHash = $this->hash($_POST['senha']);
                    $this->atualizarSenha($usuario['id'], $novoHash);
                }

                $_SESSION["usuario"] = $usuario;

                
                if (isset($_POST['lembrar'])) {
                    $this->gerarEArmazenarTokens($usuario['id']);
                }

                
            }
            
            elseif (crypt($_POST['senha'], $usuario['senha']) === $usuario['senha']) {
                
                $novoHash = $this->hash($_POST['senha']);
                $this->atualizarSenha($usuario['id'], $novoHash);

                $_SESSION["usuario"] = $usuario;
            }
            
            else
            {
                $msg = "Login/Senha inválido(s)";
                header("location:login.php?msg=".$msg);
                exit();
            }
            
            

          
        } elseif (empty($_SESSION["usuario"]) && !empty($_COOKIE['remember_selector']) && !empty($_COOKIE['remember_validator'])) {
            
            $usuario = $this->validarTokenEAutenticar($_COOKIE['remember_selector'], $_COOKIE['remember_validator']);
            if ($usuario) {
                $_SESSION["usuario"] = $usuario;
            }

        }

         
        if (!empty($_SESSION["usuario"])) {

            if (empty($_SESSION["url"])) {
                header('Location: index.html');
                exit();
            } else {
                
                header('Location: '.$_SESSION["url"]);
                exit();
            }
        }
        
    }


}



?>