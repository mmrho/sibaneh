<?php
/**
 * The template for displaying comments
 */

if (!defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    return;
}

// Get commenter data
$commenter = wp_get_current_commenter();
$req = get_option('require_name_email');
$aria_req = ($req ? " aria-required='true'" : '');
$html_req = ($req ? " required='required'" : '');
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('یک نظر برای &ldquo;%1$s&rdquo;', 'textdomain'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx('%1$s نظر برای &ldquo;%2$s&rdquo;', '%1$s نظر برای &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'textdomain')),
                    number_format_i18n($comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'         => 'ol',
                'short_ping'    => true,
                'avatar_size'   => 42,
                'reply_text'    => __('پاسخ', 'textdomain'),
                'format'        => 'html5',
                'walker'        => null,
            ));
            ?>
        </ol>

        <?php
        // Comments pagination
        $prev_text = __('نظرات قدیمی‌تر', 'textdomain');
        $next_text = __('نظرات جدیدتر', 'textdomain');
        
        the_comments_pagination(array(
            'prev_text' => $prev_text,
            'next_text' => $next_text,
        ));

        // If comments are closed and there are comments
        if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
        ?>
            <p class="no-comments"><?php esc_html_e('نظرات بسته شده است.', 'textdomain'); ?></p>
        <?php
        endif;

    endif; // Check for have_comments().

    // Comment form
    if (comments_open()) :
        comment_form(array(
            'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
            'title_reply_after'  => '</h2>',
            'title_reply'        => __('نظر خود را بنویسید', 'textdomain'),
            'title_reply_to'     => __('پاسخ به %s', 'textdomain'),
            'cancel_reply_link'  => __('لغو پاسخ', 'textdomain'),
            'label_submit'       => __('ارسال نظر', 'textdomain'),
            'submit_button'      => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
            'submit_field'       => '<p class="form-submit">%1$s %2$s</p>',
            'format'             => 'html5',
            'comment_field'      => '<p class="comment-form-comment">
                <label for="comment">' . _x('نظر', 'noun', 'textdomain') . ' <span class="required">*</span></label>
                <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" aria-describedby="comment-notes"></textarea>
            </p>',
            'must_log_in'        => '<p class="must-log-in">' .
                sprintf(
                    __('برای ارسال نظر باید <a href="%s">وارد شوید</a>.', 'textdomain'),
                    wp_login_url(apply_filters('the_permalink', get_permalink()))
                ) . '</p>',
            'logged_in_as'       => '<p class="logged-in-as">' .
                sprintf(
                    __('شما به عنوان <a href="%1$s">%2$s</a> وارد شده‌اید. <a href="%3$s" title="خروج از این حساب">خروج؟</a>', 'textdomain'),
                    get_edit_user_link(),
                    $user_identity,
                    wp_logout_url(apply_filters('the_permalink', get_permalink()))
                ) . '</p>',
            'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . 
                __('آدرس ایمیل شما منتشر نخواهد شد.', 'textdomain') . '</span> ' .
                ($req ? __('فیلدهای الزامی علامت‌گذاری شده‌اند', 'textdomain') . ' <span class="required">*</span>' : '') .
                '</p>',
            'comment_notes_after'  => '',
            'id_form'            => 'commentform',
            'id_submit'          => 'submit',
            'class_form'         => 'comment-form',
            'class_submit'       => 'submit',
            'name_submit'        => 'submit',
            'fields'             => array(
                'author' => '<p class="comment-form-author">
                    <label for="author">' . __('نام', 'textdomain') . ($req ? ' <span class="required">*</span>' : '') . '</label>
                    <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" autocomplete="name"' . $aria_req . $html_req . ' />
                </p>',
                'email'  => '<p class="comment-form-email">
                    <label for="email">' . __('ایمیل', 'textdomain') . ($req ? ' <span class="required">*</span>' : '') . '</label>
                    <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email"' . $aria_req . $html_req . ' />
                </p>',
                'url'    => '<p class="comment-form-url">
                    <label for="url">' . __('وبسایت', 'textdomain') . '</label>
                    <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" autocomplete="url" />
                </p>',
                'cookies' => '<p class="comment-form-cookies-consent">
                    <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . (empty($commenter['comment_author_email']) ? '' : ' checked="checked"') . ' />
                    <label for="wp-comment-cookies-consent">' . __('اطلاعات مرا در مرورگر ذخیره کن تا دفعه بعد سریع‌تر فرم را پر کنم.', 'textdomain') . '</label>
                </p>',
            ),
        ));
    endif;
    ?>

</div><!-- #comments -->

<?php if (comments_open() || have_comments()) : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll to comment form
    const replyLinks = document.querySelectorAll('.comment-reply-link');
    replyLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            setTimeout(() => {
                document.getElementById('respond').scrollIntoView({
                    behavior: 'smooth'
                });
            }, 100);
        });
    });
    
    // Form validation
    const commentForm = document.getElementById('commentform');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            const comment = document.getElementById('comment').value.trim();
            if (comment.length < 10) {
                e.preventDefault();
                alert('نظر شما باید حداقل ۱۰ کاراکتر باشد.');
                return false;
            }
        });
    }
});
</script>
<?php endif; ?>