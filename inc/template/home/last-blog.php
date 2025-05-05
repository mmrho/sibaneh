<div class="container-lg">
    <div class="row justify-content-center last-blog-post">
        <div class="col-12">
            <header class="panel-title">
                <h2>جدیدترین مطالب وبلاگ</h2>
            </header>
        </div>
    </div>

    <div class="row">
        <?php
        $args = [
            'post_type' => 'post',
            'posts_per_page' => 4
        ];
        $query = new WP_Query($args);
        if ($query->have_posts()): while ($query->have_posts()): $query->the_post();
            require THEME_TEMPLATE . "cards/blog.php";
        endwhile; endif;
        wp_reset_postdata(); ?>

        <div class="all-blog">
            <a class="hew-button" href="#"><span>همه مقالات </span><i class="icon-left-small"></i></a>
        </div>
    </div>
</div>