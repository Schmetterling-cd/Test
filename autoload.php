<?php

    function glob_tree_search($path, $pattern, $_base_path)
    {
        if (is_null($_base_path)) {
            $_base_path = '';
        } else {
            $_base_path .= basename($path) . '/';
        }
    
        $out = array();
        foreach(glob($path . '/' . $pattern, GLOB_BRACE) as $file) {
            $out[] = $_base_path . basename($file);
        }
        
        foreach(glob($path . '/*', GLOB_ONLYDIR) as $file) {
            $out = array_merge($out, glob_tree_search($file, $pattern, $_base_path));
        }
    
        return $out;
    }
    

    spl_autoload_register(function(string $class){
        
        $path = '/var/www/vlad/Test';
        $files = glob_tree_search($path, "{$class}.php", null);

        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
        $path = __DIR__."/{$files[0]}";
        if (is_readable($path)){
            require $path;
        }
    }
    );
?>