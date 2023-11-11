<?php

// Defined autoload class when call to
spl_autoload_register('autoload');
function autoload($class_name) {

    // convert class name into lowercase
    $class_name = strtolower($class_name);

    // convert all _ into -
    $class_name = str_replace('_', '-', $class_name);

    /* 1 - MVC store in models - views - controllers folders */
    // If class name container "model" that is model, inside folder models    
    if (strstr($class_name, 'model')) {
        $path = THEME_APP . '/modules/models/' . $class_name . '.php';

    } elseif (strstr($class_name, 'view')) {
        // If class name container "view" that is view, inside folder views        
        $path = THEME_APP . '/modules/views/' . $class_name . '.php';   

    /* 2 - Admin classes store in admin folder */
    } elseif (strstr($class_name, 'admin')) {
        // If class name container "admin that is admin inside folder admin        
        $path = THEME_APP . '/admin/' . $class_name . '.php';  

    } elseif (strstr($class_name, 'admin') && strstr($class_name, 'view')) {
        // If class name container "admin that is page inside folder admin/views        
        $path = THEME_APP . '/admin/views/' . $class_name . '.php';

    } elseif (strstr($class_name, 'admin') && strstr($class_name, 'model')) {
        // If class name container "admin that is model inside folder admin/models        
        $path = THEME_APP . '/admin/models/' . $class_name . '.php';
    
    /* 3 - Frontend Page classes store in pages folder */
    } elseif (strstr($class_name, 'page')) {
        // If class name container "page that is page inside folder pages        
        $path = THEME_APP . '/pages/' . $class_name . '.php';

    } elseif (strstr($class_name, 'page') && strstr($class_name, 'view')) {
        // If class name container "page that is page inside folder pages/views        
        $path = THEME_APP . '/pages/views/' . $class_name . '.php';

    } elseif (strstr($class_name, 'page') && strstr($class_name, 'model')) {
        // If class name container "page that is model inside folder pages/models        
        $path = THEME_APP . '/pages/models/' . $class_name . '.php';

    /* 4 - Module classes store in modules folder and special in each sub folders*/
    } elseif (strstr($class_name, 'acf')) {
        // If class name container "acf that is acf inside folder acf        
        $path = THEME_APP . '/modules/acf/' . $class_name . '.php';

    } elseif (strstr($class_name, 'walker')) {
        // If class name container "walker that is acf inside folder walker        
        $path = THEME_APP . '/modules/walker/' . $class_name . '.php';   

    } elseif (strstr($class_name, 'woocommerce')) {
        // If class name container "woocommerce that is acf inside folder woocommerce        
        $path = THEME_APP . '/modules/woocommerce/' . $class_name . '.php';   

    } elseif (strstr($class_name, 'comment')) {
        // If class name container "comment that is acf inside folder comment        
        $path = THEME_APP . '/modules/comment/' . $class_name . '.php';       

    /* 5 - Else classes store in folders named includes - modules - controllers - classes */
    } else {
        
        $path = THEME_APP . '/includes/' . $class_name . '.php';

        if (!file_exists($path)) {
            $path = THEME_APP . '/modules/' . $class_name . '.php';

            if (!file_exists($path)) {
                $path = THEME_APP . '/controllers/' . $class_name . '.php';

                if (!file_exists($path)) {
                    $path = THEME_APP . '/classes/' . $class_name . '.php';
                }
            }
        }
    }

    // Nếu file tồn tại thì require_once
    if (file_exists($path)) {
        require_once($path);
    } else {
        // printf("<p>Không tìm thấy file: '$path'</p>");
    }
}
