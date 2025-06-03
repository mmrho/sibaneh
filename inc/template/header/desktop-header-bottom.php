<?php require_once THEME_TEMPLATE . 'header/shared-content.php'; ?>


        <div class="col-12">
            <div class="site-header-bottom">
                <!-- Main Navigation -->
                <nav class="site-nav">
                    <ul class="site-nav-list">
                        <?php foreach($main_menu as $menu_item): ?>
                            <li class="site-nav-item <?php echo $menu_item['has_submenu'] ? 'has-submenu' : ''; ?>">
                                <a class="site-nav-link" href="<?php echo $menu_item['url']; ?>">
                                    <?php echo $menu_item['title']; ?>
                                    <?php if($menu_item['has_submenu']): ?>
                                        <i class="icon-down-open"></i>
                                    <?php endif; ?>
                                </a>
                                <?php if($menu_item['has_submenu'] && isset($menu_item['submenu'])): ?>
                                    <ul class="submenu">
                                        <?php foreach($menu_item['submenu'] as $sub_item): ?>
                                            <li><a href="<?php echo $sub_item['url']; ?>"><?php echo $sub_item['title']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                
                <!-- Search Container -->
                <div class="search-container">
                    <button class="search-icon" onclick="toggleSearch()">
                        <i class="icon-search-1"></i>
                    </button>
                    <div class="search-bar" id="search-bar">
                        <input type="text" placeholder="<?php echo $site_data['search_placeholder']; ?>" />
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <button class="<?php echo $action_buttons['service']['class']; ?>">
                    <span class="service-button-text"><?php echo $action_buttons['service']['text']; ?></span>
                </button>
                <button class="<?php echo $action_buttons['login']['class']; ?>">
                    <span class="login-button-text"><?php echo $action_buttons['login']['text']; ?></span>
                </button>
            </div>
        </div>
    </div>
</div>