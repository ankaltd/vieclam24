<?php
if (has_nav_menu('footer-menu')) : // See function register_nav_menus() in functions.php
    /*
								Loading WordPress Custom Menu (theme_location) ... remove <div> <ul> containers and show only <li> items!!!
								Menu name taken from functions.php!!! ... register_nav_menu( 'footer-menu', 'Footer Menu' );
								!!! IMPORTANT: After adding all pages to the menu, don't forget to assign this menu to the Footer menu of "Theme locations" /wp-admin/nav-menus.php (on left side) ... Otherwise the themes will not know, which menu to use!!!
							*/
    wp_nav_menu(
        array(
            'container'       => 'nav',
            'container_class' => 'col-md-6',
            //'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
            'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
            'theme_location'  => 'footer-menu',
            'items_wrap'      => '<ul class="menu nav justify-content-end">%3$s</ul>',
        )
    );
endif;
