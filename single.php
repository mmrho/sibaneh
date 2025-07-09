<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header('single');
?>
<!-- Main -->
<main class="main-content single-post-main">
    <?php wbsLoadSinglePage(); ?>
</main>
<?php get_footer(); ?>