<?php 
    include_once './autoload.php';
    $controller = new WelcomeController();
    $controller->Listener();
    unset($controller);
?>