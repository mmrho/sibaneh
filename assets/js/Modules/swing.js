document.addEventListener('DOMContentLoaded', function() {
    // متغیرهای اصلی
    const revSliderContainer = document.querySelector('.rev-slider-effect');
    const bgImage = document.getElementById('appstore-background-img');
    const fgImage = document.getElementById('appstore-main-img');
    
    if (!revSliderContainer || !bgImage || !fgImage) return;
    
    // تنظیمات افکت - فقط جابجایی عمودی، بدون چرخش
    const settings = {
        bgTranslateMax: 80,    // حداکثر جابجایی تصویر پس‌زمینه (پیکسل)
        fgTranslateMax: 40,    // حداکثر جابجایی تصویر جلو (پیکسل)
        smoothFactor: 0.05      // فاکتور نرمی حرکت (0-1)
    };
    
    // متغیرهای حالت
    let isInView = false;
    let currentBgTranslateY = 0;
    let currentFgTranslateY = 0;
    let targetBgTranslateY = 0;
    let targetFgTranslateY = 0;
    let animationFrameId = null;
    
    // بررسی اینکه آیا المان در دید است
    function checkIfInView() {
        const rect = revSliderContainer.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        
        // المان حداقل تا نیمه در دید باشد
        isInView = 
            rect.top <= windowHeight * 0.8 && 
            rect.bottom >= windowHeight * 0.2;
    }
    
    // محاسبه مقادیر هدف برای انیمیشن
    function calculateTargetValues() {
        if (!isInView) return;
        
        // محاسبه موقعیت نسبی المان در صفحه (0 تا 1)
        const rect = revSliderContainer.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const elementCenter = rect.top + rect.height / 2;
        const viewportCenter = windowHeight / 2;
        
        // فاصله نسبی از مرکز صفحه (-1 تا 1)
        const relativePosition = (elementCenter - viewportCenter) / (windowHeight / 2);
        
        // محاسبه مقادیر هدف با توجه به موقعیت نسبی - فقط جابجایی عمودی
        targetBgTranslateY = relativePosition * settings.bgTranslateMax;
        targetFgTranslateY = -relativePosition * settings.fgTranslateMax;
    }
    
    // انیمیشن روان با استفاده از LERP (Linear Interpolation)
    function animate() {
        // محاسبه مقادیر جدید با استفاده از LERP
        currentBgTranslateY += (targetBgTranslateY - currentBgTranslateY) * settings.smoothFactor;
        currentFgTranslateY += (targetFgTranslateY - currentFgTranslateY) * settings.smoothFactor;
        
        // اعمال ترنسفورم‌ها - فقط جابجایی عمودی
        bgImage.style.transform = `translateY(${currentBgTranslateY}px)`;
        fgImage.style.transform = `translate(-50%, -50%) translateY(${currentFgTranslateY}px)`;
        
        // ادامه انیمیشن
        animationFrameId = requestAnimationFrame(animate);
    }
    
    // تابع اصلی برای اسکرول
    function onScroll() {
        checkIfInView();
        calculateTargetValues();
        
        // شروع انیمیشن اگر در دید است و هنوز شروع نشده
        if (isInView && !animationFrameId) {
            animationFrameId = requestAnimationFrame(animate);
        } 
        // توقف انیمیشن اگر از دید خارج شده
        else if (!isInView && animationFrameId) {
            cancelAnimationFrame(animationFrameId);
            animationFrameId = null;
        }
    }
    
    // اضافه کردن event listener برای اسکرول
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    
    // اجرای اولیه
    onScroll();
  });
  