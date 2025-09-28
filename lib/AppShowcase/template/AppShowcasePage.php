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
            <!-- notice-section -->
            <section class="notice-section">
                <div class="notice">
                    قیمت تقریبی این اپ <strong>99.000 تومان</strong> و دانلود آن برای کاربران اپ‌استور سیبانه رایگان می‌باشد.
                    <a href="#">آشنایی با امکانات و ویژگی‌های اپ‌استور سیبانه</a>
                </div>
            </section>
            <!-- card-section -->
            <section class="card-section">
                <div class="card">
                    <div class="app-icon">
                        <img src="https://sibaneh:8890/wp-content/themes/sibaneh/images/temp/sibaneh-logo-blue.png" alt="">
                    </div>
                    <div class="info">


                        <div class="section-small-title">پیشنهادات سیبانه</div>
                        <div class="headline">دانلود دیجی‌کالا برای آیفون و آیپد</div>
                        <div class="brand-row">
                            <div class="brand-fa">دیجی‌کالا</div>
                            <div class="brand-en">|</div>
                            <div class="brand-en">Digikala</div>
                        </div>

                        <div class="badge">
                            <div class="laurel">تضمین<br>پایداری</div>
                            <div style="font-size:13px;color:#6b7280;">تضمین پایداری دارد</div>
                        </div>

                        <div class="rating">
                            <div class="stars">
                                <!-- five stars -->
                                <i class="icon-video-player"></i>
                                <i class="icon-video-player"></i>
                                <i class="icon-video-player"></i>
                                <i class="icon-video-player"></i>
                                <i class="icon-video-player"></i>

                            </div>
                            <div class="votes">از ۱,۰۰۰,۰۰۰ رای</div>
                        </div>
                    </div>

                </div>
            </section>
            <!-- post-actions-section -->
            <section class="post-actions-section">
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
                            <button class="download-button metadata-item-container">
                                <div class="metadata-value"><i class="icon-circle"></i></div>
                                <div class="metadata-label">دانلود برنامه <?php the_title(); ?></div>
                            </button>
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