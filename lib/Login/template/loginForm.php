<form id="loginForm" class="login-form" method="post">
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
            <label for="mobile">
                <div class="input-container">
                    <input dir="ltr" class="input" type="text" inputmode="numeric" maxlength="11" autocomplete="off" id="mobile" name="mobile" placeholder="لطفا شماره موبایل خود را وارد کنید" />
                    <span class="input-icon"> | <i class="icon-iphone-icon"></i></span>
                </div>
            </label>
           
        </div>
    </section>
    <section class="loginRow">
        <div class="loginButton">
            <button class="login-btn" type="submit">ورود به حساب کاربری</button>
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
</form>