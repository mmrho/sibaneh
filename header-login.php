<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <!-- Header -->
    <header id="site-header" style="border-bottom-width: 1px; border-bottom-color: #DCDCDC;">
        <div class="container-fluid site-header-container">
            <div class="row">
                <div class=" col-12">
                    <div class="site-header-top">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header-top-brand">
                            <img class="img-fluid site-header-top-brand-logo" src="<?php echo get_template_directory_uri() ?>/images/temp/sibaneh-logo.png" alt="سیبانه">
                            <h1 class="site-header-top-brand-name">سیبانه</h1>
                        </a>
                        <div class="site-header-top-support-sale">
                            <span class="site-header-top-sale-number">واحد فروش : ۰۹۹۹۹۸۸۶۲۰۲</span>
                            <a href="#" class="site-header-top-support-online-a"><i class="icon-Online-Support"></i>پشتیبانی</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>