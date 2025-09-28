<?php
/* Template Name: AppShowcase  */

if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>
<!-- Main -->
<main class="main-content AppShowcase-main">
    <?php wbsLoadAppShowcase(); ?>
</main>
<?php get_footer(); ?>