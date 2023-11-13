<?php extract($args) ?>
<?php
$classes = isset($responsive) && $responsive ? 'img-fluid' : '';
$classes .= isset($tag_classes) ? ' ' . $tag_classes : '';

$the_src = "src='$src'";
$the_id = isset($tag_id) && $tag_id ? "id='$tag_id'" : "";
$the_classes = isset($classes) ? "class='$classes'" : "";
$the_width = isset($tag_width) && $tag_width ? "width='$tag_width'" : "";
$the_height = isset($tag_height) && $tag_height ? "height='$tag_height'" : "";
$the_alt = isset($tag_alt) && $tag_alt ? "class='$tag_alt'" : "";
$the_style = isset($tag_style) && $tag_style ? "style='$tag_style'" : "";
$the_atts = isset($tag_atts) && $tag_atts ? $tag_atts : "";

?>

<?php printf("<img %s %s %s %s %s %s %s %s />", $the_src, $the_id, $the_classes, $the_width, $the_height, $the_alt, $the_style, $the_atts) ?>
