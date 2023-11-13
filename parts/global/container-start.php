<?php extract($args) ?>
<?php
$classes = "container";
$classes .= isset($width) ? $width : '';
$classes .= isset($tag_classes) ? ' ' . $tag_classes : '';

$the_classes = isset($classes) ? "class='$classes'" : "";
$the_id = isset($tag_id) && $tag_id ? "id='$tag_id'" : "";
$the_style = isset($tag_style) && $tag_style ? "style='$tag_style'" : "";
$the_atts = isset($tag_atts) && $tag_atts ? $tag_atts : "";
?>

<?php printf("<div %s %s %s %s>", $the_id, $the_classes, $the_style, $the_atts) ?>
