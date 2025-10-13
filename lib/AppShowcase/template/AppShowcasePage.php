<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <?php if (function_exists('yoast_breadcrumb')) {
                    yoast_breadcrumb('<div class="breadcrumb-wrapper">', '</div>');
                } ?>
            </nav>

            <!-- notice-section -->
            <section class="notice-section">
                <div class="notice-container">
                    <div class="notice">
                        <?php
                        $approx_price = get_field('Approximate_price');  // مقدار فیلد رو بگیرید
                        if ($approx_price) {

                            $formatted_price = number_format($approx_price, 0, '', '.');
                            echo 'قیمت تقریبی این اپ <strong>' . esc_html($formatted_price) . ' تومان</strong> و دانلود آن برای کاربران اپ‌استور سیبانه رایگان می‌باشد.';
                        } else {
                            echo 'قیمت تقریبی این اپ مشخص نشده و دانلود آن برای کاربران اپ‌استور سیبانه رایگان می‌باشد.';
                        }
                        ?>
                        <a href="#">آشنایی با امکانات و ویژگی‌های اپ‌استور سیبانه</a>
                    </div>
                </div>
            </section>
            <!-- card-section -->
            <section class="card-section">
                <div class="card-container">
                    <div class="card">
                        <div class="app-icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-blue.png" alt="sibaneh-logo-blue" class="hero-section-logo">
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
                                <img src="<?php echo get_template_directory_uri(); ?>/images/temp/Guaranteed-stability.jpg" alt="Guaranteed-stability" class="Guaranteed-stability">
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
                                <div class="votes">از ۱,۰۰۰,۰۰۰ رای </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <!-- post-actions-section -->
            <section class="post-actions-section">
                <div class="post-actions-container">
                    <div class="post-actions">
                        <div class="metadata">
                            <div class="metadata-item">
                                <div class="metadata-item-container">
                                    <div class="metadata-value-time">
                                        ۵ آذر ۱۴۰۴
                                    </div>
                                    <div class="metadata-label-title">تاریخ بروزرسانی</div>
                                </div>
                            </div>
                            <div class="metadata-separator"></div>
                            <div class="metadata-item">
                                <button class="download-button metadata-item-container">
                                    <div class="metadata-value"><i class="icon-video-player"></i></div>
                                    <div class="metadata-label">ویدیو معرفی</div>
                                </button>
                            </div>
                            <div class="metadata-separator"></div>
                            <div class="metadata-item">
                                <a class="metadata-item-container" href="<?php echo get_post_meta(get_the_ID(), 'video_review_url', true); ?>">
                                    <div class="metadata-value"><i class="icon-circle"></i></div>
                                    <div class="metadata-label">آموزش نصب</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- download-button-section -->
            <section class="download-button-section">
                <div class="download-button-container">
                    <button class="button">
                        شروع فرآیند دانلود
                    </button>
                </div>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- Screenshots Carousel -->
            <section class="screenshots-section">
                <div class="screenshots-container">
                    <div class="screenshots">
                        <div class="screenshots-section-nav">
                            <h2 class="screenshots-section-title">اسکرین شات‌ها</h2>
                            <nav class="gallery-nav">
                                <ul class="gallery-nav__items">
                                    <li class="gallery-nav__item">
                                        <a id="ember50" class="ember-view active" href="#">
                                            iPhone
                                        </a>
                                    </li>
                                    <li class="gallery-nav__item">
                                        <a id="ember51" class="ember-view" href="#">
                                            iPad
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="screenshots-carousel" data-device="iphone">
                            <?php
                            $screenshots_iphone_ids = get_post_meta(get_the_ID(), 'screenshots_iphone_ids', true);
                            if (!empty($screenshots_iphone_ids)) {
                                $ids_array = explode(',', $screenshots_iphone_ids);
                                foreach ($ids_array as $id) {
                                    $id = trim($id);
                                    $image_url = wp_get_attachment_url($id);
                                    if ($image_url) {
                                        echo '<div class="screenshot" style="background-image: url(\'' . esc_url($image_url) . '\');"></div>';
                                    }
                                }
                            } else {
                                echo
                                '<div class="screenshot" style="background-image: url(\'https://via.placeholder.com/240x520?text=iPhone+Screenshot+1\');"></div>
                                 <div class="screenshot" style="background-image: url(\'https://via.placeholder.com/240x520?text=iPhone+Screenshot+2\');"></div>
                                 <div class="screenshot" style="background-image: url(\'https://via.placeholder.com/240x520?text=iPhone+Screenshot+3\');"></div>
                                 <div class="screenshot" style="background-image: url(\'https://via.placeholder.com/240x520?text=iPhone+Screenshot+4\');"></div>';
                            }
                            ?>
                        </div>
                        <div class="screenshots-carousel" data-device="ipad" style="display: none;">
                            <?php
                            $screenshots_ipad_ids = get_post_meta(get_the_ID(), 'screenshots_ipad_ids', true);
                            if (!empty($screenshots_ipad_ids)) {
                                $ids_array = explode(',', $screenshots_ipad_ids);
                                foreach ($ids_array as $id) {
                                    $id = trim($id);
                                    $image_url = wp_get_attachment_url($id);
                                    if ($image_url) {
                                        echo '<div class="screenshot" style="background-image: url(\'' . esc_url($image_url) . '\');"></div>';
                                    }
                                }
                            } else {
                                echo
                                '<div class="screenshot" style="background-image: url(\'https://via.placeholder.com/300x400?text=iPad+Screenshot+1\');"></div>
                                 <div class="screenshot" style="background-image: url(\'https://via.placeholder.com/300x400?text=iPad+Screenshot+2\');"></div>
                                 <div class="screenshot" style="background-image: url(\'https://via.placeholder.com/300x400?text=iPad+Screenshot+3\');"></div>
                                 <div class="screenshot" style="background-image: url(\'https://via.placeholder.com/300x400?text=iPad+Screenshot+4\');"></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- Contents section-->
            <section class="contents-section">
                <div class="contents-nav">
                    <nav class="tab-nav">
                        <ul class="tab-nav-items">
                            <li class="tab-nav-item active" data-tab="description">
                                <a href="#description">توضیحات</a>
                            </li>
                            <li class="tab-nav-item" data-tab="features">
                                <a href="#features">ویژگی‌ها</a>
                            </li>
                            <li class="tab-nav-item" data-tab="pros-cons">
                                <a href="#pros-cons">مزایا و معایب</a>
                            </li>
                            <li class="tab-nav-item" data-tab="comparison">
                                <a href="#comparison">مقایسه</a>
                            </li>
                            <li class="tab-nav-item" data-tab="faq">
                                <a href="#faq">سوالات متداول</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Contents -->
                <div class="contents">
                    <div class="contents-container">
                        <!-- Description Tab -->
                        <div id="description" class="tab-content active">
                            <h2 class="section-title">توضیحات</h2>
                            <p>اپلیکیشن دیجی‌کالا یکی از بهترین برنامه‌های خرید آنلاین در ایران است. این اپلیکیشن امکان خرید از هزاران کالا در دسته‌بندی‌های مختلف را فراهم می‌کند. کاربران می‌توانند از جستجوی پیشرفته، فیلترهای متنوع و پیشنهادات شخصی‌سازی شده استفاده کنند. همچنین، اپلیکیشن دیجی‌کالا دارای ویژگی‌هایی مانند پرداخت آنلاین، پیگیری سفارشات و پشتیبانی ۲۴ ساعته است.<grok-card data-id="b3445b" data-type="citation_card"></grok-card> از ویژگی‌های جذاب اپلیکیشن دیجی‌کالا دریافت اعلان و نوتیفیکیشن‌های تخفیف، حراج، فروش‌ ویژه و کد تخفیف انحصاری اپلیکیشن است.</p>
                        </div>

                        <!-- Features Tab -->
                        <div id="features" class="tab-content">
                            <h2 class="section-title">ویژگی‌ها</h2>
                            <ul>
                                <li>جستجوی آسان‌تر<grok-card data-id="11f3c8" data-type="citation_card"></grok-card></li>
                                <li>خرید سوپرمارکتی، آسان‌تر از همیشه</li>
                                <li>اطلاع لحظه‌ای از وضعیت سفارش</li>
                                <li>امکان استفاده از اثر انگشت برای ورود (در iOS)</li>
                                <li>دریافت خدمات در قالب سه تب جداگانه برای دسترسی سریع</li>
                            </ul>
                        </div>

                        <!-- Pros and Cons Tab -->
                        <div id="pros-cons" class="tab-content">
                            <h2 class="section-title">مزایا و معایب</h2>
                            <h3>مزایا:</h3>
                            <ul>
                                <li>تخفیف‌های متنوع و ویژه<grok-card data-id="8e1794" data-type="citation_card"></grok-card></li>
                                <li>ارسال سریع سفارشات</li>
                                <li>رابط کاربری آسان و سرعت بالا</li>
                                <li>اطلاع از سفارش‌ها در لحظه ثبت</li>
                            </ul>
                            <h3>معایب:</h3>
                            <ul>
                                <li>هزینه کمیسیون برای فروشندگان<grok-card data-id="8b81ed" data-type="citation_card"></grok-card></li>
                                <li>وابستگی برای فروش</li>
                                <li>تاخیر در تسویه حساب</li>
                                <li>هزینه اشتراک برای برخی خدمات</li>
                            </ul>
                        </div>

                        <!-- Comparison Tab -->
                        <div id="comparison" class="tab-content">
                            <h2 class="section-title">مقایسه</h2>
                            <p>در مقایسه با رقبا مانند اسنپ مارکت، دیجی‌کالا تنوع کالایی بیشتری دارد اما اسنپ مارکت در ارسال سریع سوپرمارکتی قوی‌تر است.<grok-card data-id="e1119b" data-type="citation_card"></grok-card> بامیلو قبلاً رقیب بود اما تعطیل شده. دیجی‌کالا در جستجو و فیلترها برتر است.</p>
                        </div>

                        <!-- FAQ Tab -->
                        <div id="faq" class="tab-content">
                            <h2 class="section-title">سوالات متداول</h2>
                            <ul class="faq-list">
                                <li>چطور می‌توانم سفارشم را پیگیری کنم؟<grok-card data-id="e61677" data-type="citation_card"></grok-card></li>
                                <li>چطور میتوانم سفارشم را لغو کنم؟</li>
                                <li>آیا اپلیکیشن دیجی‌کالا رایگان است؟</li>
                                <li>چگونه اپلیکیشن را بروزرسانی کنیم؟</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- Version Section -->
            <section class="version-section">
                <div class="version-container">
                    <div class="version">
                        <h2 class="section-title">تغییرات نسخه جدید</h2>
                        <ul>
                            <li>- بهبود رابط کاربری در نسخه جدید</li>
                            <li>- افزایش گزینه های انتقال اطلاعات</li>
                        </ul>
                    </div>

                    <!-- Version History Popup -->
                    <div class="version-history">
                        <a href="#" id="version-history-link">سوابق نسخه‌ها</a>
                    </div>
                    <dialog id="version-history-modal">
                        <h2>سوابق نسخه‌ها</h2>
                        <ul>
                            <li>نسخه 3.1.1: بهبود پلتفرم<grok-card data-id="f3a7b0" data-type="citation_card"></grok-card></li>
                            <li>نسخه قبلی: اضافه شدن خدمات جدید</li>
                            <li>تاریخچه از سال 1385 شروع شده.</li>
                        </ul>
                        <button id="close-modal">بستن</button>
                    </dialog>
                </div>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- Comments Section -->
            <section class="comments-section">
                <?php
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- privacy Section -->
            <section class="privacy">
                <div class="container">
                    <h2>امنیت و حریم خصوصی</h2>
                    <p>
                        براساس اعلام شرکت توسعه‌دهنده این اپلیکیشن ممکن است بر اساس نیاز دسترسی به موارد زیر را از شما درخواست کند.
                    </p>
                    <div class="privacy-info">
                        <div class="info-icon">
                            <i class="icon-user-2"></i>
                        </div>
                        <h3>اطلاعات</h3>
                        <p>طبق اعلام شرکت سازنده اطلاعات زیر ممکن است هنگام استفاده از اپلیکیشن مورد نیاز باشد.</p>
                        <ul class="data-list">
                            <li><i class="icon-telegram"></i> Purchases</li>
                            <li><i class="icon-telegram"></i> Location</li>
                            <li><i class="icon-telegram"></i> Contact Info</li>
                            <li><i class="icon-telegram"></i> Contacts</li>
                            <li><i class="icon-telegram"></i> User Content</li>
                            <li><i class="icon-telegram"></i> Identifiers</li>
                            <li><i class="icon-telegram"></i> Usage Data</li>
                            <li><i class="icon-telegram"></i> Sensitive Info</li>
                            <li><i class="icon-telegram"></i> Diagnostics</li>
                        </ul>
                    </div>
                </div>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- stability Section -->
            <section class="stability">
                <div class="stability-container">
                    <div class="stability-header">
                        <h2>تضمین پایداری</h2>
                        <a href="#">آشنایی بیشتر</a>
                    </div>
                    <div class="stability-card">
                        <div class="stability-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/Guaranteed-stability-2.jpg" alt="Guaranteed-stability" class="Guaranteed-stability">
                        </div>
                        <p>
                            عرضه و انتشار این اپلیکیشن در اپ‌استور سیبانه دارای تضمین پایداری است.
                            در سرویس اپ‌استور سیبانه اپلیکیشن‌هایی که دارای تضمین پایداری هستند با پایداری ۹۹٫۹ درصدی منتشر و در اختیار کاربران ایرانی آیفون و آیپد قرار می‌گیرند.
                        </p>
                    </div>
                </div>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- App Info Section -->
            <section class="app-info">
                <div class="container">
                    <h2>اطلاعات اپلیکیشن</h2>
                    <ul>
                        <li><strong>فروشنده</strong> دیجی‌کالا</li>
                        <li><strong>نسخه</strong> ۲.۶.۹</li>
                        <li><strong>حجم</strong> ۱۹۹ MB</li>
                        <li><strong>دسته‌بندی</strong> ایرانی</li>
                        <li><strong>دستگاه‌های سازگار</strong>
                        <li><strong>آیفون</strong>iOS7 و بالاتر</li>
                        <li><strong>آیپد</strong>iPadOS7 و بالاتر</li>
                        </li>
                        <li><strong>مناسب برای رده سنی</strong>بزرگتر از ۴ سال</li>
                    </ul>
                </div>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- App Store Link Section -->
            <section class="appstore-link">
                <div class="container">
                    <a href="#" class="appstore-item">این برنامه در اپ‌استور اپل ↗</a>
                </div>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- Developer Site Section -->
            <section class="developer-site">
                <div class="container">
                    <a href="#" class="developer-link">وب‌سایت رسمی توسعه‌دهنده ↗</a>
                </div>
            </section>
            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- Related Apps Section -->
            <section class="related-apps">
                <div class="container">
                    <h2>اپلیکیشن‌هایی که شاید دوست داشته باشید</h2>
                    <div class="app-list">
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                        <div class="app-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                            <p>happn: Dating, Chat &amp; Meet</p>
                        </div>
                    </div>
                </div>
            </section>


    <?php endwhile;
    endif; ?>
</div>