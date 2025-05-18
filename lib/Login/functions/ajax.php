<?php
function submitLoginFormCallback()
{
    if (!session_id()) {
        session_start();
    }

    // Verify nonce for security
    check_ajax_referer('wbs_check_nonce', 'security', true);

    $phone = WbsUtility::convertFaNum2EN(WbsUtility::inputClean($_POST['fields']['phone']));

    if (!WbsUtility::wbsCheckPhone($phone)) {
        wp_die(json_encode(['status' => 'error', 'message' => 'شماره موبایل وارد شده صحیح نمی باشد!']));
    }

   
    $user = get_user_by('login', $phone);
    $customerId = "";
    
    if ($user) {
        $customerId = $user->ID;
    }

    $_SESSION['phone'] = $phone;
    $_SESSION['verify_attempts'] = 0;

    ob_start();
    require THEME_LIB_DIR . "login/template/verfiyForm.php";

    $url = "https://api.sibaneh.punasdev.ir/api/Account/Otp";
    $data = array(
        "userName" => $phone,
        "lastPage" => "string",
        "customerId" => $customerId,
        "referer" => "string",
        "service" => 1
    );

    $args = array(
        'body'        => json_encode($data),
        'headers'     => array(
            'Content-Type' => 'application/json-patch+json',
            'Accept'       => '*/*'
        ),
        'method'      => 'POST',
        'data_format' => 'body',
        'timeout'     => 15 // 15 seconds
    );
    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log('خطای API سیبانه: ' . $error_message);
        wp_die(json_encode([
            'status' => 'error', 
            'message' => 'خطا در ارتباط با سرور: ' . $error_message,
            'code' => $response->get_error_code()
        ]));
    }

    $body = json_decode(wp_remote_retrieve_body($response));

    if (!isset($body) || !is_object($body)) {
        wp_die(json_encode(['status' => 'error', 'message' => 'پاسخ نامعتبر از سرور دریافت شد!']));
    }

    if (isset($body->IsSuccess) && $body->IsSuccess == true) {
        $hashId = $body->Value->HashId;
        $userName = $body->Value->MobileNumber;
        $remainingTime = $body->Value->RemainingSecound;
        $isRegistered = $body->Value->IsRegistered;

    
        if ($remainingTime <= 0) {
            wp_die(json_encode(['status' => 'error', 'message' => 'زمان ارسال کد به پایان رسیده است. لطفا دوباره تلاش کنید.']));
        }


        $_SESSION['hashId'] = $hashId;
        $_SESSION['remainingTime'] = $remainingTime;
        $_SESSION['isRegistered'] = $isRegistered;
        $_SESSION['login_time'] = time(); 

        wp_die(json_encode([
            'status' => 'success',
            'message' => $body->Message,
            'content' => ob_get_clean(),
            'hashId' => $hashId,
            'userName' => $userName,
            'remainingTime' => $remainingTime,
            'isRegistered' => $isRegistered
        ]));
    }

    wp_die(json_encode([
        'status' => 'error',
        'message' => isset($body->Message) ? $body->Message : 'خطا در دریافت اطلاعات از سرور خارجی!'
    ]));
}




