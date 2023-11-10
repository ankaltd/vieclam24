<?php

// Defined autoload class when call to
spl_autoload_register('autoload');
function autoload($class_name) {

    // convert class name into lowercase
    $class_name = strtolower($class_name);

    // convert all _ into -
    $class_name = str_replace('_', '-', $class_name);

    // If class name container "model" that is model, inside folder models    
    if (strstr($class_name, 'model')) {
        $path = THEME_APP . '/models/' . $class_name . '.php';

    } elseif (strstr($class_name, 'view')) {
        // If class name container "view" that is view, inside folder views        
        $path = THEME_APP . '/views/' . $class_name . '.php';

    } elseif (strstr($class_name, 'class')) {
        // If class name container "class" that is classe, inside folder classes        
        $path = THEME_APP . '/classes/' . $class_name . '.php';

    } elseif (strstr($class_name, 'admin')) {
        // If class name container "admin that is admin inside folder admin        
        $path = THEME_APP . '/admin/' . $class_name . '.php';

    } elseif (strstr($class_name, 'inc')) {
        // If class name container "inc that is inc inside folder includes        
        $path = THEME_APP . '/includes/' . $class_name . '.php';

    } elseif (strstr($class_name, 'acf')) {
        // If class name container "acf that is acf inside folder acf        
        $path = THEME_APP . '/acf/' . $class_name . '.php';

    } elseif (strstr($class_name, 'walker')) {
        // If class name container "walker that is acf inside folder walker        
        $path = THEME_APP . '/walker/' . $class_name . '.php';

    } elseif (strstr($class_name, 'page')) {
        // If class name container "page that is page inside folder pages        
        $path = THEME_APP . '/pages/' . $class_name . '.php';

    } elseif (strstr($class_name, 'page') && strstr($class_name, 'view')) {
        // If class name container "page that is page inside folder pages/views        
        $path = THEME_APP . '/pages/views/' . $class_name . '.php';

    } elseif (strstr($class_name, 'page') && strstr($class_name, 'model')) {
        // If class name container "page that is model inside folder pages/models        
        $path = THEME_APP . '/pages/models/' . $class_name . '.php';

    } else {
        // Other is normal class, inside folder classes
        $path = THEME_APP . '/controllers/' . $class_name . '.php';
    }

    // Nếu file tồn tại thì require_once
    if (file_exists($path)) {
        require_once($path);
    }
}
