<?php
extract($args);
?>
<div id="post-0" class="content error404 not-found">
    <?php
    get_template_part('parts/404/entry-title');
    get_template_part('parts/404/entry-content', null, array('search_enabled' => $search_enabled));

    ?>
</div><!-- /#post-0 -->