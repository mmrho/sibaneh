<?php
/**
 * Plugin Name: Sibaneh Academy
 * Description: Multiple custom post types and taxonomies for Sibaneh Academy, preserving original admin structure and URLs.
 * Version: 1.20
 */

namespace Sibaneh\Academy;

class SibanehAcademy {
    // Config for main sections (now as separate CPTs with short slugs)
    private $sections_config = [
        'sib_app_game' => [
            'title' => 'دنیای اپلیکیشن و بازی',
            'menu_title' => 'دنیای اپلیکیشن و بازی',
            'url_slug' => 'sibaneh_app_game',
        ],
        'sib_apple_tut' => [
            'title' => 'آموزش‌های جامع اپل',
            'menu_title' => 'آموزش‌های جامع اپل',
            'url_slug' => 'sibaneh_apple_tutorials',
        ],
    ];

    // News section config (using standard 'post')
    private $news_section = [
        'title' => 'اخبار و تحلیل‌ها',
        'menu_title' => 'اخبار و تحلیل‌ها',
        'url_slug' => 'sibaneh_news_analysis',
        'admin_slug' => 'edit.php',
        'post_type' => 'post',
        'taxonomy_suffix' => 'news_anal',
    ];

    // Config for terms (subcategories) - 'parent_slug' updated to short CPT slugs
    private $terms_config = [
        // [
        //     'name' => 'ویترین اپلیکیشن‌ها',
        //     'slug' => 'showcase-of-apps',
        //     'parent_slug' => 'sib_app_game',
        // ],
        [
            'name' => 'بررسی و معرفی اپلیکیشن‌ها',
            'slug' => 'review-and-introduction-of-apps',
            'parent_slug' => 'sib_app_game',
        ],
        [
            'name' => 'مقایسه اپلیکیشن‌ها',
            'slug' => 'compare-of-apps',
            'parent_slug' => 'sib_app_game',
        ],
        [
            'name' => 'آموزش اپلیکیشن‌ها',
            'slug' => 'tutorial-of-apps',
            'parent_slug' => 'sib_app_game',
        ],
        [
            'name' => 'ترفندها و راحل‌ها',
            'slug' => 'tricks-and-treats',
            'parent_slug' => 'sib_apple_tut',
        ],
        [
            'name' => 'آموزش استفاده از محصولات اپل',
            'slug' => 'how-to-use-apple-products',
            'parent_slug' => 'sib_apple_tut',
        ],
        [
            'name' => 'اخبار و تحلیل‌ها',
            'slug' => 'news-analysis',
            'parent_slug' => 'sib_news_anal',
        ],
    ];

    // Main menu config
    private $main_menu_config = [
        'title' => 'آکادمی سیبانه',
        'menu_title' => 'آکادمی سیبانه',
        'capability' => 'manage_options',
        'slug' => 'sibaneh_content_overview',
        'icon' => 'dashicons-media-document',
        'position' => 2,
    ];

    // Base slugs
    private $cpt_base_slug = 'sibaneh_content';
    private $taxonomy_base_slug = 'sibaneh_category';

    // Map url_slug to cpt_slug for lookups
    private $url_to_cpt_map = [];

    public function __construct() {
        // Build map
        foreach ($this->sections_config as $cpt_slug => $section) {
            $this->url_to_cpt_map[$section['url_slug']] = $cpt_slug;
        }

        add_action('init', [$this, 'register_cpts_and_taxonomies']);
        add_filter('register_post_type_args', [$this, 'modify_post_type_args'], 20, 2);
        add_action('init', [$this, 'insert_terms']);
        add_action('admin_menu', [$this, 'add_menus']);
        add_filter('parent_file', [$this, 'set_parent_file']);
        add_action('admin_head', [$this, 'add_custom_styles']);
        add_filter('post_class', [$this, 'highlight_old_posts'], 10, 3);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_preselect_script']);
        add_action('save_post', [$this, 'set_default_category_on_save'], 10, 3);
        add_filter('page_attributes_dropdown_pages_args', [$this, 'allow_page_parents'], 10, 2);
        add_filter('single_template', [$this, 'load_cpt_template']);
    }

    public function modify_post_type_args($args, $post_type) {
        if ('post' === $post_type) {
            $args['rewrite'] = ['slug' => $this->news_section['url_slug'], 'with_front' => false];
            $args['hierarchical'] = true;
            $args['supports'] = array_merge($args['supports'], ['page-attributes']);
        }
        return $args;
    }

