<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <!-- Breadcrumb -->
            <nav class="breadcrumb-1">
                <?php if (function_exists('yoast_breadcrumb')) {
                    yoast_breadcrumb('<div class="breadcrumb-wrapper">', '</div>');
                } ?>
            </nav>

            <!-- notice-section -->
            <section class="notice-section">
                <div class="notice-container">
                    <div class="notice">
                        <span>دانلود رایگان برای کاربران دارای اشتراک.</span>
                        <i class="icon-info-sbh"></i>
                        <a href="#"></a>
                    </div>
                </div>
            </section>

            <!-- card-section -->
            <section class="card-section">
                <div class="card-container">
                    <div class="card">
                        <div class="app-icon">
                            <?php
                            $app_icon = get_field('app_icon');
                            $app_icon_url = $app_icon ? esc_url($app_icon['url']) : get_template_directory_uri() . '/images/temp/sibaneh-logo-blue.png';
                            $app_icon_alt = $app_icon ? esc_attr($app_icon['alt']) : 'sibaneh-logo-blue';
                            ?>
                            <img src="<?php echo $app_icon_url; ?>" alt="<?php echo $app_icon_alt; ?>" class="hero-section-logo">
                        </div>
                        <div class="info">
                            <?php
                            $app_name_details = get_field('App_name_details');
                            $app_label = isset($app_name_details['App_label']) ? esc_html($app_name_details['App_label']) : 'پیشنهادات سیبانه';
                            $persian_name = isset($app_name_details['Persian_name_of_the_app']) ? esc_html($app_name_details['Persian_name_of_the_app']) : 'سیبانه';
                            $english_name = isset($app_name_details['English_name_of_the_app']) ? esc_html($app_name_details['English_name_of_the_app']) : 'Sibaneh';
                            ?>
                            <h1 class="headline"><?php the_title(); ?></h1>
                            <div class="brand-row">
                                <div class="brand-fa"><?php echo $persian_name; ?></div>
                                <div class="brand-en">|</div>
                                <div class="brand-en"><?php echo $english_name; ?></div>
                            </div>
                            <div class="stability-share">
                                <div class="stability-logo">
                                    <i class="icon-wheat-spike-sbh-right"></i>
                                    <div class="stability-text">
                                        <span>تضمین پایداری</span>
                                        <span>دارد</span>
                                    </div>
                                    <i class="icon-wheat-spike-sbh-left"></i>
                                </div>
                                <button class="share-button">
                                    <span>اشتراک گذاری</span>
                                    <i class="icon-share-sbh"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>

            <!-- post-actions-section -->
            <section class="post-actions-section">
                <div class="post-actions-container">
                    <div class="post-actions">
                        <div class="metadata">
                            <div class="metadata-item">
                                <i class="icon-dollar-sbh"></i>
                                <div class="metadata-value">۹.۹۹</div>
                                <div class="metadata-label">قیمت دلاری</div>
                            </div>
                            <div class="metadata-separator"></div>
                            <div class="metadata-item">
                                <i class="icon-pwa-sbh"></i>
                                <div class="metadata-value">PWA</div>
                                <div class="metadata-label">نوع اپ</div>
                            </div>
                            <div class="metadata-separator"></div>
                            <div class="metadata-item">
                                <i class="icon-download-sbh"></i>
                                <div class="metadata-value">12k</div>
                                <div class="metadata-label">تعداد دانلود</div>
                            </div>
                            <div class="metadata-separator"></div>
                            <div class="metadata-item">
                                <i class="icon-checkbox-sbh"></i>
                                <div class="metadata-value">اشتراک سیبانه</div>
                                <div class="metadata-label">سازگار با</div>
                            </div>
                            <div class="metadata-separator"></div>
                            <div class="metadata-item">
                                <?php
                                $app_videos = get_field('App_videos');
                                $intro_video   = $app_videos['Introduction_video'] ?? '';
                                $install_video = $app_videos['Installation_instructions'] ?? '';
                                ?>

                                <?php if ($install_video) : ?>
                                    <button type="button"
                                        class="download-button metadata-item-container"
                                        onclick="showVideoModal('<?php echo esc_js(addslashes($install_video)); ?>')">
                                        <div class="metadata-value"><i class="icon-play-in-circle"></i></div>
                                        <div class="metadata-label">آموزش نصب</div>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>

            <!-- Modal placed OUTSIDE of the section -->
            <div id="videoModal" class="video-modal">
                <div class="video-backdrop" onclick="closeVideoModal()"></div>
                <div class="video-content"></div>
            </div>

            <!-- download-button-section -->
            <section class="download-button-section">
                <div class="download-button-container">
                    <button class="button">
                        <span>دانلود</span>
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
                            // Retrieve the screenshots group
                            $screenshots = get_field('Screenshots');
                            $iphone_screenshots = !empty($screenshots['iphone_Screenshots']) ? $screenshots['iphone_Screenshots'] : [];

                            if (!empty($iphone_screenshots)) {
                                foreach ($iphone_screenshots as $screenshot) {
                                    $image_url = !empty($screenshot['iphone_image_url']['url']) ? $screenshot['iphone_image_url']['url'] : '';
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
                            $ipad_screenshots = !empty($screenshots['ipad_Screenshots']) ? $screenshots['ipad_Screenshots'] : [];

                            if (!empty($ipad_screenshots)) {
                                foreach ($ipad_screenshots as $screenshot) {
                                    $image_url = !empty($screenshot['ipad_image_url']['url']) ? $screenshot['ipad_image_url']['url'] : '';
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
                            <p>اپلیکیشن دیجی‌کالا یکی از بهترین برنامه‌های خرید آنلاین در ایران است. این اپلیکیشن امکان خرید از هزاران کالا در دسته‌بندی‌های مختلف را فراهم می‌کند. کاربران می‌توانند از جستجوی پیشرفته، فیلترهای متنوع و پیشنهادات شخصی‌سازی شده استفاده کنند. همچنین، اپلیکیشن دیجی‌کالا دارای ویژگی‌هایی مانند پرداخت آنلاین، پیگیری سفارشات و پ از ویژگی‌های جذاب اپلیکیشن دیجی‌کالا دریافت اعلان و نوتیفیکیشن‌های تخفیف، حراج، فروش‌ ویژه و کد تخفیف انحصاری اپلیکیشن است.</p>
                        </div>

                        <!-- Features Tab -->
                        <div id="features" class="tab-content">
                            <h2 class="section-title">ویژگی‌ها</h2>
                            <ul>
                                <li>جستجوی آسان‌تر</li>
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
                                <li>تخفیف‌های متنوع و ویژه</li>
                                <li>ارسال سریع سفارشات</li>
                                <li>رابط کاربری آسان و سرعت بالا</li>
                                <li>اطلاع از سفارش‌ها در لحظه ثبت</li>
                            </ul>
                            <h3>معایب:</h3>
                            <ul>
                                <li>هزینه کمیسیون برای فروشندگان</li>
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
                                <li>چطور می‌توانم سفارشم را پیگیری کنم؟</li>
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
                        <?php
                        $version_changes = get_field('version_changes');
                        $new_changes = !empty($version_changes['new_version_changes']) ? $version_changes['new_version_changes'] : '';

                        if ($new_changes) {
                            $lines = explode("\n", $new_changes);
                            echo '<ul>';
                            foreach ($lines as $line) {
                                $trimmed_line = trim($line);
                                if ($trimmed_line) {
                                    echo '<li>' . esc_html($trimmed_line) . '</li>';
                                }
                            }
                            echo '</ul>';
                        } else {
                            echo '<ul>
                    <li>- بهبود رابط کاربری در نسخه جدید</li>
                    <li>- افزایش گزینه های انتقال اطلاعات</li>
                </ul>';
                        }
                        ?>
                    </div>

                    <!-- Version History Popup -->
                    <div class="version-history">
                        <a href="#" id="version-history-link">سوابق نسخه‌ها</a>
                    </div>
                    <dialog id="version-history-modal">
                        <h2>سوابق نسخه‌ها</h2>
                        <?php
                        $history = !empty($version_changes['version_history']) ? $version_changes['version_history'] : '';

                        if ($history) {
                            $lines = explode("\n", $history);
                            echo '<ul>';
                            foreach ($lines as $line) {
                                $trimmed_line = trim($line);
                                if ($trimmed_line) {
                                    echo '<li>' . esc_html($trimmed_line) . '</li>';
                                }
                            }
                            echo '</ul>';
                        } else {
                            echo '<ul>
                    <li>نسخه 3.1.1: بهبود پلتفرم</li>
                    <li>نسخه قبلی: اضافه شدن خدمات جدید</li>
                    <li>تاریخچه از سال 1385 شروع شده.</li>
                </ul>';
                        }
                        ?>
                        <button id="close-modal">بستن</button>
                    </dialog>
                </div>
            </section>

            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>
            <!-- Availability Section -->
            <section class="availability">
                <div class="availability-container">
                    <div class="availability-header">
                        <h2>قابلیت در دسترس بودن</h2>
                        <span>آخرین آپدیت در ۸:۳۰ - ۴ مهر ۱۴۰۴</span>
                    </div>
                    <div class="availability-text">
                        <i class="icon-circle-sbh"></i>
                        <span>این اپلیکیشن به صورت نرمال قابل دسترس میباشد.</span>
                    </div>
                </div>
            </section>

            <div class="break">
                <div class="break-container">
                    <hr />
                </div>
            </div>


            <!-- Comments Section -->
            <section class="comments-section">
                <div class="container">
                    <h2>نظرات کاربران</h2>
                    <?php
                    global $post;

                    if ($post->post_type === 'page' && !comments_open($post->ID)) {
                        wp_update_post(array(
                            'ID' => $post->ID,
                            'comment_status' => 'open'
                        ));
                    }
                    if (comments_open($post->ID) || get_comments_number($post->ID)) {
                        comments_template();
                    }
                    ?>
                </div>
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
                            <i class="icon-contacts-sbh"></i>
                        </div>
                        <h3>اطلاعات</h3>
                        <p>طبق اعلام شرکت سازنده اطلاعات زیر ممکن است هنگام استفاده از اپلیکیشن مورد نیاز باشد.</p>
                        <ul class="data-list">
                            <?php
                            $privacy_items = get_field('Security_and_privacy');
                            if (!empty($privacy_items) && is_array($privacy_items)) {
                                foreach ($privacy_items as $item) {
                                    $value = $item['value'];
                                    $icon_class = 'icon-' . str_replace(' ', '-', strtolower($value));
                                    echo '<li><i class="' . esc_attr($icon_class) . '"></i> ' . esc_html($value) . '</li>';
                                }
                            } else {
                                echo '
                                      <li><i class="icon-purchases-sbh"></i> Purchases</li>
                                      <li><i class="icon-location-sbh"></i> Location</li>
                                      <li><i class="icon-contact-info-sbh"></i> Contact Info</li>
                                      <li><i class="icon-contacts-sbh"></i> Contacts</li>
                                      <li><i class="icon-user-content-sbh"></i> User Content</li>
                                      <li><i class="icon-identifiers-sbh"></i> Identifiers</li>
                                      <li><i class="icon-usage-data-sbh"></i> Usage Data</li>
                                      <li><i class="icon-sensitive-info-sbh"></i> Sensitive Info</li>
                                      <li><i class="icon-diagnostics-sbh"></i> Diagnostics</li>';
                            }
                            ?>
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
                        <div class="stability-logo">
                            <i class="icon-wheat-spike-sbh-right"></i>
                            <span>تضمین پایداری دارد</span>
                            <i class="icon-wheat-spike-sbh-left"></i>
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
                    <ul class="app-details">
                        <?php
                        $app_info = get_field('App_info');
                        if (!empty($app_info) && is_array($app_info)) {
                            // فروشنده
                            $seller = !empty($app_info['Seller']) ? esc_html($app_info['Seller']) : 'سیبانه';
                            echo '<li><strong>فروشنده</strong><span>' . $seller . '</span></li>';

                            // نسخه
                            $version = !empty($app_info['Version']) ? esc_html($app_info['Version']) : '۱.۱.۱';
                            echo '<li><strong>نسخه</strong><span>' . $version . '</span></li>';

                            // حجم
                            $size = !empty($app_info['Size']) ? esc_html($app_info['Size']) : '۰ مگابایت';
                            echo '<li><strong>حجم</strong><span>' . $size . '</span></li>';

                            // دسته‌بندی
                            $categories = !empty($app_info['Category']) && is_array($app_info['Category']) ? $app_info['Category'] : [];
                            $category_names = [];
                            foreach ($categories as $category) {
                                if (is_object($category) && isset($category->name)) {
                                    $category_names[] = esc_html($category->name);
                                }
                            }
                            $category_display = !empty($category_names) ? implode(', ', $category_names) : 'ایرانی';
                            echo '<li><strong>دسته‌بندی</strong><span>' . $category_display . '</span></li>';

                            // دستگاه‌های سازگار
                            echo '<li><strong>دستگاه‌های سازگار</strong></li>';
                            // آیفون
                            $compat_iphone = !empty($app_info['Compatibility']['Compatibility_iphone']) ? esc_html($app_info['Compatibility']['Compatibility_iphone']) : 'iOS 7 و بالاتر';
                            echo '<li><strong>آیفون</strong><span>' . $compat_iphone . '</span></li>';
                            // آیپد
                            $compat_ipad = !empty($app_info['Compatibility']['Compatibility_ipad']) ? esc_html($app_info['Compatibility']['Compatibility_ipad']) : 'iPadOS 7 و بالاتر';
                            echo '<li><strong>آیپد</strong><span>' . $compat_ipad . '</span></li>';

                            // رده سنی
                            $age_rating = !empty($app_info['Age_Rating']) ? esc_html($app_info['Age_Rating']) : 'بزرگ‌تر از ۴ سال';
                            echo '<li><strong>مناسب برای رده سنی</strong><span>' . $age_rating . '</span></li>';
                        } else {
                            // مقادیر پیش‌فرض در صورت نبود داده
                            echo '
                <li><strong>فروشنده</strong><span>سیبانه</span></li>
                <li><strong>نسخه</strong><span>۱.۱.۱</span></li>
                <li><strong>حجم</strong><span>۰ مگابایت</span></li>
                <li><strong>دسته‌بندی</strong><span>ایرانی</span></li>
                <li><strong>دستگاه‌های سازگار</strong></li>
                <li><strong>آیفون</strong><span>iOS 7 و بالاتر</span></li>
                <li><strong>آیپد</strong><span>iPadOS 7 و بالاتر</span></li>
                <li><strong>مناسب برای رده سنی</strong><span>بزرگ‌تر از ۴ سال</span></li>';
                        }
                        ?>
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
                    <?php
                    $appstore_link = get_field('appstore_link');
                    $appstore_url = !empty($appstore_link['url']) ? esc_url($appstore_link['url']) : '#';
                    $appstore_title = !empty($appstore_link['title']) ? esc_html($appstore_link['title']) : 'این برنامه در اپ‌استور اپل';
                    $appstore_target = !empty($appstore_link['target']) ? esc_attr($appstore_link['target']) : '_blank';
                    ?>
                    <a href="<?php echo $appstore_url; ?>" class="appstore-item" target="<?php echo $appstore_target; ?>">
                        <span><?php echo $appstore_title; ?></span><i class="icon-up-left-arrow-sbh"></i>
                    </a>
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
                    <?php
                    $developer_link = get_field('developer_site_link');
                    $developer_url = !empty($developer_link['url']) ? esc_url($developer_link['url']) : '#';
                    $developer_title = !empty($developer_link['title']) ? esc_html($developer_link['title']) : 'وب‌سایت رسمی توسعه‌دهنده';
                    $developer_target = !empty($developer_link['target']) ? esc_attr($developer_link['target']) : '_blank';
                    ?>
                    <a href="<?php echo $developer_url; ?>" class Mestge to 'Developer Site Section' was edited for clarity.class="developer-link" target="<?php echo $developer_target; ?>">
                        <span><?php echo $developer_title; ?></span><i class="icon-up-left-arrow-sbh"></i>
                    </a>
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
                        <?php
                        // Get current post's categories from App_info
                        $app_info = get_field('App_info');
                        $categories = !empty($app_info['Category']) && is_array($app_info['Category']) ? $app_info['Category'] : [];
                        $category_ids = array_map(function ($category) {
                            return is_object($category) ? $category->term_id : $category;
                        }, $categories);

                        // Set up WP_Query to find related posts
                        $args = array(
                            'post_type' => 'page', // Assuming apps are stored as pages (based on JSON)
                            'post__not_in' => array(get_the_ID()), // Exclude current post
                            'posts_per_page' => 6, // Limit to 6 related apps
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'category',
                                    'field' => 'term_id',
                                    'terms' => $category_ids,
                                    'operator' => 'IN',
                                ),
                            ),
                        );

                        $related_query = new WP_Query($args);

                        if ($related_query->have_posts()) {
                            while ($related_query->have_posts()) {
                                $related_query->the_post();
                                $related_app_info = get_field('App_name_details');
                                $related_app_icon = get_field('app_icon');
                                $app_name = !empty($related_app_info['Persian_name_of_the_app']) ? esc_html($related_app_info['Persian_name_of_the_app']) : (!empty($related_app_info['English_name_of_the_app']) ? esc_html($related_app_info['English_name_of_the_app']) : get_the_title());
                                $icon_url = !empty($related_app_icon['url']) ? esc_url($related_app_icon['url']) : get_template_directory_uri() . '/images/temp/sibaneh-logo.png';
                                $icon_alt = !empty($related_app_icon['alt']) ? esc_attr($related_app_icon['alt']) : 'App Icon';
                        ?>
                                <div class="app-item">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo $icon_url; ?>" alt="<?php echo $icon_alt; ?>" class="Guaranteed-stability">
                                        <p><?php echo $app_name; ?></p>
                                    </a>
                                </div>
                            <?php
                            }
                            wp_reset_postdata();
                        } else {
                            // Fallback if no related apps are found
                            for ($i = 1; $i <= 6; $i++) {
                            ?>
                                <div class="app-item">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo.png" alt="Guaranteed-stability" class="Guaranteed-stability">
                                    <p>happn: Dating, Chat &amp; Meet</p>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>


    <?php endwhile;
    endif; ?>
</div>