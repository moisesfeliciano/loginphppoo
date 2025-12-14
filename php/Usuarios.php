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
    

    public function cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $sql="INSERT INTO " . $this->table_name . "(`nome`,`email`,`usuario`,`tipo`,`senha`) VALUES (:nome,:email,:usuario,:tipo,:senha);";
            $mysql=$this->mysql->prepare($sql);
            $mysql->bindValue(':nome', $_POST['nome'],PDO::PARAM_STR);
            $mysql->bindValue(':email', $_POST['email'],PDO::PARAM_STR);
            $mysql->bindValue(':usuario', $_POST['usuario'],PDO::PARAM_STR);
            $mysql->bindValue(':tipo', $_POST['tipo'],PDO::PARAM_STR);
            $mysql->bindValue(':senha', $this->hash($_POST['senha']),PDO::PARAM_STR);
            $mysql->execute();

            $msg = $_POST['nome'] . " Cadastrado com sucesso!";
            header('Location: lista-usuario.php?msg=' . urlencode($msg));

            exit();
        }
    }


    public function protege()
    {
        session_start();

       
        if (!isset($_SESSION["usuario"]) || empty($_SESSION["usuario"])) {
            $_SESSION["url"] = $_SERVER['REQUEST_URI'];
            header('Location: login.php');
            exit(); 
        }

        
        $usuario = $_SESSION["usuario"] ?? null;
    }


    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.html');
        exit();
    }


    public function listarUsuarios()
    {
        $sql = "SELECT * FROM " . $this->table_name;
        $stmt = $this->mysql->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->mysql->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizar($id, $nome, $email, $usuario, $tipo, $senha = null) {
        try {
            
            if ($senha) {
                $sql = "UPDATE  " . $this->table_name .
                        " SET nome = :nome, email = :email, usuario = :usuario, tipo = :tipo, senha = :senha 
                        WHERE id = :id";
                $stmt = $this->mysql->prepare($sql);
                $stmt->bindValue(':senha', $this->hash($senha));
            } else {
                $sql = "UPDATE  " . $this->table_name .
                        " SET nome = :nome, email = :email, usuario = :usuario, tipo = :tipo
                        WHERE id = :id";
                $stmt = $this->mysql->prepare($sql);
            }
            
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':usuario', $usuario);
            $stmt->bindValue(':tipo', $tipo);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro detalhado na atualização: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUsuarios($id)
    {
        try {
            $sql = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->mysql->prepare($sql);
            $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute(); // Retorna true em caso de sucesso, false em caso de falha.
        } catch (PDOException $e) {
            // Em um ambiente de produção, registre o erro em um arquivo de log.
            error_log("Erro ao deletar usuário: " . $e->getMessage());
            return false; // Indica que a operação falhou.
        }
    }





    // MÉTODOS PROTEGIDOS



    protected function conectaBd()
    {
        $this->mysql = new PDO(
            'mysql:host='.$this->db['servidor'].';dbname='.$this->db['database'], $this->db['usuario'], $this->db['senha']
        );
        $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }



    

    protected function retUsuario($usuario)
    {
        $sql="SELECT * FROM " . $this->table_name . " WHERE  " . $this->table_name . " . `usuario` = :usuario";
        $mysql=$this->mysql->prepare($sql);
        $mysql->bindValue(':usuario', $usuario,PDO::PARAM_STR);
        $mysql->execute();
        return $mysql->fetch(PDO::FETCH_ASSOC);
    }


    protected function hash($senha)
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }




}



?>