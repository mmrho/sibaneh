<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <!-- Header -->
    <header id="site-header">

        <!-- removed -->


        <!-- mobile-header -->
        <div class="mobile-header">
            <?php require_once THEME_TEMPLATE . 'header/mobile-header.php'; ?>
        </div>

        <!-- desktop-header -->
        <div class="desktop-header">
            <?php require_once THEME_TEMPLATE . 'header/desktop-header-top.php'; ?>
            <?php require_once THEME_TEMPLATE . 'header/desktop-header-bottom.php'; ?>
        </div>

    </header>