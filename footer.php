<?php get_template_part('parts/global/wrapper-end');
/* Main Content End */

/* Before Footer */
get_template_part('parts/footer/footer-start');


WEP_Tag::container('open', true);

/* Footer Top */
get_template_part('parts/footer/footer-top');
/* Footer Top End */

/* Footer Middle */
get_template_part('parts/footer/footer-middle');
/* Footer Middle End */

/* Footer Bottom */
get_template_part('parts/footer/footer-bottom');
/* Footer Bottom End */

WEP_Tag::container('end');

/* Footer Content */
WEP_Tag::container();
WEP_Tag::row();

get_template_part('parts/footer/footer-copyright');
get_template_part('parts/footer/footer-menu');
get_template_part('parts/footer/footer-widgets');

WEP_Tag::row('end');
WEP_Tag::container('end');
/* Footer Content End */

get_template_part('parts/footer/footer-end')
/* After Footer */

?>

</div><!-- /#wrapper -->

<?php
wp_footer();
?>
</body>

</html>