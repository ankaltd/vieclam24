<?php extract($args) ?>
<?php printf("<section %s %s %s %s>", isset($tag_id) ? "id='$tag_id'" : "", isset($tag_classes) ? "class='$tag_classes'" : "", isset($tag_style) ? "style='$tag_style'" : "", isset($tag_atts) ? $tag_atts : "") ?>
