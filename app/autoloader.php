<?php

// Defined autoload class when call to
spl_autoload_register('autoload');
function autoload($class_name) {

    /*
    * Hướng dẫn tạo file class:
    * 1 - Tên file và tên class trùng nhau chỉ khác tên file cách bằng -, tên class cách _ 
    * 2 - Các file Mvc tạo từng thu mục có chứa từ tương ứng view => folder /views, model => folder /models
    * 3 - Controller và các file khác đặt trong /controllers hoặc /includes /modules / classes
    * 4 - Các file dùng cho admin đặt trong /admin và các view => admin/view, model => admin/model
    * 5 - Các file dùng cho FE page đặt trong /page và các view => page/view, model => page/model
    * 6 - Các file module dùng cho FE module đặt trong /modules/module_name/module_controller.php 
    * + Các view + model => module/module_name/module_model.php và module/module_name/module_view.php => khai báo thêm bên dưới phần (4) từng module
    * + Nếu không có view, model thì đặt trực tiếp tại folder /modules/module_name.php
    */

    // convert class name into lowercase
    $class_name = strtolower($class_name);

    // convert all _ into -
    $class_name = str_replace('_', '-', $class_name);

    /* 1 - MVC store in models - views - controllers folders */
    // If class name container "model" that is model, inside folder models    
    if (strstr($class_name, 'model')) {
        $path = THEME_APP . '/models/' . $class_name . '.php';

    } elseif (strstr($class_name, 'view')) {
        // If class name container "view" that is view, inside folder views        
        $path = THEME_APP . '/views/' . $class_name . '.php';   

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

    } elseif (strstr($class_name, 'breadcrumb')) {
        // If class name container "breadcrumb that is acf inside folder breadcrumb        
        $path = THEME_APP . '/modules/breadcrumb/' . $class_name . '.php';       

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
