<div id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php
    the_content();

    wp_link_pages(
        array(
            'before'   => '<nav class="page-links" aria-label="' . esc_attr__('Page', 'vieclam24') . '">',
            'after'    => '</nav>',
            'pagelink' => esc_html__('Page %', 'vieclam24'),
        )
    );
    edit_post_link(
        esc_attr__('Edit', 'vieclam24'),
        '<span class="edit-link">',
        '</span>'
    );
    ?>
</div><!-- /#post-<?php the_ID(); ?> -->