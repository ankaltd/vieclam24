<?php extract($args) ?>
<?php
$classes = "container";
$classes .= isset($width) ? $width : '';
$classes .= isset($tag_classes) ? ' ' . $tag_classes : '';

?>

<?php printf("<div %s %s %s %s>", isset($tag_id) ? "id='$tag_id'" : "", isset($classes) ? "class='$classes'" : "", isset($tag_style) ? "style='$tag_style'" : "", isset($tag_atts) ? $tag_atts : "") ?>
