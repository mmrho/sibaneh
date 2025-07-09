<?php require_once THEME_TEMPLATE . 'header/shared-content.php'; ?>

<div class="desktop-header-container">
    <div class="row">
        <div class="col-12">
            <div class="site-header-top">
                <!-- Brand Logo and Name -->
                <a href="<?php echo $site_data['url']; ?>" class="site-header-top-brand">
                    <img class="img-fluid site-header-top-brand-logo" 
                        src="<?php echo $site_data['logo']; ?>" 
                        alt="<?php echo $site_data['name']; ?> لوگو">
                    <span class="site-header-top-brand-name"><?php echo $site_data['name']; ?></span>
                </a>
                
                <!-- Support and Sales Info -->
                <div class="site-header-top-support-sale">
                    <span class="site-header-top-sale-number">
                        <?php echo $support_info['phone_label']; ?> : <?php echo $support_info['phone_number']; ?>
                    </span>
                    <a href="#" class="site-header-top-support-online-a">
                        <i class="<?php echo $support_info['support_icon']; ?>"></i><?php echo $support_info['support_text']; ?>
                    </a>
                </div>
            </div>
        </div>