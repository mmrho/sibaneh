<?php require_once THEME_TEMPLATE . 'header/shared-content.php'; ?>

<div class="desktop-header-container">
    <div class="site-header">
        <!-- Brand Logo and Name -->
        <a href="<?php echo $site_data['url']; ?>" class="site-header-top-brand">
            <img class="img-fluid site-header-top-brand-logo"
                src="<?php echo $site_data['logo']; ?>"
                alt="<?php echo $site_data['name']; ?> لوگو">
        </a>
        <!-- Main Navigation -->
        <nav class="site-nav">
            <ul class="site-nav-list">
                <?php foreach ($main_menu as $menu_item): ?>
                    <li class="site-nav-item <?php echo $menu_item['has_submenu'] ? 'has-submenu' : ''; ?>">
                        <a class="site-nav-link" href="<?php echo $menu_item['url']; ?>">
                            <span><?php echo $menu_item['title']; ?></span>
                            <?php if ($menu_item['has_submenu']): ?>
                                <i class="icon-down"></i>
                            <?php endif; ?>
                        </a>
                        <?php if ($menu_item['has_submenu'] && isset($menu_item['submenu'])): ?>
                            <div class="mega-menu">
                                <div class="mega-menu-container">
                                    <div class="mega-menu-content">
                                        <div class="submenu-column">
                                            <h3><?php echo $menu_item['title']; ?></h3>
                                            <ul>
                                                <li>
                                                    <a class="type-a" href="<?php echo $menu_item['url']; ?>">
                                                        مشاهده همه <?php echo $menu_item['title']; ?>
                                                        <i class="icon-up-left-arrow"></i>
                                                    </a>
                                                </li>

                                                <?php foreach ($menu_item['submenu'] as $sub_item): ?>
                                                    <li>
                                                        <a class="type-b" href="<?php echo $sub_item['url']; ?>">
                                                            <?php echo $sub_item['title']; ?>
                                                            <i class="icon-up-left-arrow"></i>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <!-- Search and Sales Info -->
        <div class="site-header-icons">
            <button class="search-icon desktop-btn header-element" type="button" id="searchIcon-D">
                <i class="<?php echo $support_info['search_icon']; ?>"></i>
            </button>
            <a href="<?php echo home_url('/cart'); ?>" class="shopping-bag-icon desktop-btn header-element" id="shoppingBagIcon-desktop">
                <i class="<?php echo $support_info['shoping_bag_icon']; ?>"></i>
            </a>
        </div>
    </div>
    <div class="mega-menu-background"></div>
    <div class="desktop-nav-overlay"></div>
</div>