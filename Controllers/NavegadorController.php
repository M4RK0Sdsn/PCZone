<?php
class NavegadorController {
    public function render($view) {

        $viewPath = "Views/{$view}.php";

        // Comprueba si la vista existe
        if (file_exists($viewPath)) {
            require_once $viewPath; 
        } else {
            require_once 'Views/404.php';
        }
    }
}
?>
