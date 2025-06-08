<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>
<main class="main-content single-post-main">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php
                // Get the split content
                $split_content = split_post_content();
                ?>

                <!-- Breadcrumb -->
                <nav class="breadcrumb">
                    <?php if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<div class="breadcrumb-wrapper">', '</div>');
                    } ?>
                </nav>

                <article class="single-post-article">
                    <!-- Post Meta Info -->
                    <div class="post-header">
                        <div class="post-meta">
                            <div class="meta-item">
                                <span>بروزرسانی</span>
                            </div>
                            <div class="meta-item">
                                <span><?php echo get_the_date('j F Y'); ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="icon-eye"></i>
                                <span><?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?> بازدید</span>
                            </div>
                        </div>

                        <!-- Component Content (first paragraph) -->
                        <?php if (!empty($split_content['component'])) : ?>
                            <div class="component-content">
                                <?php echo $split_content['component']; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Author Info -->
                        <div class="post-author">
                            <div class="author-avatar">
                                <?php echo get_avatar(get_the_author_meta('ID'), 60); ?>
                            </div>
                            <div class="author-details">
                                <span class="author-name">نویسنده: <?php the_author(); ?></span>
                                <?php if (get_the_author_meta('description')) : ?>
                                    <p class="author-bio"><?php echo get_the_author_meta('description'); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Social Share -->
                        <div class="social-share">
                            <div class="social-buttons">
                                <button class="social-btn copy-link" onclick="copyToClipboard('<?php echo get_permalink(); ?>')" title="کپی لینک">
                                    <i class="icon-link"></i>
                                </button>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                                    target="_blank" class="social-btn instagram" title="اشتراک در اینستاگرام">
                                    <i class="icon-instagram-logo"></i>
                                </a>
                                <a href="https://telegram.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                    target="_blank" class="social-btn telegram" title="اشتراک در تلگرام">
                                    <i class="icon-tg"></i>
                                </a>

                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                    target="_blank" class="social-btn twitter" title="اشتراک در توییتر">
                                    <i class="icon-twitter"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Post Actions -->
                        <div class="post-actions">
                            <div class="metadata">
                                <div class="metadata-item">
                                    <div class="metadata-value"><?php echo calculate_reading_time(get_the_content()); ?> دقیقه</div>
                                    <div class="metadata-label">مدت زمان مطالعه</div>
                                </div>
                                <div class="metadata-separator"></div>
                                <div class="metadata-item">
                                    <button class="download-button">
                                        <div class="metadata-value"><i class="icon-play-in-circle"></i></div>
                                        <div class="metadata-label">دانلود برنامه <?php the_title(); ?></div>
                                    </button>
                                </div>
                                <div class="metadata-separator"></div>
                                <div class="metadata-item">
                                    <a href="<?php echo get_post_meta(get_the_ID(), 'video_review_url', true); ?>" class="video-link">
                                        <div class="metadata-value"><i class="icon-video-player"></i></div>
                                        <div class="metadata-label">ویدیو بررسی</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Post Content (Rest of Content) -->
                    <?php if (!empty($split_content['pagebody'])) : ?>
                        <div class="post-content">
                            <div class="pagebody">
                                <?php echo $split_content['pagebody']; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Post Navigation -->
                    <div class="post-navigation">
                        <div class="nav-previous">
                            <?php
                            $prev_post = get_previous_post();
                            if ($prev_post) : ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link">
                                    <span class="nav-direction">مطلب قبلی</span>
                                    <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="nav-next">
                            <?php
                            $next_post = get_next_post();
                            if ($next_post) : ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link">
                                    <span class="nav-direction">مطلب بعدی</span>
                                    <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </article>

                <!-- Related Posts -->
                <section class="related-posts">
                    <h3>مطالب مرتبط</h3>
                    <div class="related-posts-grid">
                        <?php
                        $related = get_posts(array(
                            'category__in' => wp_get_post_categories($post->ID),
                            'numberposts' => 3,
                            'post__not_in' => array($post->ID)
                        ));

                        if ($related) foreach ($related as $post) {
                            setup_postdata($post); ?>
                            <article class="related-post-item">
                                <a href="<?php the_permalink(); ?>" class="related-post-link">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="related-post-thumb">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="related-post-content">
                                        <h4 class="related-post-title"><?php the_title(); ?></h4>
                                        <span class="related-post-date"><?php echo get_the_date(); ?></span>
                                    </div>
                                </a>
                            </article>
                        <?php }
                        wp_reset_postdata(); ?>
                    </div>
                </section>

                <!-- Comments Section -->
                <section class="comments-section">
                    <?php
                    if (comments_open() || get_comments_number()) {
                        comments_template();
                    }
                    ?>
                </section>

        <?php endwhile;
        endif; ?>
    </div>
</main>
<?php get_footer(); ?>