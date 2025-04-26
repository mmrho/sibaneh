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

    $_SESSION['phone'] = $phone;

    ob_start();
    require THEME_LIB_DIR . "login/template/verfiyForm.php";

    $url = "https://sibanehservice.supriz.ir/api/Account/Otp";
    $data = array(
        "userName" => $phone,
        "lastPage" => "string",
        "customerId" => "string",
        "referer" => "string"
    );

    $args = array(
        'body'        => json_encode($data),
        'headers'     => array(
            'Content-Type' => 'application/json-patch+json',
            'Accept'       => '*/*'
        ),
        'method'      => 'POST',
        'data_format' => 'body'
    );
    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        wp_die(json_encode(['status' => 'error', 'message' => 'خطا در ارتباط با سرور خارجی!']));
    }

    $body = json_decode(wp_remote_retrieve_body($response));

    if (isset($body->IsSuccess) && $body->IsSuccess == true) {
       
        $hashId = $body->Value->HashId;
        $userName = $body->Value->MobileNumber;
        $remainingTime = $body->Value->RemainingSecound;
        $isRegistered = $body->Value->IsRegistered; 

        
        $_SESSION['hashId'] = $hashId;
        $_SESSION['remainingTime'] = $remainingTime;
        $_SESSION['isRegistered'] = $isRegistered; 

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

    if (!isset($_SESSION['phone'])) {
        wp_die(json_encode(['status' => 'error', 'message' => 'کد منقضی شده است. لطفا دوباره تلاش کنید']));
    }

    $code = WbsUtility::convertFaNum2EN(WbsUtility::inputClean($_POST['fields']['code']));
    $phone = $_SESSION['phone'];
    $hashId = $_SESSION['hashId'];

    $url = "https://sibanehservice.supriz.ir/api/Account/ConfirmCode";
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
        'data_format' => 'body'
    );

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        wp_die(json_encode(['status' => 'error', 'message' => 'خطا در ارتباط با سرور خارجی!']));
    }

    $body = json_decode(wp_remote_retrieve_body($response));

    if (isset($body->IsSuccess) && $body->IsSuccess == true) {
        $customerId = $body->Value->CustomerId;
        $userName = $body->Value->UserName;
        $token = $body->Value->Token;
        $isRegistered = $body->Value->IsRegistered;

        // اعتبارسنجی توکن دریافتی
        if (isset($token)) {
            $_SESSION['external_user'] = [
                'user_token' => $token,
                'user_login' => $phone,
                'customer_id' => $customerId,
                'is_registered' => $isRegistered
            ];
            
            $user = get_user_by('login', $phone);
            if (!$user) {
                $userID = wp_create_user($phone, '');
                // ذخیره اطلاعات کاربر در متادیتا
                update_user_meta($userID, 'sibaneh_customer_id', $customerId);
                update_user_meta($userID, 'sibaneh_is_registered', $isRegistered);
            } else {
                $userID = $user->ID;
                // بروزرسانی اطلاعات کاربر
                update_user_meta($userID, 'sibaneh_customer_id', $customerId);
                update_user_meta($userID, 'sibaneh_is_registered', $isRegistered);
            }

            wp_set_current_user($userID);
            wp_set_auth_cookie($userID);

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