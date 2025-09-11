<?php
/**
 * Plugin Name: Sibaneh Academy
 * Description: Custom post type and menus for Sibaneh Academy.
 * Version: 1.12
 */

namespace Sibaneh\Academy;

class SibanehAcademy {
    private $cpt_slug = 'sibaneh_content';
    private $taxonomy_slug = 'sibaneh_category';

    // Config for fixed main sections (top-level parents)
    private $sections_config = [
        'sibaneh_app_game' => [
            'title' => 'دنیای اپلیکیشن و بازی',
            'menu_title' => 'دنیای اپلیکیشن و بازی',
        ],
        'sibaneh_apple_tutorials' => [
            'title' => 'آموزش‌های جامع اپل',
            'menu_title' => 'آموزش‌های جامع اپل',
        ],
        'sibaneh_news_analysis' => [
            'title' => 'اخبار و تحلیل‌ها',
            'menu_title' => 'اخبار و تحلیل‌ها',
        ],
    ];

    // Config for terms (categories) - add new ones here
    // 'parent_slug' can be a section slug or another term's slug for deeper hierarchy
    private $terms_config = [
        [
            'name' => 'بررسی و معرفی اپلیکیشن‌ها',
            'slug' => 'review-and-introduction-of-applications',
            'parent_slug' => 'sibaneh_app_game',
        ],
        [
            'name' => 'ترفندها و راحل‌ها',
            'slug' => 'tricks-and-treats',
            'parent_slug' => 'sibaneh_apple_tutorials',
        ],
        [
            'name' => 'اخبار و تحلیل‌ها', // Consider changing name to avoid confusion with parent
            'slug' => 'news-analysis',
            'parent_slug' => 'sibaneh_news_analysis',
        ],
        // Example for level 3: uncomment to add
        // [
        //     'name' => 'زیرمجموعه جدید',
        //     'slug' => 'new-sub',
        //     'parent_slug' => 'review-and-introduction-of-applications',
        // ],
    ];

    // Main menu config - capability 'manage_options' for admins
    private $main_menu_config = [
        'title' => 'آکادمی سیبانه',
        'menu_title' => 'آکادمی سیبانه',
        'capability' => 'manage_options',
        'slug' => 'sibaneh_content_overview',
        'icon' => 'dashicons-media-document',
        'position' => 2,
    ];

    public function __construct() {
        add_action('init', [$this, 'register_cpt']);
        add_action('init', [$this, 'register_taxonomy']);
        add_action('init', [$this, 'insert_terms']);
        add_action('admin_menu', [$this, 'add_menus']);
        add_action('admin_head', [$this, 'add_custom_styles']);
        add_filter('post_class', [$this, 'highlight_old_posts'], 10, 3);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_preselect_script']);
        add_filter('post_type_link', [$this, 'custom_post_permalink'], 10, 2);
        add_action('init', [$this, 'add_rewrite_rules']);
        add_action('save_post', [$this, 'set_default_category_on_save'], 10, 3);

        // Temporary: Force reset transient for testing - remove after one run
        // delete_transient('sibaneh_terms_inserted');
    }

    public function register_cpt() {
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
            'rewrite'            => ['slug' => $this->cpt_slug . '/%sibaneh_category%', 'with_front' => false], // Added cpt_slug before hierarchy
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 2,
            'menu_icon'          => 'dashicons-media-document',
            'supports'           => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields', 'page-attributes'],
            'show_in_rest'       => true,
        ];

