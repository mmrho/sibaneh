<?php get_header(); ?>
<!-- Main -->
<main id="site-main">
    <div class="container-fluid">
        <?php
        require_once THEME_TEMPLATE . 'ribbon/ribbon.php';
        require_once THEME_TEMPLATE . 'home/main.php';
        require_once THEME_TEMPLATE . 'home/about.php';
        ?>
    </div>
</main>
<?php get_footer(); ?>