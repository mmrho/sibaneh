<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>

<main class="post-container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <?php if (function_exists('yoast_breadcrumb')) {
                    yoast_breadcrumb('<div class="breadcrumb-wrapper">', '</div>');
                } ?>
            </nav>

            <!-- Post Header -->
            <header class="post-header">
                <div class="post-categories-header">
                    <?php if (has_category()) : ?>
                        <?php the_category(' '); ?>
                    <?php endif; ?>
                </div>

                <h1 class="post-title"><?php the_title(); ?></h1>

                <div class="post-excerpt">
                    <?php if (has_excerpt()) : ?>
                        <?php the_excerpt(); ?>
                    <?php endif; ?>
                </div>

                <!-- Post Meta Info -->
                <div class="post-meta-header">
                    <div class="post-author-info">
                        <?php echo get_avatar(get_the_author_meta('ID'), 48, '', get_the_author(), ['class' => 'author-avatar']); ?>
                        <div class="author-details">
                            <span class="author-name"><?php the_author(); ?></span>
                            <div class="post-date-info">
                                <time datetime="<?php echo get_the_date('c'); ?>" class="publish-date">
                                    <?php echo get_safe_persian_date('j F Y', get_the_time('U')); ?>
                                </time>
                                <?php if (get_the_modified_time('U') !== get_the_time('U')) : ?>
                                    <span class="separator">•</span>
                                    <time datetime="<?php echo get_the_modified_date('c'); ?>" class="update-date">
                                        بروزرسانی: <?php echo get_safe_persian_date('j F Y', get_the_modified_time('U')); ?>
                                    </time>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="post-stats">
                        <div class="reading-time">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                            </svg>
                            <span><?php echo calculate_reading_time(get_the_content()); ?> دقیقه مطالعه</span>
                        </div>

                        <div class="view-count">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                            </svg>
                            <span><?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?> بازدید</span>
                        </div>
                    </div>
                </div>

                <!-- Social Share -->
                <div class="social-share-header">
                    <span class="share-label">اشتراک‌گذاری:</span>
                    <div class="social-buttons">
                        <a href="https://telegram.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            target="_blank" class="social-btn telegram" title="اشتراک در تلگرام">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z" />
                            </svg>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            target="_blank" class="social-btn twitter" title="اشتراک در توییتر">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                            </svg>
                        </a>

                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                            target="_blank" class="social-btn linkedin" title="اشتراک در لینکدین">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" />
                                <circle cx="4" cy="4" r="2" />
                            </svg>
                        </a>

                        <button class="social-btn copy-link" onclick="copyToClipboard('<?php echo get_permalink(); ?>')" title="کپی لینک">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71" />
                                <path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71" />
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-featured-image">
                    <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
                </div>
            <?php endif; ?>

            <!-- Post Content -->
            <article class="post-content">
                <div class="content-wrapper">
                    <?php the_content(); ?>
                </div>

                <!-- Post Tags -->
                <?php if (has_tag()) : ?>
                    <div class="post-tags">
                        <span class="tags-label">برچسب‌ها:</span>
                        <div class="tags-list">
                            <?php the_tags('', ''); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </article>

            <!-- Post Actions -->
            <div class="post-actions">
                <?php
                $video_link = get_post_meta(get_the_ID(), 'video_review_link', true);
                $download_link = get_post_meta(get_the_ID(), 'download_link', true);
                ?>

                <?php if ($video_link) : ?>
                    <a href="<?php echo esc_url($video_link); ?>" class="action-btn video-btn" target="_blank" rel="noopener">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                        <span>ویدیو بررسی</span>
                    </a>
                <?php endif; ?>

                <?php if ($download_link) : ?>
                    <a href="<?php echo esc_url($download_link); ?>" class="action-btn download-btn" target="_blank" rel="noopener">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                            <polyline points="7,10 12,15 17,10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        <span>دانلود از دیجی‌کالا</span>
                    </a>
                <?php endif; ?>

                <!-- Social Share Bottom -->
                <div class="social-share-bottom">
                    <span class="share-label">اشتراک‌گذاری در شبکه‌های اجتماعی:</span>
                    <div class="social-buttons">
                        <a href="https://telegram.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            target="_blank" class="social-btn telegram">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z" />
                            </svg>
                            <span>تلگرام</span>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            target="_blank" class="social-btn twitter">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                            </svg>
                            <span>توییتر</span>
                        </a>

                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                            target="_blank" class="social-btn linkedin">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" />
                                <circle cx="4" cy="4" r="2" />
                            </svg>
                            <span>لینکدین</span>
                        </a>

                        <button class="social-btn copy-link" onclick="copyToClipboard('<?php echo get_permalink(); ?>')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71" />
                                <path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71" />
                            </svg>
                            <span>کپی لینک</span>
                        </button>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
    <?php else : ?>
        <p>مطلبی یافت نشد.</p>
    <?php endif; ?>

    <!-- Related Posts -->
    <?php
    $related_posts = get_posts(array(
        'category__in' => wp_get_post_categories(get_the_ID()),
        'numberposts' => 4,
        'post__not_in' => array(get_the_ID()),
        'post_status' => 'publish'
    ));

    if ($related_posts) : ?>
        <section class="related-posts">
            <h2 class="related-title">مطالب مرتبط</h2>
            <div class="related-posts-grid">
                <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                    <article class="related-post-card">
                        <a href="<?php the_permalink(); ?>" class="related-post-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="related-post-image">
                                    <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
                                </div>
                            <?php endif; ?>
                            <div class="related-post-content">
                                <h3 class="related-post-title"><?php the_title(); ?></h3>
                                <div class="related-post-meta">
                                    <span class="related-post-date"><?php echo get_safe_persian_date('j F Y', get_the_time('U')); ?></span>
                                    <span class="related-post-reading-time"><?php echo calculate_reading_time(get_the_content()); ?> دقیقه مطالعه</span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach;
                wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Post Navigation -->
    <nav class="post-navigation">
        <div class="nav-previous">
            <?php
            $prev_post = get_previous_post();
            if ($prev_post) : ?>
                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link prev-link">
                    <div class="nav-direction">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M15 18l-6-6 6-6" />
                        </svg>
                        <span>مطلب قبلی</span>
                    </div>
                    <h4 class="nav-title"><?php echo get_the_title($prev_post->ID); ?></h4>
                </a>
            <?php endif; ?>
        </div>

        <div class="nav-next">
            <?php
            $next_post = get_next_post();
            if ($next_post) : ?>
                <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link next-link">
                    <div class="nav-direction">
                        <span>مطلب بعدی</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </div>
                    <h4 class="nav-title"><?php echo get_the_title($next_post->ID); ?></h4>
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Comments Section -->
    <?php if (comments_open() || get_comments_number()) : ?>
        <section class="comments-section">
            <h2 class="comments-title">نظرات</h2>
            <?php comments_template(); ?>
        </section>
    <?php endif; ?>

</main>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            const btn = event.target.closest('.copy-link');
            const originalText = btn.querySelector('span')?.textContent || '';
            if (btn.querySelector('span')) {
                btn.querySelector('span').textContent = 'کپی شد!';
                setTimeout(() => {
                    btn.querySelector('span').textContent = originalText || 'کپی لینک';
                }, 2000);
            }
        }).catch(function(err) {
            console.error('خطا در کپی کردن: ', err);
        });
    }
</script>

<?php get_footer(); ?>