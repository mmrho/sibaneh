<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header('single');
if (have_posts()) : ?>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $category = get_queried_object();
            $slug = $category->slug;
            $template_path = get_template_directory() . '/category-parts/';
            $template_uri = get_template_directory_uri() . '/category-parts/';

            $custom_template = $template_path . $slug . '.php';

            // Check if custom template for this category exists
            if (file_exists($custom_template)) {
                include $custom_template;
            }
            // If not, check if it has a parent category
            elseif ($category->parent) {
                $parent = get_category($category->parent);
                $parent_template = $template_path . $parent->slug . '.php';

                if (file_exists($parent_template)) {
                    include $parent_template;
                } else {
                    include $template_path . 'default.php';
                }
            }
            // If no custom template and no parent category, use default
            else {
                include $template_path . 'default.php';
            }
            ?>


            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                (<?php echo get_post_type(); ?>)
            </li>
        <?php endwhile; ?>
    </ul>
<?php else : ?>
    <p>No content found in this category.</p>
<?php endif; ?>