function submitVerifyFormCallback()
{
    if (!session_id()) {
        session_start();
    }

    check_ajax_referer('wbs_check_nonce', 'security', true);
    $code = WbsUtility::convertFaNum2EN(WbsUtility::inputClean($_POST['fields']['code']));
    $phone = $_SESSION['phone'];
    $hashId = $_SESSION['hashId'];
   
    if (!isset($_SESSION['phone']) || !isset($_SESSION['hashId'])) {
        wp_die(json_encode(['status' => 'error', 'message' => 'کد منقضی شده است. لطفا دوباره تلاش کنید']));
    }

 
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 120)) {

        unset($_SESSION['phone']);
        unset($_SESSION['hashId']);
        unset($_SESSION['remainingTime']);
        unset($_SESSION['login_time']);
        wp_die(json_encode(['status' => 'error', 'message' => 'کد منقضی شده است. لطفا دوباره تلاش کنید']));
    }

 
    // محدودیت تعداد تلاش‌ها
    if (!isset($_SESSION['verify_attempts'])) {
        $_SESSION['verify_attempts'] = 0;
    }
    $_SESSION['verify_attempts']++;
    if ($_SESSION['verify_attempts'] > 5) {
        unset($_SESSION['phone']);
        unset($_SESSION['hashId']);
        unset($_SESSION['remainingTime']);
        unset($_SESSION['login_time']);
        unset($_SESSION['verify_attempts']);
        wp_die(json_encode([
            'status' => 'error', 
            'message' => 'تعداد تلاش‌های ناموفق بیش از حد مجاز است. لطفا دوباره تلاش کنید.',
            'redirect' => true,
            'redirect_url' => home_url('/login/') // آدرس صفحه لاگین را اینجا قرار دهید
        ]));
    }

    $url = "https://api.sibaneh.punasdev.ir/api/Account/ConfirmCode";
    $data = array(
        "hashId" => $hashId,
        "confirmCode" => $code
    );

    $args = array(
        'body'        => json_encode($data),
        'headers'     => array(
            'Content-Type' => 'application/json-patch+json',
            'Accept'       => '*/*'
        ),
        'method'      => 'POST',
        'data_format' => 'body',
        'timeout'     => 15 // 15 seconds
    );

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        wp_die(json_encode(['status' => 'error', 'message' => 'خطا در ارتباط با سرور خارجی: ' . $response->get_error_message()]));
    }

    $body = json_decode(wp_remote_retrieve_body($response));

    
    if (!isset($body) || !is_object($body)) {
        wp_die(json_encode(['status' => 'error', 'message' => 'پاسخ نامعتبر از سرور دریافت شد!']));
    }

    if (isset($body->IsSuccess) && $body->IsSuccess == true) {
        $customerId = $body->Value->CustomerId;
        $userName = $body->Value->UserName;
        $token = $body->Value->Token;
        $isRegistered = $body->Value->IsRegistered;

       
        if (isset($token)) {
            $_SESSION['external_user'] = [
                'user_token' => $token,
                'user_login' => $phone,
                'customer_id' => $customerId,
                'is_registered' => $isRegistered
            ];
            
            $user = get_user_by('login', $phone);
            if (!$user) {
                // ایجاد رمز عبور تصادفی امن
                $random_password = wp_generate_password(16, true, true);
                
                // ایجاد کاربر با تعیین نقش
                $userdata = array(
                    'user_login'    => $phone,
                    'user_pass'     => $random_password,
                    'role'          => 'subscriber',
                    'display_name'  => $phone,
                    'user_registered' => current_time('mysql')
                );
                $userID = wp_insert_user($userdata);
                
                if (is_wp_error($userID)) {
                    wp_die(json_encode(['status' => 'error', 'message' => 'خطا در ایجاد کاربر: ' . $userID->get_error_message()]));
                }
                update_user_meta($userID, 'sibaneh_api_customer_id', $customerId);
                update_user_meta($userID, 'sibaneh_is_registered', $isRegistered);
                update_user_meta($userID, 'sibaneh_token', $token);
                update_user_meta($userID, 'sibaneh_registration_date', current_time('mysql'));
            } else {
                $userID = $user->ID;
                update_user_meta($userID, 'sibaneh_api_customer_id', $customerId);
                update_user_meta($userID, 'sibaneh_is_registered', $isRegistered);
                update_user_meta($userID, 'sibaneh_token', $token);
                update_user_meta($userID, 'sibaneh_last_login', current_time('mysql')); // ثبت زمان آخرین ورود
            }

            wp_set_current_user($userID);
            wp_set_auth_cookie($userID);

           
            unset($_SESSION['phone']);
            unset($_SESSION['hashId']);
            unset($_SESSION['remainingTime']);
            unset($_SESSION['login_time']);
            unset($_SESSION['verify_attempts']);

            
          /*  if (isset($_POST['remember_phone']) && $_POST['remember_phone'] == 'true') {
                $cookie_path = defined('COOKIEPATH') ? COOKIEPATH : '/';
                $cookie_domain = defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : '';
                $secure = function_exists('is_ssl') ? is_ssl() : false;

                setcookie('sibaneh_last_phone', $phone, time() + 30 * DAY_IN_SECONDS, $cookie_path, $cookie_domain, $secure);
            }*/

            wp_die(json_encode([
                'status' => 'success', 
                'url' => home_url(), 
                'message' => $body->Message,
                'isRegistered' => $isRegistered
            ]));
        } else {
            wp_die(json_encode(['status' => 'error', 'message' => 'توکن نامعتبر است!']));
        }
    }

    wp_die(json_encode([
        'status' => 'error', 
        'message' => isset($body->Message) ? $body->Message : 'احراز هویت ناموفق بود!'
    ]));
}

add_action('wp_ajax_nopriv_submitLoginForm', 'submitLoginFormCallback');
add_action('wp_ajax_nopriv_submitVerifyForm', 'submitVerifyFormCallback');