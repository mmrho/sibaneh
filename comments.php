<?php

/**
 * The template for displaying comments with API integration
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get current post/app ID for API calls
$app_id = get_the_ID();

// Sample comments data (این داده‌ها بعداً از API خواهند آمد)
$sample_comments = [
    [
        'id' => 1,
        'author_name' => 'پیام کشفی',
        'title' => 'عالی و کاربردی',
        'rating' => 5,
        'date' => '۳ بهمن ۱۴۰۳',
        'content' => 'از قابلیت ویرایش عکسش لذت بردم، واقعاً عالیه و کاربردی هست. پیشنهاد میکنم حتماً امتحان کنید.',
        'likes' => 12,
        'dislikes' => 1,
        'user_liked' => false,
        'user_disliked' => false
    ],
    [
        'id' => 2,
        'author_name' => 'سارا احمدی',
        'title' => 'خوبه اما قابل بهبود',
        'rating' => 4,
        'date' => '۲ بهمن ۱۴۰۳',
        'content' => 'نرم‌افزار خوبیه ولی کمی سنگینه. امکانات خوبی داره اما رابط کاربری میتونه بهتر باشه.',
        'likes' => 8,
        'dislikes' => 3,
        'user_liked' => false,
        'user_disliked' => false
    ],
    [
        'id' => 3,
        'author_name' => 'محمد رضایی',
        'title' => 'فوق‌العاده!',
        'rating' => 5,
        'date' => '۱ بهمن ۱۴۰۳',
        'content' => 'فوق‌العاده! دقیقاً همون چیزی بود که دنبالش بودم. سرعت بالا و امکانات کامل.',
        'likes' => 15,
        'dislikes' => 0,
        'user_liked' => true,
        'user_disliked' => false
    ],
    [
        'id' => 4,
        'author_name' => 'مینا حسینی',
        'title' => 'قابلیت‌های خوب، قیمت بالا',
        'rating' => 3,
        'date' => '۳۰ دی ۱۴۰۳',
        'content' => 'قابلیت‌های خوبی داره اما قیمتش کمی بالاست. برای کارهای معمولی مناسبه.',
        'likes' => 5,
        'dislikes' => 2,
        'user_liked' => false,
        'user_disliked' => false
    ],
    [
        'id' => 5,
        'author_name' => 'علی موسوی',
        'title' => 'تجربه رضایت‌بخش',
        'rating' => 4,
        'date' => '۲۹ دی ۱۴۰۳',
        'content' => 'تجربه خوبی داشتم. سادگی کار باهاش عالیه و نتایج هم رضایت‌بخش بود.',
        'likes' => 9,
        'dislikes' => 1,
        'user_liked' => false,
        'user_disliked' => false
    ],
    [
        'id' => 6,
        'author_name' => 'فاطمه کریمی',
        'title' => 'عاشقش شدم!',
        'rating' => 5,
        'date' => '۲۸ دی ۱۴۰۳',
        'content' => 'عاشق این اپلیکیشن شدم! همه چیزش حرف نداره. به همه پیشنهاد میکنم.',
        'likes' => 18,
        'dislikes' => 0,
        'user_liked' => false,
        'user_disliked' => false
    ]
];
?>

<div id="comments" class="comments-area">

    <!-- Feedback Section -->
    <div class="F-B-section">
        <h3 class="F-B-title">این مقاله مفید بود؟</h3>
        <div class="F-B-buttons">
            <button class="feedback-btn feedback-yes" data-feedback="yes">
                <span>بله</span>
            </button>
            <button class="feedback-btn feedback-no" data-feedback="no">
                <span>خیر</span>
            </button>
        </div>
    </div>

    <!-- Comment Form Title -->
    <div class="comment-form-section">
        <button class="add-comment-btn" id="add-comment-btn">
            <span>ثبت دیدگاه و امتیاز</span>
        </button>
    </div>

    <!-- Comments Display Section -->
    <div class="comments-display-section">
        <div class="comments-container" id="comments-container">
            <div class="comments-wrapper" id="comments-wrapper">
                <?php foreach ($sample_comments as $comment): ?>
                    <div class="comment-card">
                        <div class="comment-header">
                            <div class="comment-author"><?php echo esc_html($comment['author_name']); ?></div>
                            <div class="comment-rating">
                                <?php
                                for ($i = 1; $i <= 5; $i++):
                                    $star_class = $i <= $comment['rating'] ? 'star-filled' : 'star-empty';
                                ?>
                                    <span class="star <?php echo $star_class; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="comment-title">
                            <div class="title"> <?php echo esc_html($comment['title']); ?></div>
                            <div class="comment-date"><?php echo esc_html($comment['date']); ?></div>
                        </div>
                        <div class="comment-content">
                            <?php
                            $content = esc_html($comment['content']);
                            if (mb_strlen($content) > 80) {
                                $short_content = mb_substr($content, 0, 80);
                                echo $short_content;
                                echo ' <a href="' . esc_url(get_permalink() . 'comments/') . '" class="read-more-link">بیشتر</a>';
                            } else {
                                echo $content;
                            }
                            ?>
                        </div>
                        <div class="comment-footer">
                            <div class="comment-actions">
                                <button class="dislike-btn <?php echo $comment['user_disliked'] ? 'active' : ''; ?>" data-comment-id="<?php echo $comment['id']; ?>">
                                    👎 <span><?php echo $comment['dislikes']; ?></span>
                                </button>
                                <button class="like-btn <?php echo $comment['user_liked'] ? 'active' : ''; ?>" data-comment-id="<?php echo $comment['id']; ?>">
                                    👍 <span><?php echo $comment['likes']; ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- More Comments Link -->
    <div class="more-comments-section">
        <a href="<?php echo esc_url(get_permalink() . 'comments/'); ?>" class="more-comments-link">
            مشاهده دیدگاه‌های بیشتر
        </a>
    </div>

</div>

<!-- Comment Popup Modal -->
<div id="comment-modal" class="comment-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>ثبت دیدگاه و امتیاز</h3>
            <button class="close-modal" id="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="comment-form">
                <div class="rating-section">
                    <label>امتیاز شما:</label>
                    <div class="star-rating" id="star-rating">
                        <span class="star" data-rating="1">★</span>
                        <span class="star" data-rating="2">★</span>
                        <span class="star" data-rating="3">★</span>
                        <span class="star" data-rating="4">★</span>
                        <span class="star" data-rating="5">★</span>
                    </div>
                </div>
                <div class="comment-title-section">
                    <label for="comment-title">عنوان دیدگاه:</label>
                    <input type="text" id="comment-title" name="title" placeholder="عنوان دیدگاه خود را بنویسید..." maxlength="20" required>
                    <div class="character-count">
                        <span id="title-char-count">0</span>/20 کاراکتر
                    </div>
                </div>
                <div class="comment-input-section">
                    <label for="comment-text">دیدگاه شما:</label>
                    <textarea id="comment-text" name="comment" placeholder="دیدگاه خود را بنویسید..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" id="cancel-comment">انصراف</button>
                    <button type="submit" class="btn-submit">ثبت دیدگاه</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const appId = <?php echo json_encode($app_id); ?>;
        let currentRating = 0;

        // نمونه داده‌های کامنت (بعداً از API خواهد آمد)
        const sampleComments = <?php echo json_encode($sample_comments); ?>;

        // Feedback buttons
        document.querySelectorAll('.feedback-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const feedback = this.dataset.feedback;
                sendFeedback(feedback);
            });
        });

        // Add comment button
        document.getElementById('add-comment-btn').addEventListener('click', function() {
            <?php if (is_user_logged_in()): ?>
                document.getElementById('comment-modal').classList.add('active');
            <?php else: ?>
                window.location.href = '<?php echo wp_login_url(get_permalink()); ?>';
            <?php endif; ?>
        });

        // Modal close buttons
        document.getElementById('close-modal').addEventListener('click', closeModal);
        document.getElementById('cancel-comment').addEventListener('click', closeModal);

        // Close modal when clicking outside
        document.getElementById('comment-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Star rating
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                currentRating = parseInt(this.dataset.rating);
                updateStarDisplay();
            });

            star.addEventListener('mouseover', function() {
                const rating = parseInt(this.dataset.rating);
                highlightStars(rating);
            });
        });

        document.getElementById('star-rating').addEventListener('mouseleave', function() {
            updateStarDisplay();
        });

        // Character counter for title
        const titleInput = document.getElementById('comment-title');
        const charCountSpan = document.getElementById('title-char-count');

        titleInput.addEventListener('input', function() {
            const currentLength = this.value.length;
            charCountSpan.textContent = currentLength;

            // تغییر رنگ شمارنده نزدیک به حد مجاز
            if (currentLength >= 18) {
                charCountSpan.style.color = '#dc3545';
            } else if (currentLength >= 15) {
                charCountSpan.style.color = '#ffa500';
            } else {
                charCountSpan.style.color = '#666';
            }
        });

        // Comment form submission
        document.getElementById('comment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            submitComment();
        });

        // Touch scroll for mobile - بهبود یافته
        let isDown = false;
        let startX;
        let scrollLeft;
        const slider = document.getElementById('comments-wrapper');

        // Mouse events
        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
            e.preventDefault();
        });

        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
        });

        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('active');
        });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });

        // Touch events for mobile
        let touchStartX = 0;
        let touchScrollLeft = 0;

        slider.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].pageX;
            touchScrollLeft = slider.scrollLeft;
        }, {
            passive: true
        });

        slider.addEventListener('touchmove', (e) => {
            if (!touchStartX) return;
            const x = e.touches[0].pageX;
            const walk = (touchStartX - x) * 1.5;
            slider.scrollLeft = touchScrollLeft + walk;
        }, {
            passive: true
        });

        slider.addEventListener('touchend', () => {
            touchStartX = 0;
        });

        // Like/Dislike functionality
        document.querySelectorAll('.like-btn, .dislike-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const commentId = this.dataset.commentId;
                const type = this.classList.contains('like-btn') ? 'like' : 'dislike';
                toggleLike(commentId, type, this);
            });
        });

        function sendFeedback(feedback) {
            // موقتاً پیام موفقیت نمایش داده می‌شود
            // بعداً با API واقعی جایگزین خواهد شد
            showMessage('نظر شما ثبت شد. متشکریم!');

            // غیرفعال کردن دکمه‌های فیدبک
            document.querySelectorAll('.feedback-btn').forEach(btn => {
                btn.disabled = true;
                if (btn.dataset.feedback === feedback) {
                    btn.classList.add('selected');
                }
            });
            // در آینده این کد با API واقعی جایگزین خواهد شد:
            /*
            fetch('/wp-json/api/v1/feedback', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                },
                body: JSON.stringify({
                    app_id: appId,
                    feedback: feedback
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('نظر شما ثبت شد. متشکریم!');
                    document.querySelectorAll('.feedback-btn').forEach(btn => {
                        btn.disabled = true;
                        if (btn.dataset.feedback === feedback) {
                            btn.classList.add('selected');
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error sending feedback:', error);
                showMessage('خطا در ثبت نظر. لطفاً دوباره تلاش کنید.');
            });
            */
        }

        function submitComment() {
            const commentText = document.getElementById('comment-text').value.trim();
            const commentTitle = document.getElementById('comment-title').value.trim();

            if (!commentText || !commentTitle || currentRating === 0) {
                showMessage('لطفاً امتیاز، عنوان و دیدگاه خود را وارد کنید.');
                return;
            }

            // موقتاً پیام موفقیت و بستن مودال
            showMessage('دیدگاه شما با موفقیت ثبت شد!');
            closeModal();

            // در آینده این کد با API واقعی جایگزین خواهد شد:
            /*
            fetch('/wp-json/api/v1/comments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                },
                body: JSON.stringify({
                    app_id: appId,
                    title: commentTitle,
                    content: commentText,
                    rating: currentRating
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('دیدگاه شما با موفقیت ثبت شد!');
                    closeModal();
                    // بارگیری مجدد کامنت‌ها
                } else {
                    showMessage(data.message || 'خطا در ثبت دیدگاه');
                }
            })
            .catch(error => {
                console.error('Error submitting comment:', error);
                showMessage('خطا در ثبت دیدگاه. لطفاً دوباره تلاش کنید.');
            });
            */
        }

        function toggleLike(commentId, type, buttonElement) {
            // شبیه‌سازی تغییر وضعیت لایک/دیسلایک
            const isActive = buttonElement.classList.contains('active');
            const countSpan = buttonElement.querySelector('span');
            let currentCount = parseInt(countSpan.textContent);

            if (isActive) {
                // حذف لایک/دیسلایک
                buttonElement.classList.remove('active');
                countSpan.textContent = currentCount - 1;
            } else {
                // اضافه کردن لایک/دیسلایک
                buttonElement.classList.add('active');
                countSpan.textContent = currentCount + 1;

                // حذف وضعیت مخالف (اگر لایک زد، دیسلایک برداشته شود)
                const oppositeBtn = type === 'like' ?
                    buttonElement.parentElement.querySelector('.dislike-btn') :
                    buttonElement.parentElement.querySelector('.like-btn');

                if (oppositeBtn.classList.contains('active')) {
                    oppositeBtn.classList.remove('active');
                    const oppositeCount = oppositeBtn.querySelector('span');
                    oppositeCount.textContent = parseInt(oppositeCount.textContent) - 1;
                }
            }

            // در آینده این کد با API واقعی جایگزین خواهد شد:
            /*
            fetch(`/wp-json/api/v1/comments/${commentId}/${type}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // بروزرسانی UI با اعداد جدید
                }
            })
            .catch(error => {
                console.error('Error toggling like:', error);
            });
            */
        }
        function closeModal() {
            document.getElementById('comment-modal').classList.remove('active');
            document.getElementById('comment-text').value = '';
            document.getElementById('comment-title').value = '';
            currentRating = 0;
            updateStarDisplay();
        }

        function updateStarDisplay() {
            document.querySelectorAll('.star').forEach((star, index) => {
                if (index < currentRating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        function highlightStars(rating) {
            document.querySelectorAll('.star').forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('hover');
                } else {
                    star.classList.remove('hover');
                }
            });
        }

        function showMessage(message) {
            // ایجاد و نمایش پیام toast
            const toast = document.createElement('div');
            toast.className = 'toast-message';
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }
    });
</script>