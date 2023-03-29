<?php 
    include_once './autoload.php';
    $controller = new EmployeeController();
    $controller->Listener();
    unset($controller);
?>