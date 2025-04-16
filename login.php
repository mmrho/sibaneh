<?php
/* Template Name: login */
get_header(); ?>

<main id="login-main">
    <div class="container loginContainer">
        <section class="loginRow">
            <div class="loginLogo">
                <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-login-logo.png" alt="سیبانه لوگو">
            </div>
        </section>
        <section class="loginRow">
            <div class="loginTitle">
                <h2>ورود | عضویت</h2>
            </div>
        </section>
        <section class="loginRow">
            <div class="loginInput">
                <input type="text" class="form-control" placeholder=".لطفا شماره موبایل خود را وارد کنید">
            </div>
        </section>
        <section class="loginRow">
            <div class="loginButton">
                <button class="login-btn" type="button">ورود به حساب کاربری</button>
            </div>
        </section>
        <section class="loginRow">
            <div class="loginAgreement">
                <label class="agreement-container">
                    <input type="checkbox" id="agreement-checkbox">
                    <span class="checkmark"></span>
                    <span class="agreement-text">با ورود و یا ثبت نام در سیبانه، شما قوانین استفاده از سایت و سرویس‌های سیبانه را می‌پذیرید.</span>
                </label>
            </div>
        </section>
    </div>
</main>
<footer>
    <section class="loginRow">
        <div class="loginFooterImage">
            <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-login-footerLogo.png" alt="سیبانه فوتر">
        </div>
    </section>
</footer>