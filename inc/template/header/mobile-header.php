<?php require_once THEME_TEMPLATE . 'header/shared-content.php'; ?>

<div class="mobile-header-container">
    <div class="mobile-header-content">
        <!-- Logo and Site Name -->
        <div class="mobile-header-brand">
            <a href="<?php echo $site_data['url']; ?>" class="mobile-brand-link">
                <img class="img-fluid site-header-top-brand-logo"
                    src="<?php echo $site_data['logo']; ?>"
                    alt="">
                <span class="site-header-top-brand-name"><?php echo $site_data['name']; ?></span>
            </a>
        </div>

        <!-- Search and Menu Icons -->
        <div class="mobile-header-actions">
            <button class="search-icon mobile-search-btn" type="button">
                <i class="icon-search-1"></i>
            </button>
            <button class="mobile-menu-toggle" type="button">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Search Bar -->
    <div class="mobile-search-bar" id="mobile-search-bar">
        <div class="search-header">
            <div class="search-container">
                <div class="search-input-wrapper">
                    <i class="icon-search-1 search-input-icon"></i>
                    <input type="text" placeholder="<?php echo $site_data['search_placeholder']; ?>" />
                </div>
                <button class="search-cancel" type="button">لغو</button>
            </div>
        </div>
        <div class="search-content">
            <div class="search-suggestions">
                <span>GTA</span>
                <span>اسنپ</span>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
    <nav class="mobile-nav" id="mobile-nav">
        <div class="mobile-nav-header">
            <div class="mobile-nav-header-content">
                <div class="mobile-nav-logo">
                    <img src="<?php echo $site_data['logo']; ?>" alt="">
                    <span><?php echo $site_data['name']; ?></span>
                </div>
                <button class="mobile-nav-close" type="button">
                    <i class="icon-cancel"></i>
                </button>
            </div>
        </div>

        <div class="mobile-nav-content">
            <ul class="mobile-nav-list">
                <?php foreach ($main_menu as $menu_item): ?>
                    <li class="mobile-nav-item <?php echo $menu_item['has_submenu'] ? 'has-submenu' : ''; ?>">
                        <a class="mobile-nav-link" href="<?php echo $menu_item['url']; ?>"
                            <?php echo $menu_item['has_submenu'] ? 'data-has-submenu="true"' : ''; ?>>
                            <?php echo $menu_item['title']; ?>
                            <?php if ($menu_item['has_submenu']): ?>
                                <i class="icon-down-open"></i>
                            <?php endif; ?>
                        </a>
                        <?php if ($menu_item['has_submenu'] && isset($menu_item['submenu'])): ?>
                            <ul class="mobile-submenu">
                                <?php foreach ($menu_item['submenu'] as $sub_item): ?>
                                    <li><a href="<?php echo $sub_item['url']; ?>"><?php echo $sub_item['title']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Mobile Action Buttons -->
            <div class="mobile-nav-buttons">
                <button class="<?php echo $action_buttons['service']['class']; ?> mobile-service-btn">
                    <span class="service-button-text"><?php echo $action_buttons['service']['text']; ?></span>
                </button>
                <button class="<?php echo $action_buttons['login']['class']; ?> mobile-login-btn">
                    <span class="login-button-text"><?php echo $action_buttons['login']['text']; ?></span>
                </button>
            </div>

            <!-- Support Info -->
            <div class="mobile-nav-support">
                <span class="site-header-top-sale-number">
                    <?php echo $support_info['phone_label']; ?> : <?php echo $support_info['phone_number']; ?>
                </span>
                <a href="#" class="site-header-top-support-online-a">
                    <i class="<?php echo $support_info['support_icon']; ?>"></i><?php echo $support_info['support_text']; ?>
                </a>
            </div>
        </div>
    </nav>
</div>