<form id="SignUpForm" class="SignUpForm" method="post">
    <section class="SignUpRow">
        <div class="SignUpExit">
            <a href="javascript:history.back()">بازگشت <i class="icon-left-open"></i></a>
        </div>
    </section>

   
    <section class="SignUpRow">
        <div class="SignUpLogo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/temp/sibaneh-login-logo.png" alt="لوگوی سیبانه">
            </a>
        </div>
    </section>

   
    <section class="SignUpRow">
        <div class="SignUpTitle">
            <h2>ثبت نام مشخصات کاربر</h2>
        </div>
    </section>

   
    <section class="SignUpRow">
        <div class="SignUpInput">
            <fieldset class="fieldset">
                <legend>مشخصات فردی</legend>

                <div class="fieldset-item">
                    <label for="firstName">نام:</label>
                    <input type="text" id="firstName" name="firstName" placeholder="نام خود را وارد کنید" required>
                </div>

                <div class="fieldset-item">
                    <label for="lastName">نام خانوادگی:</label>
                    <input type="text" id="lastName" name="lastName" placeholder="نام خانوادگی خود را وارد کنید" required>
                </div>

                <div class="fieldset-item">
                    <label for="email">ایمیل:</label>
                    <input type="email" id="email" name="email" placeholder="ایمیل خود را وارد کنید" required>
                </div>
            </fieldset>
        </div>
    </section>

   
    <section class="SignUpRow">
        <div class="SignUpButton">
            <button class="SignUp-btn" type="submit">ثبت اطلاعات</button>
        </div>
    </section>
</form>
