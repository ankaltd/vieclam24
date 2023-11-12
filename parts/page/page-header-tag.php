<header class="page-header">
    <h1 class="page-title"><?php printf(esc_html__('Tag: %s', 'vieclam24'), single_tag_title('', false)); ?></h1>
    <?php
    $tag_description = tag_description();
    if (!empty($tag_description)) :
        echo apply_filters('tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>');
    endif;
    ?>
</header>