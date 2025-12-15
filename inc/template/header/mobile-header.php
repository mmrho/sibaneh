<?php require_once THEME_TEMPLATE . 'header/shared-content.php'; ?>

<div class="mobile-header-container">
    <div class="mobile-header-content">
        <!-- Logo and Site Name -->
        <div class="mobile-header-brand header-element">
            <a href="<?php echo $site_data['url']; ?>" class="mobile-brand-link">
                <img class="img-fluid site-header-top-brand-logo"
                    src="<?php echo $site_data['logo']; ?>"
                    alt="">
                <span class="site-header-top-brand-name"><?php echo $site_data['name']; ?></span>
            </a>
        </div>

        <!-- Search and Menu Icons -->
        <div class="mobile-header-actions">
            <button class="search-icon mobile-btn header-element" type="button" id="searchIcon">
                <i class="icon-search-1"></i>
            </button>
            <button class="shopping-bag-icon mobile-btn header-element" type="button" id="shoppingBagIcon">
                <i class="icon-shopping-bag"></i>
            </button>
            <button class="mobile-menu-toggle" type="button" id="menuBtnIcon">
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Content -->
    <div class="mobile-nav" id="mobile-nav">
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
            </div>
        </div>
        <div class="search-content">
            <div class="search-suggestions">
                <span>GTA</span>
                <span>اسنپ</span>
            </div>
        </div>
    </div>

    <!-- Mobile Shopping Panel -->
    <div class="mobile-shopping-panel" id="mobile-shopping-panel">
        <div class="shopping-header">
            <div class="shopping-container">
                <p>سبد خرید شما خالی است.</p>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
</div>