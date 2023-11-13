<?php extract($args) ?>
<?php
$classes = isset($responsive) && $responsive ? 'img-fluid' : '';
$classes .= isset($tag_classes) ? ' ' . $tag_classes : '';
?>

<?php printf("<img %s %s %s %s %s />", "src='$src'", isset($tag_id) ? "id='$tag_id'" : "", isset($classes) ? "class='$classes'" : "", isset($alt) ? "class='$alt'" : "", isset($tag_style) ? "style='$tag_style'" : "", isset($tag_atts) ? $tag_atts : "") ?>
