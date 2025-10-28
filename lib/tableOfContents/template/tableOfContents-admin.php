<?php
defined('ABSPATH') || exit;

/**
 * TOC - Admin page template (Modern UI)
 */

// تغییر نهایی: category رو اول از $_GET بگیر (که در submenu callback ست کردی)
$category = isset($_GET['category']) ? sanitize_key($_GET['category']) : '';

// اگر خالی بود، از screen ID ست کن
$screen = get_current_screen();
if (empty($category) && $screen) {
    $screen_id = strtolower($screen->id);
    if (strpos($screen_id, 'huboftheworldofapplicationsandgames') !== false) {
        $category = 'apps_games';
    } elseif (strpos($screen_id, 'comprehensiveappletutorials') !== false) {
        $category = 'apple_tutorials';
    } elseif (strpos($screen_id, 'newsandanalysis') !== false) {
        $category = 'news_analysis';
    } else {
        $category = 'default';
    }
}

// اگر همچنان خالی، پیش‌فرض
if (empty($category)) {
    $category = 'default';
    error_log('Category was empty in admin.php - set to default');
}

// نقشه‌برداری category به post_type و taxonomy
$category_map = [
    'apps_games' => [
        'post_type' => 'sib_app_game',
        'taxonomy' => 'sibaneh_category_app_game',
    ],
    'apple_tutorials' => [
        'post_type' => 'sib_apple_tut',
        'taxonomy' => 'sibaneh_category_apple_tut',
    ],
    'news_analysis' => [
        'post_type' => 'post',
        'taxonomy' => 'sibaneh_category_news_anal',
    ],
    'default' => [  // اضافه برای جلوگیری از ارور
        'post_type' => 'post',
        'taxonomy' => 'category',
    ],
];

// اگر category معتبر نبود، ارور
if (!isset($category_map[$category])) {
    echo '<div class="notice notice-error"><p>دسته‌بندی معتبر نیست!</p></div>';
    return;
}

$post_type = $category_map[$category]['post_type'];
$taxonomy = $category_map[$category]['taxonomy'];

?>

<div class="wrap ctato-wrap">
    <h1 class="ctato-title">TOC Manager - <?php echo esc_html($category ? ucwords(str_replace('_', ' ', $category)) : 'Default'); ?></h1>

    <div id="ctato-toc-manager" class="ctato-manager">

        <!-- Controls -->
        <div class="ctato-controls">
            <div class="ctato-field-group">
                <select id="ctato-post-select" class="ctato-select">
                    <option value="">— Select content —</option>
                    <?php
                    $args = [
                        'post_type'      => $post_type,  // داینامیک بر اساس category
                        'posts_per_page' => 500,
                        'post_status'    => ['publish', 'draft', 'private'],  // اضافه کردن draft برای پست‌های جدید
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                    ];

                    // بدون tax_query - همه پست‌های post_type رو بیار

                    $all = get_posts($args);
                    // برای دیباگ: اگر خالی بود، لاگ کن
                    if (empty($all)) {
                        error_log('No posts found for post_type: ' . $post_type . ', category: ' . $category . ', args: ' . print_r($args, true));
                    }
                    foreach ($all as $p) {
                        echo '<option value="' . esc_attr($p->ID) . '">' . esc_html(get_the_title($p->ID)) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="ctato-field-group">
                <input 
                    id="ctato-custom-title" 
                    type="text" 
                    class="ctato-input" 
                    placeholder="Optional custom title" 
                />
            </div>

            <div class="ctato-actions">
                <button id="ctato-add-new-content" class="button button-secondary">
                    Add New Content
                </button>
                <button id="ctato-add-node" class="button button-primary">
                    Add
                </button>
                <button id="ctato-save-tree" class="button button-success">
                     Save
                </button>
            </div>
        </div>

        <!-- Tree -->
        <div id="ctatoc-tree" class="ctato-tree"></div>

        <!-- Edit controls -->
        <div class="ctato-edit-controls">
            <button id="ctato-move-up" class="button button-secondary ctato-button" disabled>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </button>
            <button id="ctato-move-down" class="button button-secondary ctato-button" disabled>
                <span class="dashicons dashicons-arrow-down-alt2"></span>
            </button>
            <button id="ctato-edit-title" class="button button-secondary ctato-button" disabled>
                <span class="dashicons dashicons-edit"></span>
            </button>
            <button id="ctato-delete-node" class="button button-danger ctato-button" disabled>
                <span class="dashicons dashicons-trash"></span>
            </button>
        </div>

        <!-- Help -->
        <div class="ctato-help" style=" direction: ltr;">
            <details>
                <summary><strong>How it works</strong></summary>
                <p>
                    Drag and drop to make children.  
                    Select nodes to edit, move, or delete.  
                </p>
            </details>
            <span id="ctato-save-status" class="ctato-status" style=" direction: ltr;"></span>
        </div>
    </div>
</div>

<!-- Template -->
<script type="text/html" id="ctato-node-template">
    <span class="ctato-node-title"></span>
</script>