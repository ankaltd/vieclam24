<main id="main" class="container" <?php if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' style="padding-top: 100px;"';
                                    elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' style="padding-bottom: 100px;"';
                                    endif; ?>>
    <?php
    // If Single or Archive (Category, Tag, Author or a Date based page).
    if (is_single() || is_archive()) :
    ?>
        <div class="row">
            <div class="col-md-8 col-sm-12">
            <?php
        endif;
            ?>