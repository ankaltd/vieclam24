<?php

/* Page Single_Product Class */

class WEP_Page_Single_Product {

    /* Init */
    public function __construct() {

        /** 
         * Before Product Content  
         *          
         * @class WEP_Page_Single_Product_View
         * 
         * @see render_wep_single_product_header_sticky()      
         */
        add_action('wep_single_product_before_content', array('WEP_Page_Single_Product_View', 'render_wep_single_product_header_sticky'), 10);

        /** 
         * Product Heading
         *          
         * @class WEP_Page_Single_Product_View
         * 
         * @see render_wep_single_product_title()      
         * @see render_wep_single_product_shared()      
         */
        add_action('wep_single_product_heading', array('WEP_Page_Single_Product_View', 'render_wep_single_product_title'), 10);
        add_action('wep_single_product_heading', array('WEP_Page_Single_Product_View', 'render_wep_single_product_shared'), 10);

        /** 
         * Product Gallery
         *          
         * @class WEP_Page_Single_Product_View
         * 
         * @see render_wep_single_product_gallery()      
         * @see render_wep_single_product_service_detail()      
         */
        add_action('wep_single_product_gallery', array('WEP_Page_Single_Product_View', 'render_wep_single_product_gallery'), 10);
        add_action('wep_single_product_gallery', array('WEP_Page_Single_Product_View', 'render_wep_single_product_service_detail'), 10);

        /** 
         * Product Properies
         *          
         * @class WEP_Page_Single_Product_View
         * 
         * @see render_wep_single_product_meta()      
         * @see render_wep_single_product_attributes()      
         * @see render_wep_single_product_offters()      
         * @see render_wep_single_product_cta_booking()      
         * @see render_wep_single_product_suggestion()      
         */
        add_action('wep_single_product_properties', array('WEP_Page_Single_Product_View', 'render_wep_single_product_meta'), 10);
        add_action('wep_single_product_properties', array('WEP_Page_Single_Product_View', 'render_wep_single_product_attributes'), 10);
        add_action('wep_single_product_properties', array('WEP_Page_Single_Product_View', 'render_wep_single_product_offters'), 10);
        add_action('wep_single_product_properties', array('WEP_Page_Single_Product_View', 'render_wep_single_product_cta_booking'), 10);
        add_action('wep_single_product_properties', array('WEP_Page_Single_Product_View', 'render_wep_single_product_suggestion'), 10);


        /** 
         * Product More Contents
         *          
         * @class WEP_Page_Single_Product_View
         * 
         * @see render_wep_single_product_real_photos()      
         * @see render_wep_single_product_tabs()      
         * @see render_wep_single_product_faqs()      
         * @see render_wep_single_product_comments()      
         * @see render_wep_single_product_review()      
         */

        // => Need optimize
        add_action('wep_single_product_more_contents', array('WEP_Page_Single_Product_View', 'render_wep_single_product_real_photos'), 10);

        // => Need optimize
        add_action('wep_single_product_more_contents', array('WEP_Page_Single_Product_View', 'render_wep_single_product_tabs'), 10);
        add_action('wep_single_product_after_tabs', array('WEP_Page_Single_Product_View', 'render_wep_single_product_after_tabs'), 10);

        add_action('wep_single_product_more_contents', array('WEP_Page_Single_Product_View', 'render_wep_single_product_faqs'), 10);
        add_action('wep_single_product_more_contents', array('WEP_Page_Single_Product_View', 'render_wep_single_product_comments'), 10);

        // => Need optimize
        add_action('wep_single_product_more_contents', array('WEP_Page_Single_Product_View', 'render_wep_single_product_review'), 10);

        /** 
         * Product Sidebar
         *          
         * @class WEP_Page_Single_Product_View
         * 
         * @see render_wep_get_sidebar()        
         */
        add_action('wep_single_product_sidebar', array('WEP_Page_Single_Product_View', 'render_wep_get_sidebar'), 10);


        /** 
         * Remove Default Component Gallery, Tab and Related,..
         *          
         */
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 20);
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);


        // Output
        self::render_content();
    }

    /* Get Content - Endpoint ========================================== */
    static public function render_content() {

        global $product;

        /**
         * Hook: wep_single_product_before_content.
         *
         * @hooked render_wep_single_product_header_sticky - 10
         */
        do_action('wep_single_product_before_content');

        // Begin of Container
        WEP_Tag::render_bs_tag(
            array(
                'id' => 'wep_main',
                'class' => 'container page_content',
                'tag' => 'div'
            )
        );

        // Title
        WEP_Tag::render_bs_tag('row');
        WEP_Tag::render_bs_tag('col-12');
        WEP_Tag::render_bs_tag('wep_service__title_wrapper');

        /**
         * Hook: wep_single_product_heading.
         *
         * @hooked render_wep_single_product_title - 10        
         * @hooked render_wep_single_product_shared - 20        
         */

        do_action('wep_single_product_heading');

        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();

        // Begin of Row
        WEP_Tag::render_bs_tag('row mb-1');

        // Begin of Main Content
        WEP_Tag::render_bs_tag('col-12 col-md-9');

        WEP_Tag::render_bs_tag('wep_content shadow p-2 mb-3 mb-md-0');

        /* Start the Loop */
        while (have_posts()) :

            WEP_Tag::render_bs_tag('wep_service_loop p-2');

            the_post();


            WEP_Tag::render_bs_tag('row');

            WEP_Tag::render_bs_tag('col-md-6');

            /**
             * Hook: wep_single_product_gallery.
             *
             * @hooked render_wep_single_product_gallery - 10        
             * @hooked render_wep_single_product_service_detail - 20        
             */

            do_action('wep_single_product_gallery');

            WEP_Tag::render_bs_close_tag();

            WEP_Tag::render_bs_tag('col-md-6');



            /**
             * Hook: wep_single_product_properties.
             *
             * @hooked render_wep_single_product_meta - 10        
             * @hooked render_wep_single_product_attributes - 10  
             * @hooked render_wep_single_product_offters - 30        
             * @hooked render_wep_single_product_cta_booking - 40        
             * @hooked render_wep_single_product_suggestion - 50        
             *       
             */
            do_action('wep_single_product_properties');
            WEP_Tag::render_bs_close_tag();
            WEP_Tag::render_bs_close_tag();

            the_content();

            WEP_Tag::render_bs_close_tag();

        endwhile;

        // End of the loop.
        WEP_Tag::render_bs_close_tag();

        WEP_Tag::render_bs_close_tag();

        // End of Main Content

        /**
         * Hook: wep_single_product_sidebar.
         *
         * @hooked render_wep_sidebar - 10         
         */
        do_action('wep_single_product_sidebar');


        WEP_Tag::render_bs_close_tag();
        // End of Row

        /* More Informaton */
        WEP_Tag::render_bs_tag('row');

        // Left Column
        WEP_Tag::render_bs_tag('col-12');

        /**
         * Hook: wep_single_product_more_contents.
         *
         * @hooked render_wep_single_product_real_photos - 10
         * @hooked render_wep_single_product_tabs - 20
         * @hooked render_wep_single_product_faqs - 30
         * @hooked render_wep_single_product_comments - 40
         * @hooked render_wep_single_product_review - 50
         */
        do_action('wep_single_product_more_contents');


        WEP_Tag::render_bs_close_tag();
        // End Left Column

        WEP_Tag::render_bs_close_tag();
        /* End More Informaton */

        WEP_Tag::render_bs_close_tag();
        // End of Container

        /**
         * Hook: wep_after_single_product_content.
         *
         * @hooked not yet
         */
        do_action('wep_after_single_product_content');
    }
}
