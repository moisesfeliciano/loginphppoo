<?php
require_once 'php/Usuarios.php';
$usuarios=new Usuarios();
$usuarios->protege();

if (isset($_GET['id'])) {
    
    $usuarios->deleteUsuarios($_GET['id']);
}
header('Location: lista-usuario.php');
exit();


?>