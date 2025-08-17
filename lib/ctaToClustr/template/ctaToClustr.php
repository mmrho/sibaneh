<?php
defined('ABSPATH') || exit;

// get the target for this instance
$target = isset($GLOBALS['cta_target']) ? $GLOBALS['cta_target'] : '#site-header';
$instance = isset($GLOBALS['cta_instance']) ? $GLOBALS['cta_instance'] : 1;
?>

<div class="ctaToClustr-container" data-instance="cta-instance-<?php echo esc_attr($instance); ?>">
    <div class="cta-spacer" data-spacer="cta-instance-<?php echo esc_attr($instance); ?>"></div>
    <nav class="local-nav" aria-label="Local Nav" data-target="<?php echo esc_attr($target); ?>">
        <div class="inner">
            <div class="product">
                <button id="productToggle" aria-expanded="false" aria-controls="sheet" aria-haspopup="menu">
                    راه اندازی و شروع به کار
                    <i class="icon-down-open"></i>
                </button>
            </div>
            <div class="nav-links">
                <a href="#overview">Overview</a>
                <a href="#switch">Switch</a>
                <a href="#tech">Tech Specs</a>
                <a class="buy-btn" href="#buy">Buy</a>
            </div>
        </div>
    </nav>

    <div class="overlay" id="overlay"></div>

    <div class="sheet" id="sheet">
        <div class="sheet-inner">
            <div class="sheet-item"><a href="#">iPhone 16 Pro</a></div>
            <div class="sheet-item"><a href="#">iPhone 16</a></div>
            <div class="sheet-item"><a href="#">iPhone 15</a></div>
            <div class="sheet-item"><a href="#">iPhone SE</a></div>
            <div class="sheet-item"><a href="#">Compare</a></div>
        </div>
    </div>
</div>