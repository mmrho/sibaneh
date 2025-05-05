<?php get_header(); ?>
<!-- Main -->
<main id="site-main">
    <?php
    // require_once THEME_TEMPLATE . 'home/slider.php';
    ?>
    <div class="container-fluid">
        <section class="hero-section">
            <div class="hero-section-container">
                <a href="#" class="hero-section-logo-container">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-blue.png" alt="sibaneh-logo-blue" class="hero-section-logo">
                    <p class="hero-section-logo-subtitle">اپ‌استور سیبانه</p>
                </a>
                <h2>استانداردی منحصر بفرد برای آیفون و آیپد در ایران</h2>
                <p class="hero-section-subtitle">دسترسی امن و آسان به هزاران اپلیکیشن اورجینال iOS</p>
                <a href="#" class="hero-section-learn-more">آشنایی با اپ‌استور سیبانه</a>
                <div class="hero-section-img-container">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/temp/appstore-background-img.png" alt="appstore-background-img"
                        class="hero-section-background-img" id="background-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/temp/appstore-main-img.png" alt="appstore-main-img"
                        class="hero-section-img" id="foreground-image">
                </div>
            </div>
        </section>
        <section class="card-section">
            <div class="card-section-container">
                <div class="row">
                    <div class="col-md-6 my-3">
                        <div class="card-section-info">
                            <div class="card-section-logo-container">
                                <img class="card-section-logo" src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-blue.png"
                                    alt="sibaneh-logo">
                                <h6 class="card-section-logo-title">اپ‌استور سیبانه</h6>
                            </div>
                            <p class="card-section-subtitle">امنیت فداشدنی نیست.</p>
                            <h3 class="card-section-title">امن‌ترین روش نصب نرم‌افزارهای اورجینال را تجربه کنید.</h3>
                            <a href="#" class="card-section-learn-more">بیشتر بدانید</a>
                            <button class="card-section-btn">ورود به اپ‌استور سیبانه</button>
                            <div class="card-section-img-container">
                                <img class="card-section-img" src="<?php echo get_template_directory_uri(); ?>/images/temp/person-with-iphone.png"
                                    alt="person-with-iphone">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 my-3">
                        <div class="card-section-info">
                            <div class="card-section-logo-container">
                                <img class="card-section-logo" src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-blue.png"
                                    alt="sibaneh-logo-blue">
                                <h6 class="card-section-logo-title">اپ‌استور سیبانه</h6>
                            </div>
                            <p class="card-section-subtitle">لذت استفاده از امکانات را بچشید.</p>
                            <h3 class="card-section-title">محدودیت‌های نرم‌افزاری آیفون را برای ایرانیان شکسته‌ایم.
                            </h3>
                            <a href="#" class="card-section-learn-more">بیشتر بدانید</a>
                            <button class="card-section-btn">ورود به اپ‌استور سیبانه</button>
                            <div class="card-section-img-container">
                                <img class="card-section-img" src="<?php echo get_template_directory_uri(); ?>/images/temp/flags.png" alt="flags">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="slider-section">
            <div class="slider-container">
                <div class="slide active">
                    <img class="slide-bg" src="<?php echo get_template_directory_uri(); ?>/images/temp/NBA-game-baner.jpg" alt="NBA 2K21">
                    <div class="slide-content">
                        <h2>NBA 2K21<br>Arcade Edition</h2>
                        <p>Sports</p>
                        <a href="#" class="download-btn">دریافت اپلیکیشن</a>
                    </div>
                </div>
                <div class="slide">
                    <img class="slide-bg" src="<?php echo get_template_directory_uri(); ?>/images/temp/GTA-baner.jpeg" alt="NBA 2K21 Gameplay">
                    <div class="slide-content">
                        <h2>Experience Next-Gen<br>Basketball</h2>
                        <p>Sports</p>
                        <a href="#" class="download-btn">دریافت اپلیکیشن</a>
                    </div>
                </div>
                <div class="slide">
                    <img class="slide-bg" src="<?php echo get_template_directory_uri(); ?>/images/temp/CALLOFDUTY-baner.jpeg" alt="NBA 2K21 Features">
                    <div class="slide-content">
                        <h2>Ultimate Gaming<br>Experience</h2>
                        <p>Sports</p>
                        <a href="#" class="download-btn">دریافت اپلیکیشن</a>
                    </div>
                </div>
                <div class="slider-nav">
                    <button class="nav-btn next"><i class="icon-right-open"></i></button>
                    <button class="nav-btn prev"><i class="icon-left-open"></i></button>
                </div>
                <button class="play-btn"><i class="icon-play-in-circle"></i></button>
            </div>
        </section>
        <section class="carousel-section">
            <div class="carousel-container">
                <div class="carousel-row">
                    <div class="carousel-track" id="track1"></div>
                </div>
                <div class="carousel-row">
                    <div class="carousel-track" id="track2"></div>
                </div>
                <div class="carousel-row">
                    <div class="carousel-track" id="track3"></div>
                </div>
            </div>
            <button class="carousel-section-button">مشاهده همه برنامه‌ها</button>
        </section>
        <section class="hero-section pink-background">
            <div class="hero-section-container">
                <div class="wave-container">
                    <canvas id="waveCanvas"></canvas>
                </div>
                <a href="#" class="hero-section-logo-container">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-pink.png" alt="sibaneh-logo-pink"
                        class="hero-section-logo">
                    <p class="hero-section-logo-subtitle">مک‌استور سیبانه</p>
                </a>
                <h2>قدرتمندترین مک‌استور ایرانی را هم اکنون تجربه کنید</h2>
                <p class="hero-section-subtitle">دسترسی آسان به نرم‌افزارهای مک به همراه آموزش‌های جامع نصب و
                    استفاده</p>
                <a href="https://www.apple.com/" class="hero-section-learn-more">آشنایی با مک‌استور سیبانه</a>
                <img src="<?php echo get_template_directory_uri(); ?>/images/temp/macstore-main-img.png" alt="macstore-main-img" class="hero-section-img">
            </div>
        </section>
        <section class="card-section pink-background">
            <div class="card-section-container">
                <div class="row">
                    <div class="col-md-6 my-3">
                        <div class="card-section-info">
                            <div class="card-section-logo-container">
                                <img class="card-section-logo" src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-pink.png"
                                    alt="sibaneh-logo">
                                <h6 class="card-section-logo-title">مک‌استور سیبانه</h6>
                            </div>
                            <p class="card-section-subtitle">همانند حرفه‌ای‌ها باشید.</p>
                            <h3 class="card-section-title">حرفه‌ای‌ترین نرم‌افزارها را بر روی مک‌بوک خود داشته
                                باشید.</h3>
                            <a href="#" class="card-section-learn-more">بیشتر بدانید</a>
                            <button class="card-section-btn pink">ورود به مک‌استور سیبانه</button>
                            <div class="card-section-img-container">
                                <img class="card-section-img" src="<?php echo get_template_directory_uri(); ?>/images/temp/macstore-icon-1.png"
                                    alt="macstore-icon-1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 my-3">
                        <div class="card-section-info">
                            <div class="card-section-logo-container">
                                <img class="card-section-logo" src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-pink.png"
                                    alt="sibaneh-logo-blue">
                                <h6 class="card-section-logo-title">مک‌استور سیبانه</h6>
                            </div>
                            <p class="card-section-subtitle">جامع‌ترین آموزش‌ها را دریافت کنید.</p>
                            <h3 class="card-section-title">کامل‌ترین آموزش نصب و استفاده از لب‌تاپ‌های اپل و مک را
                                دریافت کنید.</h3>
                            <a href="#" class="card-section-learn-more">بیشتر بدانید</a>
                            <button class="card-section-btn pink">ورود به مک‌استور سیبانه</button>
                            <div class="card-section-img-container">
                                <img class="card-section-img" src="<?php echo get_template_directory_uri(); ?>/images/temp/macstore-icon-2.png"
                                    alt="macstore-icon-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="carousel-section pink-background">
            <div class="carousel-container">
                <div class="carousel-row">
                    <div class="carousel-track" id="track4"></div>
                </div>
            </div>
            <button class="carousel-section-button pink-button">مشاهده همه برنامه‌ها</button>
        </section>
        <section class="hero-section orange-background">
            <div class="hero-section-container">
                <div class="wave-container">
                    <canvas id="waveCanvas-1"></canvas>
                </div>
                <a href="#" class="hero-section-logo-container">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-orange.png" alt="sibaneh-logo-orange"
                        class="hero-section-logo">
                    <p class="hero-section-logo-subtitle">سرویس توسعه‌دهندگان</p>
                </a>
                <h2>به عنوان یک توسعه‌دهنده و برنامه‌نویس هم‌اکنون شروع کنید</h2>
                <p class="hero-section-subtitle">بدون محدودیت از اپلیکیشن خود در اپ‌استور اپل و اپ‌استور سیبانه کسب
                    درآمد کنید</p>
                <a href="https://www.apple.com/" class="hero-section-learn-more">آشنایی با سرویس توسعه‌دهندگان
                    سیبانه</a>
                <img src="<?php echo get_template_directory_uri(); ?>/images/temp/dev-main-img.png" alt="dev-main-img" class="hero-section-img">
            </div>
        </section>
        <section class="card-section orange-background">
            <div class="card-section-container">
                <div class="row">
                    <div class="col-md-6 my-3">
                        <div class="card-section-info">
                            <div class="card-section-logo-container">
                                <img class="card-section-logo" src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-orange.png"
                                    alt="sibaneh-logo">
                                <h6 class="card-section-logo-title">سرویس توسعه‌دهندگان سیبانه</h6>
                            </div>
                            <p class="card-section-subtitle">سرویس ساین و انتشار منحصربفرد</p>
                            <h3 class="card-section-title">پایدارترین پلتفرم انتشار اپلیکیشن را در سیبانه تجربه کنید
                            </h3>
                            <a href="#" class="card-section-learn-more">بیشتر بدانید</a>
                            <button class="card-section-btn orange">ورود به توسعه‌دهندگان</button>
                            <div class="card-section-img-container">
                                <img class="card-section-img" src="<?php echo get_template_directory_uri(); ?>/images/temp/dev-icon-1.png"
                                    alt="macstore-icon-1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 my-3">
                        <div class="card-section-info">
                            <div class="card-section-logo-container">
                                <img class="card-section-logo" src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-logo-orange.png"
                                    alt="sibaneh-logo-blue">
                                <h6 class="card-section-logo-title">سرویس توسعه‌دهندگان سیبانه</h6>
                            </div>
                            <p class="card-section-subtitle">امکان کسب درآمد هم‌زمان از اپ‌استور اپل و اپ‌استور
                                سیبانه</p>
                            <h3 class="card-section-title">انتشار اپلیکیشن شما در اپ‌استور اپل و اپ‌استور سیبانه
                            </h3>
                            <a href="#" class="card-section-learn-more">بیشتر بدانید</a>
                            <button class="card-section-btn orange">ورود به توسعه‌دهندگان</button>
                            <div class="card-section-img-container">
                                <img class="card-section-img" src="<?php echo get_template_directory_uri(); ?>/images/temp/dev-icon-2.png"
                                    alt="macstore-icon-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="about-section">
            <div class="about-container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <div class="text-center logo-container">
                            <div class="grid-lines"></div>
                            <h2 class="logo">Sibaneh</h2>
                            <div class="subtitle">اپ استور ایرانی نرم افزارهای اورجینال iOS</div>
                        </div>
                        <div class="content">
                            <p>در سال ۱۳۹۱ سیبانه متولد شد و ما از آن روز رویاهای بزرگی را در سر می پرورانیم. به
                                عنوان یکی از اولین اپ استورهای ایرانی همواره سعی کرده ایم خلاقانه ترین خدمات را در
                                اختیار کاربران ایرانی قرار دهیم.</p>

                            <p>فعالیت ما در ابتدا با عرضه اپلیکیشن‌های آیفون و آیپد آغاز شد و هم اکنون طیف وسیعی از
                                سرویس‌های مرتبط با محصولات اپل را شامل می شود. سیبانه به عنوان اپ استور امکان دسترسی
                                بدون محدودیت به نرم افزارهای آیفون را برای کاربران ایرانی فراهم میکند.</p>

                            <p>در اپ استور سیبانه شما می‌توانید به نسخه اورجینال و اصلی برنامه های دلخواهی دسترسی
                                داشته باشید، همچنین برنامه های پرطرفدار ایرانی آیفون مانند اسنپ، اسنپ رانندگان دیجی
                                کالا و نرم‌افزارهای همراه بانک برای آیفون که مورد تایید بانک ها است از طریق اپ استور
                                سیبانه قابل دانلود است.</p>
                        </div>
                        <div class="text-center">
                            <a href="#" class="link-custom">آشنایی با سیبانه</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<?php get_footer(); ?>