    public function register_cpts_and_taxonomies() {
        foreach ($this->sections_config as $cpt_slug => $section) {
            $labels = [
                'name'                  => _x('محتوا', 'Post type general name', 'sibaneh'),
                'singular_name'         => _x('محتوا', 'Post type singular name', 'sibaneh'),
                'menu_name'             => _x('آکادمی سیبانه', 'Admin Menu text', 'sibaneh'),
                'name_admin_bar'        => _x('محتوا', 'Add New on Toolbar', 'sibaneh'),
                'add_new'               => __('افزودن جدید', 'sibaneh'),
                'add_new_item'          => __('افزودن محتوای جدید', 'sibaneh'),
                'new_item'              => __('محتوای جدید', 'sibaneh'),
                'edit_item'             => __('ویرایش محتوا', 'sibaneh'),
                'view_item'             => __('مشاهده محتوا', 'sibaneh'),
                'all_items'             => __('همه محتواها', 'sibaneh'),
                'search_items'          => __('جستجوی محتوا', 'sibaneh'),
                'parent_item_colon'     => __('محتوای والد:', 'sibaneh'),
                'not_found'             => __('محتوایی یافت نشد.', 'sibaneh'),
                'not_found_in_trash'    => __('محتوایی در زباله‌دان نیست.', 'sibaneh'),
                'featured_image'        => _x('تصویر شاخص', 'sibaneh'),
                'set_featured_image'    => _x('تنظیم تصویر شاخص', 'sibaneh'),
                'remove_featured_image' => _x('حذف تصویر شاخص', 'sibaneh'),
                'use_featured_image'    => _x('استفاده به عنوان تصویر شاخص', 'sibaneh'),
                'archives'              => _x('بایگانی محتوا', 'sibaneh'),
                'insert_into_item'      => _x('افزودن به محتوا', 'sibaneh'),
                'uploaded_to_this_item' => _x('آپلود شده به این محتوا', 'sibaneh'),
                'filter_items_list'     => _x('فیلتر لیست محتوا', 'sibaneh'),
                'items_list_navigation' => _x('راهبری لیست محتوا', 'sibaneh'),
                'items_list'            => _x('لیست محتوا', 'sibaneh'),
            ];

            $args = [
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => false,
                'query_var'          => true,
                'rewrite'            => ['slug' => $section['url_slug'], 'with_front' => false],
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => true,
                'menu_position'      => 2,
                'supports'           => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields', 'page-attributes'],
                'show_in_rest'       => true,
            ];

            register_post_type($cpt_slug, $args);

            // Register separate taxonomy for each CPT
            $taxonomy_slug = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $cpt_slug);
            $labels_tax = [
                'name'              => _x('دسته‌بندی محتوا', 'taxonomy general name', 'sibaneh'),
                'singular_name'     => _x('دسته‌بندی', 'taxonomy singular name', 'sibaneh'),
                'search_items'      => __('جستجوی دسته‌بندی', 'sibaneh'),
                'all_items'         => __('همه دسته‌بندی‌ها', 'sibaneh'),
                'parent_item'       => __('دسته‌بندی والد', 'sibaneh'),
                'parent_item_colon' => __('دسته‌بندی والد:', 'sibaneh'),
                'edit_item'         => __('ویرایش دسته‌بندی', 'sibaneh'),
                'update_item'       => __('به‌روزرسانی دسته‌بندی', 'sibaneh'),
                'add_new_item'      => __('افزودن دسته‌بندی جدید', 'sibaneh'),
                'new_item_name'     => __('نام دسته‌بندی جدید', 'sibaneh'),
                'menu_name'         => __('دسته‌بندی‌ها', 'sibaneh'),
            ];

            $args_tax = [
                'hierarchical'      => true,
                'labels'            => $labels_tax,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => ['slug' => 'sibaneh-category', 'hierarchical' => true],
                'show_in_rest'      => true,
            ];

            register_taxonomy($taxonomy_slug, $cpt_slug, $args_tax);
        }

