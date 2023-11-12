<?php get_template_part('parts/global/wrapper-end');
/* Main Content End */

/* Before Footer */
get_template_part('parts/global/footer-start');
get_template_part('parts/global/container-start');
get_template_part('parts/global/row-start');

/* Footer Content */
get_template_part('parts/footer/footer-copyright');
get_template_part('parts/footer/footer-menu');
get_template_part('parts/footer/footer-widgets');
/* Footer Content End */

get_template_part('parts/global/row-end');
get_template_part('parts/global/container-end');
get_template_part('parts/global/footer-end') 
/* After Footer */

?>

</div><!-- /#wrapper -->

<?php
wp_footer();
?>
</body>

</html>