<form id="verifyForm" method="post">
    <fieldset>
        <label for="mobile">کد تایید ارسال شده به شماره همراه <?php echo $_SESSION['phone']; ?> را وارد نمایید:</label>
        <span class="input-icon"><i class="icon-mobile"></i></span>
        <input dir="ltr" class="input" type="text"  inputmode="numeric" maxlength="5" autocomplete="off" id="code" name="code" />
    </fieldset>
    <fieldset>
        <button type="submit">بررسی کد تایید</button>
    </fieldset>
    <div class="text-center">
        <span class="timer">
            02:00
        </span>
    </div>
</form>