        // Register taxonomy for news (attached to 'post')
        $taxonomy_slug = $this->taxonomy_base_slug . '_' . $this->news_section['taxonomy_suffix'];
        $labels_tax = [
            'name'              => _x('دسته‌بندی محتوا', 'taxonomy general name', 'sibaneh'),
            'singular_name'     => _x('دسته‌بندی', 'taxonomy singular name', 'sibaneh'),
            'search_items'      => __('جستجوی دسته‌بندی', 'sibaneh'),
            'all_items'         => __('همه دسته‌بندی‌ها', 'sibaneh'),
            'parent_item'       => __('دسته‌بندی والد', 'sibaneh'),
            'parent_item_colon' => __('دسته‌بندی والد:', 'sibaneh'),
            'edit_item'         => __('ویرایش دسته‌بندی', 'sibaneh'),
            'update_item'       => __('به‌روزرسانی دسته‌بندی', 'sibaneh'),
            'add_new_item'      => __('افزودن دسته‌بندی جدید', 'sibaneh'),
            'new_item_name'     => __('نام دسته‌بندی جدید', 'sibaneh'),
            'menu_name'         => __('دسته‌بندی‌ها', 'sibaneh'),
        ];

        $args_tax = [
            'hierarchical'      => true,
            'labels'            => $labels_tax,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'sibaneh-category', 'hierarchical' => true],
            'show_in_rest'      => true,
        ];

        register_taxonomy($taxonomy_slug, $this->news_section['post_type'], $args_tax);
   
   
        // ---------------------------------------------------------
        // احیای دستی پورتفولیو زفایر (چون قالب زفایر غیرفعال است)
        // ---------------------------------------------------------

        // 1. ثبت پست تایپ us_portfolio
        register_post_type('us_portfolio', [
            'labels' => [
                'name'          => 'ویترین اپلیکیشن‌ها (Portfolio)',
                'singular_name' => 'اپلیکیشن',
                'add_new'       => 'افزودن اپلیکیشن',
                'add_new_item'  => 'افزودن اپلیکیشن جدید',
                'edit_item'     => 'ویرایش اپلیکیشن',
                'all_items'     => 'همه اپلیکیشن‌ها',
            ],
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false, // ما خودمان در منوی شما مدیریتش می‌کنیم
            'query_var'          => true,
            'rewrite' => ['slug' => 'applications', 'with_front' => false], // یا هر اسلاگی که قبلا در زفایر داشتید
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            // مهم: ساپورت‌ها باید شامل custom-fields باشد تا دیتای قبلی لود شود
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields', 'page-attributes'],
        ]);

        // 2. ثبت دسته‌بندی‌های پورتفولیو (us_portfolio_category)
        // اگر این را نگذارید، دسته‌بندی‌های قبلی پورتفولیوها غیب می‌شوند
        register_taxonomy('us_portfolio_category', 'us_portfolio', [
            'hierarchical'      => true,
            'labels'            => [
                'name'              => 'دسته‌بندی‌های ویترین',
                'singular_name'     => 'دسته‌بندی',
                'menu_name'         => 'دسته‌بندی‌ها',
            ],
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'portfolio_category'],
        ]);
   
    }

    public function insert_terms() {
        // اول parent termها رو اضافه کن (اصلی برای هر بخش)
        $parent_terms = [
            'sib_app_game' => [
                'name' => 'دنیای اپلیکیشن و بازی',
                'slug' => 'sib_app_game',
                'taxonomy' => $this->taxonomy_base_slug . '_app_game',
            ],
            'sib_apple_tut' => [
                'name' => 'آموزش‌های جامع اپل',
                'slug' => 'sib_apple_tut',
                'taxonomy' => $this->taxonomy_base_slug . '_apple_tut',
            ],
            'sib_news_anal' => [
                'name' => 'اخبار و تحلیل‌ها',
                'slug' => 'sib_news_anal',
                'taxonomy' => $this->taxonomy_base_slug . '_news_anal',
            ],
        ];

        foreach ($parent_terms as $parent_slug => $parent) {
            if (!term_exists($parent['slug'], $parent['taxonomy'])) {
                wp_insert_term(
                    $parent['name'],
                    $parent['taxonomy'],
                    [
                        'slug' => $parent['slug'],
                        'parent' => 0,  // parent اصلی
                    ]
                );
            }
        }

        // حالا subtermها رو اضافه کن با parent_id درست
        foreach ($this->terms_config as $term) {
            $taxonomy = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $term['parent_slug']);
            if ($term['parent_slug'] === 'sib_news_anal') {
                $taxonomy = $this->taxonomy_base_slug . '_' . $this->news_section['taxonomy_suffix'];
            }

            $parent_term = get_term_by('slug', $term['parent_slug'], $taxonomy);
            $parent_id = $parent_term ? $parent_term->term_id : 0;

            if (!term_exists($term['slug'], $taxonomy)) {
                wp_insert_term(
                    $term['name'],
                    $taxonomy,
                    [
                        'slug' => $term['slug'],
                        'parent' => $parent_id,  // حالا parent_id درست ست می‌شه
                    ]
                );
            }
        }
    }

    public function add_menus() {
        $main = $this->main_menu_config;
        add_menu_page(
            $main['title'],
            $main['menu_title'],
            $main['capability'],
            $main['slug'],
            [$this, 'dynamic_callback'],
            $main['icon'],
            $main['position']
        );

        // Add fixed submenus for top-level sections
        foreach ($this->sections_config as $cpt_slug => $section) {
            add_submenu_page(
                $main['slug'],
                $section['title'],
                $section['menu_title'],
                $main['capability'],
                $section['url_slug'],
                [$this, 'dynamic_callback']
            );
        }

        // Add submenu for news directly to edit.php
        add_submenu_page(
            $main['slug'],
            $this->news_section['title'],
            $this->news_section['menu_title'],
            'edit_posts',
            $this->news_section['admin_slug'],
            ''
        );

        // Add "All Contents" submenu
        add_submenu_page(
            $main['slug'],
            'همه محتواها',
            'همه محتواها',
            $main['capability'],
            'sibaneh_all_contents',
            [$this, 'all_contents_callback']
        );

        // Add "Categories" submenu
        add_submenu_page(
            $main['slug'],
            'دسته‌بندی‌ها',
            'دسته‌بندی‌ها',
            $main['capability'],
            'sibaneh_categories',
            [$this, 'categories_callback']
        );

        // Remove default Posts menu
        remove_menu_page('edit.php');
    }

    public function set_parent_file($parent_file) {
        global $submenu_file, $current_screen;

        if (isset($current_screen)) {
            $post_type = $current_screen->post_type;
            if (isset($this->sections_config[$post_type]) || $post_type === 'post') {
                $parent_file = $this->main_menu_config['slug'];

                if ($post_type === 'post') {
                    $submenu_slug = $this->news_section['admin_slug'];
                    $tax_suffix = $this->news_section['taxonomy_suffix'];
                } else {
                    $section = $this->sections_config[$post_type];
                    $submenu_slug = $section['url_slug'];
                    $tax_suffix = str_replace('sib_', '', $post_type);
                }

                $taxonomy_slug = $this->taxonomy_base_slug . '_' . $tax_suffix;

                if (in_array($current_screen->base, ['post', 'edit'])) {
                    $submenu_file = $submenu_slug;
                } elseif ($current_screen->taxonomy === $taxonomy_slug && in_array($current_screen->base, ['edit-tags', 'term'])) {
                    $submenu_file = 'sibaneh_categories';
                }
            }
            // اگر در حال ویرایش پورتفولیو زفایر هستیم
            if ($post_type === 'us_portfolio') {
                // منوی مادر را روی آکادمی ست کن
                $parent_file = $this->main_menu_config['slug'];
                // زیرمنو را روی "دنیای اپلیکیشن" ست کن
                $submenu_file = 'sibaneh_app_game';
                return $parent_file;
            }
        }

        return $parent_file;
    }

    public function dynamic_callback() {
        $page_slug = isset($_GET['page']) ? sanitize_key($_GET['page']) : $this->main_menu_config['slug'];

        if ($page_slug === $this->main_menu_config['slug']) {
            $title = $this->main_menu_config['title'];
            $sub_items = [];
            foreach ($this->sections_config as $cpt_slug => $section) {
                $sub_items[] = [
                    'title' => $section['title'],
                    'slug' => $section['url_slug'],
                ];
            }
            // Add news to main overview
            $sub_items[] = [
                'title' => $this->news_section['title'],
                'slug' => $this->news_section['admin_slug'],
            ];
        } else {
            $cpt_slug = $this->url_to_cpt_map[$page_slug] ?? null;
            if (!$cpt_slug) {
                echo '<div class="wrap"><h1>خطا: صفحه یافت نشد</h1></div>';
                return;
            }
            if ($cpt_slug === 'post') {
                $title = $this->news_section['title'];
                $taxonomy_slug = $this->taxonomy_base_slug . '_' . $this->news_section['taxonomy_suffix'];
                $post_type_query = '';
            } else {
                $title = $this->sections_config[$cpt_slug]['title'];
                $taxonomy_slug = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $cpt_slug);
                $post_type_query = "post_type={$cpt_slug}&";
            }
            $child_terms = get_terms([
                'taxonomy' => $taxonomy_slug,
                'parent' => 0,
                'hide_empty' => false,
            ]);
            $sub_items = [];
            // تغییر جدید: اضافه کردن دستی لینک ویترین اپلیکیشن‌ها (پورتفولیو)
            if ($cpt_slug === 'sib_app_game') {
                $sub_items[] = [
                    'title' => 'ویترین اپلیکیشن‌ها',
                    'slug' => 'edit.php?post_type=us_portfolio', // لینک به لیست پورتفولیوها
                    'is_portfolio' => true // یک نشانه برای تشخیص در حلقه نمایش
                ];
            }
            foreach ($child_terms as $child) {
                $sub_items[] = [
                    'title' => $child->name,
                    'category' => $child->slug,
                ];
            }
        }

        ?>
        <div class="wrap">
            <h1><?php echo esc_html($title); ?></h1>
            <p>لطفاً بخش مورد نظر را انتخاب کنید:</p>
            <ul>
                <?php foreach ($sub_items as $sub_item): ?>
                    <li>
                        <a href="<?php
                            if (isset($sub_item['slug'])) {
                                if (strpos($sub_item['slug'], 'edit.php') !== false) {
    echo esc_url(admin_url($sub_item['slug']));
} else {
    // در غیر این صورت فرمت صفحه پلاگین را بساز
    echo esc_url(admin_url('admin.php?page=' . $sub_item['slug']));
}
                            } elseif (isset($sub_item['category'])) {
                                echo esc_url(admin_url("edit.php?{$post_type_query}{$taxonomy_slug}={$sub_item['category']}"));
                            }
                        ?>">
                            <?php echo esc_html($sub_item['title']); ?>
                        </a>
                        <?php if (isset($sub_item['is_portfolio'])): ?>
    <span> - <a href="<?php echo esc_url(admin_url("post-new.php?post_type=us_portfolio")); ?>">افزودن اپلیکیشن جدید</a></span>
