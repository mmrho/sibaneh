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
        'sib_news_anal' => [
            'title' => 'اخبار و تحلیل‌ها',
            'menu_title' => 'اخبار و تحلیل‌ها',
            'url_slug' => 'sibaneh_news_analysis',
        ],
    ];

    // Config for terms (subcategories) - 'parent_slug' updated to short CPT slugs
    private $terms_config = [
        [
            'name' => 'ویترین اپلیکیشن‌ها',
            'slug' => 'showcase-of-apps',
            'parent_slug' => 'sib_app_game',
        ],
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
        add_action('init', [$this, 'insert_terms']);
        add_action('admin_menu', [$this, 'add_menus']);
        add_action('admin_head', [$this, 'add_custom_styles']);
        add_filter('post_class', [$this, 'highlight_old_posts'], 10, 3);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_preselect_script']);
        add_action('save_post', [$this, 'set_default_category_on_save'], 10, 3);
        add_filter('page_attributes_dropdown_pages_args', [$this, 'allow_page_parents'], 10, 2);
        add_filter('single_template', [$this, 'load_cpt_template']);
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
    }

    public function insert_terms() {
        // Always check and fix hierarchy
        // if (get_transient('sibaneh_terms_inserted')) return;

        foreach ($this->sections_config as $cpt_slug => $section) {
            $taxonomy_slug = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $cpt_slug);
            $filtered_terms = array_filter($this->terms_config, function($t) use ($cpt_slug) {
                return $t['parent_slug'] === $cpt_slug;
            });

            $max_iterations = 5;
            $pending_terms = $filtered_terms;

            for ($i = 0; $i < $max_iterations; $i++) {
                $new_pending = [];
                foreach ($pending_terms as $term) {
                    $existing = term_exists($term['slug'], $taxonomy_slug);
                    $parent = 0;  // All terms are top-level under CPT, or handle deeper if needed

                    if (isset($term['parent_slug']) && $term['parent_slug'] !== $cpt_slug) {
                        $parent_term = term_exists($term['parent_slug'], $taxonomy_slug);
                        if ($parent_term) {
                            $parent = $parent_term['term_id'];
                        } else {
                            $new_pending[] = $term;
                            continue;
                        }
                    }

                    $args = [
                        'slug' => $term['slug'],
                        'parent' => $parent,
                    ];
                    if ($existing) {
                        wp_update_term($existing['term_id'], $taxonomy_slug, $args);
                    } else {
                        wp_insert_term($term['name'], $taxonomy_slug, $args);
                    }
                }
                $pending_terms = $new_pending;
                if (empty($pending_terms)) break;
            }

            if (!empty($pending_terms)) {
                error_log('SibanehAcademy: Some terms could not be inserted/updated due to missing parents in ' . $taxonomy_slug . '.');
            }
        }

        if (empty($pending_terms)) {
            set_transient('sibaneh_terms_inserted', true, YEAR_IN_SECONDS);
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
        } else {
            $cpt_slug = $this->url_to_cpt_map[$page_slug] ?? null;
            if (!$cpt_slug) {
                echo '<div class="wrap"><h1>خطا: صفحه یافت نشد</h1></div>';
                return;
            }
            $title = $this->sections_config[$cpt_slug]['title'];
            $taxonomy_slug = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $cpt_slug);
            $child_terms = get_terms([
                'taxonomy' => $taxonomy_slug,
                'parent' => 0,
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

        ?>
        <div class="wrap">
            <h1><?php echo esc_html($title); ?></h1>
            <p>لطفاً بخش مورد نظر را انتخاب کنید:</p>
            <ul>
                <?php foreach ($sub_items as $sub_item): ?>
                    <li>
                        <a href="<?php
                            if (isset($sub_item['slug'])) {
                                echo esc_url(admin_url('admin.php?page=' . $sub_item['slug']));
                            } elseif (isset($sub_item['category'])) {
                                echo esc_url(admin_url("edit.php?post_type={$cpt_slug}&{$taxonomy_slug}={$sub_item['category']}"));
                            }
                        ?>">
                            <?php echo esc_html($sub_item['title']); ?>
                        </a>
                        <?php if (isset($sub_item['category'])): ?>
                            <span> - <a href="<?php echo esc_url(admin_url("post-new.php?post_type={$cpt_slug}&preselect_category={$sub_item['category']}")); ?>">افزودن محتوای جدید در این دسته</a></span>
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
            </ul>
        </div>
        <?php
    }

    public function enqueue_preselect_script($hook) {
        if ($hook !== 'post-new.php' && $hook !== 'post.php') {
            return;
        }

        $post_type = get_post_type() ?? ($_GET['post_type'] ?? '');
        if (!isset($this->sections_config[$post_type]) || !isset($_GET['preselect_category'])) {
            return;
        }

        wp_enqueue_script('jquery');

        $taxonomy_slug = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $post_type);
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
        if (!isset($this->sections_config[$post->post_type]) || wp_is_post_revision($post_id)) {
            return;
        }

        if (isset($_GET['preselect_category']) || isset($_POST['preselect_category'])) {
            $taxonomy_slug = $this->taxonomy_base_slug . '_' . str_replace('sib_', '', $post->post_type);
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
        if (!isset($this->sections_config[$post->post_type])) return $classes;
        $post_date = strtotime($post->post_date);
        $three_months_ago = strtotime('-3 months');

        if ($post_date < $three_months_ago) {
            $classes[] = 'old-post';
        }

        return $classes;
    }

    public function allow_page_parents($dropdown_args, $post) {
        if (isset($this->sections_config[$post->post_type])) {
            $dropdown_args['post_type'] = 'page';
        }
        return $dropdown_args;
    }

    public function load_cpt_template($single_template) {
        global $post;
        if (isset($this->sections_config[$post->post_type])) {
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