        register_post_type($this->cpt_slug, $args);
    }

    public function register_taxonomy() {
        $labels = [
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

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'sibaneh-category', 'hierarchical' => true],
            'show_in_rest'      => true,
        ];

        register_taxonomy($this->taxonomy_slug, [$this->cpt_slug], $args);
    }

    public function insert_terms() {
        // Always check and fix hierarchy
        // if (get_transient('sibaneh_terms_inserted')) return;

        // Insert or update top-level parents
        foreach ($this->sections_config as $slug => $section) {
            $existing = term_exists($slug, $this->taxonomy_slug);
            if (!$existing) {
                wp_insert_term($section['title'], $this->taxonomy_slug, ['slug' => $slug]);
            } else {
                // Fetch full term to check parent
                $term = get_term($existing['term_id'], $this->taxonomy_slug);
                if ($term->parent != 0) {
                    wp_update_term($existing['term_id'], $this->taxonomy_slug, ['parent' => 0]);
                }
            }
        }

        // Insert or update child terms with hierarchy fix
        $max_iterations = 5;
        $pending_terms = $this->terms_config;

        for ($i = 0; $i < $max_iterations; $i++) {
            $new_pending = [];
            foreach ($pending_terms as $term) {
                $existing = term_exists($term['slug'], $this->taxonomy_slug);
                $parent = isset($term['parent_slug']) ? term_exists($term['parent_slug'], $this->taxonomy_slug) : false;

                if ($parent && $parent['term_id']) {
                    $args = [
                        'slug' => $term['slug'],
                        'parent' => $parent['term_id'],
                    ];
                    if ($existing) {
                        wp_update_term($existing['term_id'], $this->taxonomy_slug, $args);
                    } else {
                        wp_insert_term($term['name'], $this->taxonomy_slug, $args);
                    }
                } else {
                    $new_pending[] = $term;
                }
            }
            $pending_terms = $new_pending;
            if (empty($pending_terms)) break;
        }

        if (empty($pending_terms)) {
            set_transient('sibaneh_terms_inserted', true, YEAR_IN_SECONDS);
        } else {
            error_log('SibanehAcademy: Some terms could not be inserted/updated due to missing parents.');
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
        foreach ($this->sections_config as $section_slug => $section) {
            add_submenu_page(
                $main['slug'],
                $section['title'],
                $section['menu_title'],
                $main['capability'],
                $section_slug,
                [$this, 'dynamic_callback']
            );
        }

        // Add "All Contents" submenu
        add_submenu_page(
            $main['slug'],
            'همه محتواها',
            'همه محتواها',
            $main['capability'],
            "edit.php?post_type={$this->cpt_slug}",
            ''
        );

        // Add "Categories" submenu below "All Contents"
        add_submenu_page(
            $main['slug'],
            'دسته‌بندی‌ها',
            'دسته‌بندی‌ها',
            $main['capability'],
            "edit-tags.php?taxonomy={$this->taxonomy_slug}&post_type={$this->cpt_slug}",
            ''
        );
    }

    /**
     * Dynamic callback for all pages
     */
    public function dynamic_callback() {
        // Get current page slug
        $page_slug = isset($_GET['page']) ? sanitize_key($_GET['page']) : $this->main_menu_config['slug'];

        // Determine if it's the overview or a section
        if ($page_slug === $this->main_menu_config['slug']) {
            // Overview: list only top-level (parent=0) terms from config
            $title = $this->main_menu_config['title'];
            $top_terms = get_terms([
                'taxonomy' => $this->taxonomy_slug,
                'parent' => 0,
                'hide_empty' => false,
                'slug' => array_keys($this->sections_config), // Only configured sections
            ]);
            $sub_items = [];
            foreach ($top_terms as $term) {
                $sub_items[] = [
                    'title' => $term->name,
                    'slug' => $term->slug,
                ];
            }
        } else {
            // Section page: list child terms under this parent
            $parent_term = get_term_by('slug', $page_slug, $this->taxonomy_slug);
            if (!$parent_term) {
                echo '<div class="wrap"><h1>خطا: صفحه یافت نشد</h1></div>';
                return;
            }
            $title = $parent_term->name;
            $child_terms = get_terms([
                'taxonomy' => $this->taxonomy_slug,
                'parent' => $parent_term->term_id,
                'hide_empty' => false,
            ]);
            $sub_items = [];
            foreach ($child_terms as $child) {
                $sub_items[] = [
                    'title' => $child->name,
                    'category' => $child->slug,
                ];
            }
        }

        // Build the HTML dynamically
        ?>
        <div class="wrap">
            <h1><?php echo esc_html($title); ?></h1>
            <p>لطفاً بخش مورد نظر را انتخاب کنید:</p>
            <ul>
                <?php foreach ($sub_items as $sub_item): ?>
                    <li>
                        <a href="<?php
                            if (isset($sub_item['slug'])) {
                                // For parents: link to section page
                                echo esc_url(admin_url('admin.php?page=' . $sub_item['slug']));
                            } elseif (isset($sub_item['category'])) {
                                // For children: link to posts list
                                echo esc_url(admin_url("edit.php?post_type={$this->cpt_slug}&{$this->taxonomy_slug}={$sub_item['category']}"));
                            }
                        ?>">
                            <?php echo esc_html($sub_item['title']); ?>
                        </a>
                        <?php if (isset($sub_item['category'])): // Add 'Add New' link for child categories ?>
                            <span> - <a href="<?php echo esc_url(admin_url("post-new.php?post_type={$this->cpt_slug}&preselect_category={$sub_item['category']}")); ?>">افزودن محتوای جدید در این دسته</a></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }

    /**
     * Enqueue script for preselecting taxonomy
     */
    public function enqueue_preselect_script($hook) {
        if ($hook !== 'post-new.php' && $hook !== 'post.php') {
            return;
        }

        if (get_post_type() !== $this->cpt_slug || !isset($_GET['preselect_category'])) {
            return;
        }

        wp_enqueue_script('jquery');

        $preselect_slug = sanitize_key($_GET['preselect_category']);
        $term = get_term_by('slug', $preselect_slug, $this->taxonomy_slug);
        if (!$term) return;

        // Get all ancestors
        $ancestors = get_ancestors($term->term_id, $this->taxonomy_slug, 'taxonomy');
        $to_check = array_merge([$term->term_id], $ancestors);

        // Inline script
        $script = "
        jQuery(document).ready(function($) {
            // For Classic Editor
            " . implode("\n", array_map(function($id) { return "\$('#in-{$this->taxonomy_slug}-{$id}').prop('checked', true);"; }, $to_check)) . "

            // For Gutenberg
            function setGutenbergTerms(attempts = 0) {
                if (typeof wp !== 'undefined' && wp.data && wp.data.select('core/editor')) {
                    const { dispatch, select } = wp.data;
                    const currentTerms = select('core/editor').getEditedPostAttribute('{$this->taxonomy_slug}') || [];
                    const newTerms = [...new Set([...currentTerms, " . implode(', ', $to_check) . "])];
                    dispatch('core/editor').editPost({ '{$this->taxonomy_slug}': newTerms });
                } else if (attempts < 50) {
                    setTimeout(() => setGutenbergTerms(attempts + 1), 200);
                }
            }
            setGutenbergTerms();
        });
        ";

        wp_add_inline_script('jquery', $script);
    }

    /**
     * Set default category on save if preselect is set and no category assigned
     */
    public function set_default_category_on_save($post_id, $post, $update) {
        if ($post->post_type !== $this->cpt_slug || wp_is_post_revision($post_id)) {
            return;
        }

        if (isset($_GET['preselect_category']) || isset($_POST['preselect_category'])) {
            $preselect_slug = sanitize_key($_GET['preselect_category'] ?? $_POST['preselect_category']);
            $term = get_term_by('slug', $preselect_slug, $this->taxonomy_slug);
            if ($term) {
                $current_terms = wp_get_object_terms($post_id, $this->taxonomy_slug, ['fields' => 'ids']);
                if (empty($current_terms)) {
                    $ancestors = get_ancestors($term->term_id, $this->taxonomy_slug, 'taxonomy');
                    $terms_to_set = array_merge([$term->term_id], $ancestors);
                    wp_set_object_terms($post_id, $terms_to_set, $this->taxonomy_slug);
                }
            }
        }
    }

    /**
     * Custom permalink structure with taxonomy hierarchy
     */
    public function custom_post_permalink($post_link, $post) {
        if ($post->post_type === $this->cpt_slug) {
            $terms = wp_get_object_terms($post->ID, $this->taxonomy_slug);
            if (!is_wp_error($terms) && !empty($terms)) {
                $term = array_shift($terms); // Get primary term
                $term_slugs = [];
                $current_term = $term;
                while ($current_term) {
                    $term_slugs[] = $current_term->slug;
                    if ($current_term->parent) {
                        $current_term = get_term($current_term->parent, $this->taxonomy_slug);
                    } else {
                        break;
                    }
                }
                $term_slugs = array_reverse($term_slugs);
                $taxonomy_slug = implode('/', $term_slugs);
                $post_link = str_replace('%sibaneh_category%', $taxonomy_slug, $post_link);
            } else {
                $post_link = str_replace('%sibaneh_category%', 'uncategorized', $post_link);
            }
        }
        return $post_link;
    }

    /**
     * Add rewrite rules for hierarchical permalinks
     */
    public function add_rewrite_rules() {
        add_rewrite_tag('%sibaneh_category%', '([^/]+(?:/[^/]+)*)');
        // Flush rewrite rules if needed (do this once manually via Settings > Permalinks)
    }

    /**
     * Add custom styles to admin for highlighting old posts
     */
    public function add_custom_styles() {
        ?>
        <style>
            .old-post {
                background-color: #ffcccc !important;
            }
        </style>
        <?php
    }

    /**
     * Highlight posts older than 3 months
     */
    public function highlight_old_posts($classes, $class, $post_id) {
        $post = get_post($post_id);
        $post_date = strtotime($post->post_date);
        $three_months_ago = strtotime('-3 months');

        if ($post_date < $three_months_ago) {
            $classes[] = 'old-post';
        }

        return $classes;
    }
}

new SibanehAcademy();