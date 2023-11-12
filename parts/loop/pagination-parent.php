<?php  
// Parent post navigation.
the_post_navigation(
    array(
        'prev_text'  => esc_html_x('Published in %title', 'Parent post link', 'vieclam24'),
        'aria_label' => esc_html__('Parent post', 'vieclam24'),
    )
);