<?php elseif (isset($sub_item['category'])): ?>
    <span> - <a href="<?php echo esc_url(admin_url("post-new.php?{$post_type_query}preselect_category={$sub_item['category']}")); ?>">افزودن محتوای جدید در این دسته</a></span>
<?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }

    public function all_contents_callback() {
        ?>
        <div class="wrap">
            <h1>همه محتواها</h1>
            <p>برای مشاهده محتواهای هر بخش، لطفاً به بخش مربوطه مراجعه کنید:</p>
            <ul>
                <?php foreach ($this->sections_config as $cpt_slug => $section): ?>
                    <li><a href="<?php echo esc_url(admin_url("edit.php?post_type={$cpt_slug}")); ?>"><?php echo esc_html($section['title']); ?></a></li>
                <?php endforeach; ?>
                <li><a href="<?php echo esc_url(admin_url('edit.php')); ?>"><?php echo esc_html($this->news_section['title']); ?></a></li>
            </ul>
        </div>
        <?php
    }

    public function categories_callback() {
        ?>
        <div class="wrap">
            <h1>دسته‌بندی‌ها</h1>
            <p>برای مدیریت دسته‌بندی‌های هر بخش، لطفاً بخش مورد نظر را انتخاب کنید:</p>
            <ul>
                <?php foreach ($this->sections_config as $cpt_slug => $section): ?>
                    <?php $taxonomy_slug = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $cpt_slug); ?>
                    <li><a href="<?php echo esc_url(admin_url("edit-tags.php?taxonomy={$taxonomy_slug}&post_type={$cpt_slug}")); ?>"><?php echo esc_html($section['title']); ?></a></li>
                <?php endforeach; ?>
                <?php $taxonomy_slug = $this->taxonomy_base_slug . '_' . $this->news_section['taxonomy_suffix']; ?>
                <li><a href="<?php echo esc_url(admin_url("edit-tags.php?taxonomy={$taxonomy_slug}&post_type=post")); ?>"><?php echo esc_html($this->news_section['title']); ?></a></li>
            </ul>
        </div>
        <?php
    }

    public function enqueue_preselect_script($hook) {
        if ($hook !== 'post-new.php' && $hook !== 'post.php') {
            return;
        }

        $post_type = get_post_type() ?? ($_GET['post_type'] ?? '');
        if (!isset($this->sections_config[$post_type]) && $post_type !== 'post') {
            return;
        }

        if (!isset($_GET['preselect_category'])) {
            return;
        }

        wp_enqueue_script('jquery');

        if ($post_type === 'post') {
            $taxonomy_slug = $this->taxonomy_base_slug . '_' . $this->news_section['taxonomy_suffix'];
        } else {
            $taxonomy_slug = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $post_type);
        }

        $preselect_slug = sanitize_key($_GET['preselect_category']);
        $term = get_term_by('slug', $preselect_slug, $taxonomy_slug);
        if (!$term) return;

        $ancestors = get_ancestors($term->term_id, $taxonomy_slug, 'taxonomy');
        $to_check = array_merge([$term->term_id], $ancestors);

        $script = "
        jQuery(document).ready(function($) {
            " . implode("\n", array_map(function($id) use ($taxonomy_slug) { return "\$('#in-{$taxonomy_slug}-{$id}').prop('checked', true);"; }, $to_check)) . "
            function setGutenbergTerms(attempts = 0) {
                if (typeof wp !== 'undefined' && wp.data && wp.data.select('core/editor')) {
                    const { dispatch, select } = wp.data;
                    const currentTerms = select('core/editor').getEditedPostAttribute('{$taxonomy_slug}') || [];
                    const newTerms = [...new Set([...currentTerms, " . implode(', ', $to_check) . "])];
                    dispatch('core/editor').editPost({ '{$taxonomy_slug}': newTerms });
                } else if (attempts < 50) {
                    setTimeout(() => setGutenbergTerms(attempts + 1), 200);
                }
            }
            setGutenbergTerms();
        });
        ";

        wp_add_inline_script('jquery', $script);
    }

    public function set_default_category_on_save($post_id, $post, $update) {
        if (wp_is_post_revision($post_id)) {
            return;
        }

        if (!isset($this->sections_config[$post->post_type]) && $post->post_type !== 'post') {
            return;
        }

        if (isset($_GET['preselect_category']) || isset($_POST['preselect_category'])) {
            if ($post->post_type === 'post') {
                $taxonomy_slug = $this->taxonomy_base_slug . '_' . $this->news_section['taxonomy_suffix'];
            } else {
                $taxonomy_slug = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $post->post_type);
            }
            $preselect_slug = sanitize_key($_GET['preselect_category'] ?? $_POST['preselect_category']);
            $term = get_term_by('slug', $preselect_slug, $taxonomy_slug);
            if ($term) {
                $current_terms = wp_get_object_terms($post_id, $taxonomy_slug, ['fields' => 'ids']);
                if (empty($current_terms)) {
                    $ancestors = get_ancestors($term->term_id, $taxonomy_slug, 'taxonomy');
                    $terms_to_set = array_merge([$term->term_id], $ancestors);
                    wp_set_object_terms($post_id, $terms_to_set, $taxonomy_slug);
                }
            }
        }
    }

    public function add_custom_styles() {
        ?>
        <style>
            .old-post {
                background-color: #ffcccc !important;
            }
        </style>
        <?php
    }

    public function highlight_old_posts($classes, $class, $post_id) {
        $post = get_post($post_id);
        if (!isset($this->sections_config[$post->post_type]) && $post->post_type !== 'post') return $classes;
        $post_date = strtotime($post->post_date);
        $three_months_ago = strtotime('-3 months');

        if ($post_date < $three_months_ago) {
            $classes[] = 'old-post';
        }

        return $classes;
    }

    public function allow_page_parents($dropdown_args, $post) {
        if (isset($this->sections_config[$post->post_type]) || $post->post_type === 'post') {
            $dropdown_args['post_type'] = 'page';
        }
        return $dropdown_args;
    }

    public function load_cpt_template($single_template) {
        global $post;

        // -----------------------------------------------------------
        // 1. تنظیم قالب اختصاصی برای ویترین اپلیکیشن‌ها (us_portfolio)
        // -----------------------------------------------------------
        if ($post->post_type === 'us_portfolio') {
            // آدرس فایل در پوشه قالب فعال شما
            $file = get_stylesheet_directory() . '/AppShowcase.php';
            
            // اگر فایل وجود داشت، آن را لود کن
            if (file_exists($file)) {
                return $file;
            }
        }

        // -----------------------------------------------------------
        // 2. تنظیمات قبلی برای سایر بخش‌های آکادمی
        // -----------------------------------------------------------
        if (isset($this->sections_config[$post->post_type]) || $post->post_type === 'post') {
            $template = get_post_meta($post->ID, '_wp_page_template', true);
            if ($template && 'default' !== $template) {
                $file = get_stylesheet_directory() . '/' . $template;
                if (file_exists($file)) {
                    return $file;
                }
                $file = get_template_directory() . '/' . $template;
                if (file_exists($file)) {
                    return $file;
                }
            }
        }

        return $single_template;
    }
}

new SibanehAcademy();
