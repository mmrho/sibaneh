<?php
function sibaneh_api_request($endpoint, $data) {
    $url = "https://api.sibaneh.punasdev.ir/api/" . $endpoint;
    
    $args = array(
        'body'        => json_encode($data),
        'headers'     => array(
            'Content-Type' => 'application/json-patch+json',
            'Accept'       => '*/*'
        ),
        'method'      => 'POST',
        'data_format' => 'body',
        'timeout'     => 15
    );
    
    return wp_remote_post($url, $args);
}

function sibaneh_send_error($message, $redirect = false) {
    wp_die(json_encode([
        'status' => 'error',
        'message' => $message,
        'redirect' => $redirect
    ]));
}

function sibaneh_send_success($data) {
    $response = array_merge(['status' => 'success'], $data);
    wp_die(json_encode($response));
}

function sibaneh_store_temp_data($phone, $data) {
    $unique_key = md5($phone . '_' . microtime());
    
    foreach ($data as $key => $value) {
        set_transient('sibaneh_' . $key . '_' . $unique_key, $value, 3 * MINUTE_IN_SECONDS);
    }
    
    setcookie('sibaneh_session_key', $unique_key, time() + 3 * MINUTE_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
    
    return $unique_key;
}

function sibaneh_get_temp_data($key) {
    if (!isset($_COOKIE['sibaneh_session_key'])) {
        return false;
    }
    
    $unique_key = sanitize_text_field($_COOKIE['sibaneh_session_key']);
    return get_transient('sibaneh_' . $key . '_' . $unique_key);
}

function sibaneh_increment_verify_attempts() {
    $attempts = sibaneh_get_temp_data('verify_attempts');
    $attempts = ($attempts === false) ? 1 : $attempts + 1;
    
    $unique_key = sanitize_text_field($_COOKIE['sibaneh_session_key']);
    set_transient('sibaneh_verify_attempts_' . $unique_key, $attempts, 3 * MINUTE_IN_SECONDS);
    
    return $attempts;
}

function sibaneh_clear_temp_data() {
    if (!isset($_COOKIE['sibaneh_session_key'])) {
        return;
    }
    
    $unique_key = sanitize_text_field($_COOKIE['sibaneh_session_key']);
    $prefixes = ['phone', 'hashId', 'remainingTime', 'login_time', 'verify_attempts', 'isRegistered'];
    
    foreach ($prefixes as $prefix) {
        delete_transient('sibaneh_' . $prefix . '_' . $unique_key);
    }
    
    setcookie('sibaneh_session_key', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
}

function sibaneh_process_api_response($response) {
    if (is_wp_error($response)) {
        sibaneh_send_error('خطا در ارتباط با سرور خارجی: ' . $response->get_error_message());
        return false;
    }
    
    $body = json_decode(wp_remote_retrieve_body($response));
    
    if (!isset($body) || !is_object($body)) {
        sibaneh_send_error('پاسخ نامعتبر از سرور دریافت شد!');
        return false;
    }
    
    return $body;
}

function sibaneh_create_or_update_user($phone, $customerId, $isRegistered, $token) {
    $user = get_user_by('login', $phone);
    
    if (!$user) {
        $random_password = wp_generate_password(16, true, true);
        
        $userdata = array(
            'user_login'      => $phone,
            'user_pass'       => $random_password,
            'role'            => 'subscriber',
            'display_name'    => $phone,
            'user_registered' => current_time('mysql')
        );
        
        $userID = wp_insert_user($userdata);
        
        if (is_wp_error($userID)) {
            sibaneh_send_error('خطا در ایجاد کاربر: ' . $userID->get_error_message());
            return false;
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
        update_user_meta($userID, 'sibaneh_last_login', current_time('mysql'));
    }
    
    return $userID;
}

function submitLoginFormCallback() {
    check_ajax_referer('wbs_check_nonce', 'security', true);

    $phone = WbsUtility::convertFaNum2EN(WbsUtility::inputClean($_POST['fields']['phone']));

    if (!WbsUtility::wbsCheckPhone($phone)) {
        sibaneh_send_error('شماره موبایل وارد شده صحیح نمی باشد!');
        return;
    }

    $user = get_user_by('login', $phone);
    $customerId = "";
    
    if ($user) {
        $customerId = $user->ID;
    }

    ob_start();
    require THEME_LIB_DIR . "login/template/verfiyForm.php";
    $verify_form_html = ob_get_clean();

    $data = array(
        "userName" => $phone,
        "lastPage" => "string",
        "customerId" => $customerId,
        "referer" => "string",
        "service" => 1
    );
    
    $response = sibaneh_api_request('Account/Otp', $data);
    $body = sibaneh_process_api_response($response);
    
    if (!$body) {
        return;
    }

    if (isset($body->IsSuccess) && $body->IsSuccess == true) {
        $hashId = $body->Value->HashId;
        $userName = $body->Value->MobileNumber;
        $remainingTime = $body->Value->RemainingSecound;
        $isRegistered = $body->Value->IsRegistered;

        if ($remainingTime <= 0) {
            sibaneh_send_error('زمان ارسال کد به پایان رسیده است. لطفا دوباره تلاش کنید.');
            return;
        }

        $temp_data = [
            'phone' => $phone,
            'hashId' => $hashId,
            'remainingTime' => $remainingTime,
            'isRegistered' => $isRegistered,
            'login_time' => time(),
            'verify_attempts' => 0
        ];
        
        sibaneh_store_temp_data($phone, $temp_data);

        sibaneh_send_success([
            'message' => $body->Message,
            'content' => $verify_form_html,
            'hashId' => $hashId,
            'userName' => $userName,
            'remainingTime' => $remainingTime,
            'isRegistered' => $isRegistered
        ]);
    }

    sibaneh_send_error(isset($body->Message) ? $body->Message : 'خطا در دریافت اطلاعات از سرور خارجی!');
}

function submitVerifyFormCallback() {
    check_ajax_referer('wbs_check_nonce', 'security', true);

    $phone = sibaneh_get_temp_data('phone');
    $hashId = sibaneh_get_temp_data('hashId');
    $login_time = sibaneh_get_temp_data('login_time');
    
    if (!$phone || !$hashId) {
        sibaneh_send_error('کد منقضی شده است. لطفا دوباره تلاش کنید', true);
        return;
    }

    if ($login_time && (time() - $login_time > 120)) {
        sibaneh_clear_temp_data();
        sibaneh_send_error('کد منقضی شده است. لطفا دوباره تلاش کنید', true);
        return;
    }

    $attempts = sibaneh_increment_verify_attempts();
    if ($attempts > 5) {
        sibaneh_clear_temp_data();
        sibaneh_send_error('تعداد تلاش‌های ناموفق بیش از حد مجاز است. لطفا دوباره تلاش کنید.', true);
        return;
    }

    $code = WbsUtility::convertFaNum2EN(WbsUtility::inputClean($_POST['fields']['code']));

    $data = array(
        "hashId" => $hashId,
        "confirmCode" => $code
    );
    
    $response = sibaneh_api_request('Account/ConfirmCode', $data);
    $body = sibaneh_process_api_response($response);
    
    if (!$body) {
        return;
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
            
            $userID = sibaneh_create_or_update_user($phone, $customerId, $isRegistered, $token);
            if (!$userID) {
                return;
            }

            wp_set_current_user($userID);
            wp_set_auth_cookie($userID);

            setcookie('sibaneh_last_phone', $phone, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl());

            sibaneh_clear_temp_data();

            sibaneh_send_success([
                'url' => home_url(), 
                'message' => $body->Message,
                'isRegistered' => $isRegistered
            ]);
        } else {
            sibaneh_send_error('توکن نامعتبر است!');
        }
    } else {
        sibaneh_send_error(isset($body->Message) ? $body->Message : 'احراز هویت ناموفق بود!');
    }
}

add_action('wp_ajax_nopriv_submitLoginForm', 'submitLoginFormCallback');
add_action('wp_ajax_nopriv_submitVerifyForm', 'submitVerifyFormCallback');
