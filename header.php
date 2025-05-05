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
        <div class="container-fluid site-header-container">
            <div class="row">
                <div class="col-12">
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
                <div class="col-12">
                    <div class="site-header-bottom">
                        <nav class="site-nav">
                            <ul class="site-nav-list">
                                <li class="site-nav-item">
                                    <a class="site-nav-link" href="#">
                                        خانه
                                    </a>
                                </li>
                                <li class="site-nav-item">
                                    <a class="site-nav-link" href="#">
                                        اپ‌استور
                                        <i class="icon-down-open"></i>
                                    </a>
                                </li>
                                <li class="site-nav-item">
                                    <a class="site-nav-link" href="#">
                                        مک‌استور
                                        <i class="icon-down-open"></i>
                                    </a>
                                </li>
                                <li class="site-nav-item">
                                    <a class="site-nav-link" href="#">
                                        توسعه‌دهندگان
                                        <i class="icon-down-open"></i>
                                    </a>
                                </li>
                                <li class="site-nav-item">
                                    <a class="site-nav-link" href="#">
                                        آموزش
                                        <i class="icon-down-open"></i>
                                    </a>
                                </li>
                                <li class="site-nav-item">
                                    <a class="site-nav-link" href="#">
                                        بلاگ
                                        <i class="icon-down-open"></i>
                                    </a>
                                </li>
                                <li class="site-nav-item">
                                    <a class="site-nav-link" href="#">
                                        چرا سیبانه؟
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <div class="search-container">
                            <button class="search-icon" onclick="toggleSearch()">
                                <i class="icon-search-1"></i>
                            </button>
                            <div class="search-bar" id="search-bar">
                                <input type="text" placeholder="جستجو..." />
                            </div>
                        </div>
                        <button class="service-button">
                            <span class="service-button-text">سرویس‌های سیبانه</span>
                        </button>
                        <button class="login-button">
                            <span class="login-button-text">ورود</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>