<?php

/**
 * Template Name: Trang chủ (Cẩm nang)
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


new WEP_Page_Header();

new WEP_Page_Content('home-news');

new WEP_Page_Footer();
