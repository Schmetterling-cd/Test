<?php 
    include_once '/var/www/vlad/Test/autoload.php';
    $controller = new EmployeeController();
    $controller->Listener();
    unset($controller);
?>