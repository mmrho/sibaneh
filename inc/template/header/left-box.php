<div class="col-4 col-md-6 col-lg-2">
    <div class="left-box">
        <a href="<?php echo !is_user_logged_in() ? home_url('/login/') : home_url('/my-account/'); ?>">
            <i class="icon-user-2"></i>
        </a>
    </div>
</div>
</div>