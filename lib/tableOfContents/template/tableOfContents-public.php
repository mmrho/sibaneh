<?php
defined('ABSPATH') || exit;

// Get the target for this instance
$target = isset($GLOBALS['toc_target']) ? $GLOBALS['toc_target'] : '#site-header';
$instance = isset($GLOBALS['toc_instance']) ? $GLOBALS['toc_instance'] : 1;

// Define your sheet items
$sheet_items = [
    "iPhone 16 Pro",
    "iPhone 16",
    "iPhone 15",
    "iPhone SE",
    "Compare"
];
?>

<div class="tableOfContents-container" data-instance="toc-instance-<?php echo esc_attr($instance); ?>">
    <div class="toc-spacer" data-spacer="toc-instance-<?php echo esc_attr($instance); ?>"></div>

    <nav class="local-nav" aria-label="Local Nav" data-target="<?php echo esc_attr($target); ?>">
        <div class="inner">
            <div class="product">
                <button
                    id="productToggle-<?php echo esc_attr($instance); ?>"
                    aria-expanded="false"
                    aria-controls="sheet-<?php echo esc_attr($instance); ?>"
                    aria-haspopup="menu">
                    راه اندازی و شروع به کار
                    <i class="icon-down-open"></i>
                </button>
            </div>

            <div class="nav-links">
                <?php
                // Display first 3 sheet items in nav-links by default
                foreach (array_slice($sheet_items, 0, 3) as $item) {
                    echo '<a href="#">' . esc_html($item) . '</a>';
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="overlay" id="overlay-<?php echo esc_attr($instance); ?>"></div>

    <div class="sheet" id="sheet-<?php echo esc_attr($instance); ?>">
        <div class="sheet-inner">
            <?php foreach ($sheet_items as $item): ?>
                <div class="sheet-item"><a href="#"><?php echo esc_html($item); ?></a></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>