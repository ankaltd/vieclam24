<footer class="mt-96">
    <div class="relative flex flex-col justify-between w-full bg-primary-100 text-white opacity-[90%] md:pb-0 pb-0">
        <div class="wp-container !max-w-[1320px] px-4">
            <?php
            get_template_part('parts/footer/footer-home/1-footer-top-contact-support');
            get_template_part('parts/footer/footer-home/2-footer-jobs-by-location-columns');
            get_template_part('parts/footer/footer-home/3-footer-about-information');
            get_template_part('parts/footer/footer-home/4-footer-copyright');
            ?>
        </div>
    </div>
</footer>
<?php

wp_footer();
?>
</body>

</html>