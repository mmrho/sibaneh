<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php
            // Get the split content
            $split_content = split_post_content();
            ?>
            <!-- callToActionToClustr -->
            <section class="tableOfContents" id="tableOfContents">

                <?php wbsLoadTableOfContents('#site-header'); ?>

            </section>
            <!-- callToActionToClustr -->
            <section class="tableOfContents">

                <?php wbsLoadTableOfContents('#tableOfContents'); ?>

            </section>

            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <?php if (function_exists('yoast_breadcrumb')) {
                    yoast_breadcrumb('<div class="breadcrumb-wrapper">', '</div>');
                } ?>
            </nav>

            <!-- Post Article -->
            <article class="single-post-article">
                <!-- Post Info -->
                <div class="post-header">
                    <!-- Post Meta -->
                    <div class="post-meta">
                        <div class="meta-item">
                            <span>بروز</span>
                        </div>
                    </div>

                    <!-- Component Content -->
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
                        </div>
                    </div>

                    <!-- Post Actions -->
                    <div class="post-actions">
                        <div class="metadata">
                            <div class="metadata-item">
                                <div class="metadata-item-container">
                                    <div class="metadata-value-time">
                                        <?php
                                        $yoast_reading_time = get_post_meta(get_the_ID(), '_yoast_wpseo_estimated-reading-time-minutes', true);
                                        echo $yoast_reading_time ? $yoast_reading_time : calculate_reading_time(get_the_content());
                                        ?> دقیقه
                                    </div>
                                    <div class="metadata-label-title">مدت زمان مطالعه</div>
                                </div>
                            </div>
                            <div class="metadata-separator"></div>
                            <div class="metadata-item">
                                <div class="post-meta">
                                    <div class="meta-item">
                                        <span><?php echo get_the_date('j F Y'); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <span>تاریخ بروزرسانی</span>
                                    </div>
                                </div>
                            </div>
                            <div class="metadata-separator"></div>
                            <div class="metadata-item">
                                <a class="metadata-item-container" href="<?php echo get_post_meta(get_the_ID(), 'video_review_url', true); ?>">
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

            </article>
            <!-- Social Media -->
            <section>
                <!-- Social Share -->
                <div class="social-share">
                    <div>
                        <span>
                            اشتراک گذاری مطلب
                        </span>
                    </div>
                    <div class="social-buttons">
                        <button class="social-btn copy-link" onclick="copyToClipboard('<?php echo get_permalink(); ?>')" title="کپی لینک">
                            <i class="icon-link"></i>
                        </button>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                            target="_blank" class="social-btn instagram" title="اشتراک در اینستاگرام">
                            <i class="icon-instagram"></i>
                        </a>
                        <a href="https://telegram.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            target="_blank" class="social-btn telegram" title="اشتراک در تلگرام">
                            <i class="icon-telegram"></i>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            target="_blank" class="social-btn twitter" title="اشتراک در ایکس">
                            <i class="icon-x"></i>
                        </a>
                    </div>
                </div>
                <div class="sibaneh-social-media">
                    <div>
                        <span>
                            سیبانه در شبکه‌های اجتماعی
                        </span>
                    </div>
                    <div class="social-buttons">
                        <button class="social-btn copy-link" onclick="copyToClipboard('<?php echo get_permalink(); ?>')" title="کپی لینک">
                            <i class="icon-link"></i>
                        </button>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                            target="_blank" class="social-btn instagram" title="اشتراک در اینستاگرام">
                            <i class="icon-instagram"></i>
                        </a>
                        <a href="https://telegram.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            target="_blank" class="social-btn telegram" title="اشتراک در تلگرام">
                            <i class="icon-telegram"></i>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            target="_blank" class="social-btn twitter" title="اشتراک در ایکس">
                            <i class="icon-x"></i>
                        </a>
                    </div>
                </div>
                <div class="sibaneh-social-media">
                    <div>
                        <span>
                            ارتباط با تیم تولید محتوای سیبانه
                        </span>
                    </div>
                    <div class="social-buttons">
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                            target="_blank" class="social-btn instagram" title="اشتراک در اینستاگرام">
                            <span>
                                press@sibaneh.com
                            </span>
                        </a>
                    </div>
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

            <!-- Similar Tutorials -->
            <section class="related-posts similar-and-more-tutorials">
                <div class="related-posts-header">
                    <h2>آموزش‌های مشابه و بیشتر</h2>
                </div>
                <div class="related-posts-grid">
                    <?php
                    $current_post_id = get_the_ID();
                    $categories = wp_get_post_categories($current_post_id);

                    if (!empty($categories)) {
                        $related = get_posts(array(
                            'category__in' => $categories,
                            'numberposts' => 3,
                            'post__not_in' => array($current_post_id),
                            'post_status' => 'publish',
                            'suppress_filters' => false
                        ));

                        $total_posts = count($related);

                        if ($related && !empty($related)) {
                            foreach ($related as $index => $related_post) {
                                setup_postdata($related_post); ?>
                                <article class="related-post-item tutorial-item">
                                    <a href="<?php the_permalink(); ?>" class="related-post-link">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="related-post-thumb">
                                                <?php the_post_thumbnail('medium'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="related-post-content">
                                            <h3 class="tutorial-category">
                                                <?php
                                                $post_categories = get_the_category();
                                                if (!empty($post_categories)) {
                                                    echo 'آموزش‌های ' . esc_html($post_categories[0]->name);
                                                } else {
                                                    echo 'آموزش‌های سیبانه';
                                                }
                                                ?>
                                            </h3>
                                            <h4 class="related-post-title"><?php the_title(); ?></h4>
                                        </div>
                                    </a>
                                </article>
                                <?php if ($index < $total_posts - 1) : ?>
                                    <hr>
                                <?php endif;
                            }
                            wp_reset_postdata();
                        }
                    }

                    if (empty($categories) || !$related) {
                        // If the post has no category, or no related posts were found, display the latest posts.
                        $related = get_posts(array(
                            'numberposts' => 3,
                            'post__not_in' => array($current_post_id),
                            'post_status' => 'publish'
                        ));

                        $total_posts = count($related);

                        if ($related) {
                            foreach ($related as $index => $related_post) {
                                setup_postdata($related_post); ?>
                                <article class="related-post-item tutorial-item">
                                    <a href="<?php the_permalink(); ?>" class="related-post-link">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="related-post-thumb">
                                                <?php the_post_thumbnail('medium'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="related-post-content">
                                            <h3 class="tutorial-category">آموزش‌های سیبانه</h3>
                                            <h4 class="related-post-title"><?php the_title(); ?></h4>
                                        </div>
                                    </a>
                                </article>
                                <?php if ($index < $total_posts - 1) : ?>
                                    <hr>
                    <?php endif;
                            }
                            wp_reset_postdata();
                        } else {
                            echo '<p>هیچ مطلبی برای نمایش یافت نشد.</p>';
                        }
                    }
                    ?>
                </div>
            </section>

    <?php endwhile;
    endif; ?>
</div>