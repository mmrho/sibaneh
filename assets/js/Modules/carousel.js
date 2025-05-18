/* carousel-section js code */
const baseUrl = wbs_script.themeUrl;

const games = [
  {
    title: "Sneaky Sasquatch",
    category: "Adventure",
    image: baseUrl + "/images/temp/NBA-game-baner.jpg",
  },
  {
    title: "NBA 2K22",
    category: "Sports",
    image: baseUrl + "/images/temp/GTA-baner.jpeg",
  },
  {
    title: "Angry Birds",
    category: "Action",
    image: baseUrl + "/images/temp/CALLOFDUTY-baner.jpeg",
  },
  {
    title: "LEGO Star",
    category: "Strategy",
    image: baseUrl + "/images/temp/CALLOFDUTY-baner.jpeg",
  },
  {
    title: "Crossy Road",
    category: "Action",
    image: baseUrl + "/images/temp/GTA-baner.jpeg",
  },
];

function createGameCard(game) {
  return `
          <div class="game-card">
          <div class="game-image-container">
          <img src="${game.image}" alt="${game.title}" class="game-image">
          <div class="game-info">
          <div class="game-category">${game.category}</div>
          <div class="game-title">${game.title}</div>
          </div>
          <button class="game-button">دریافت اپلیکیشن</button>
          </div>
          </div>
          
          `;
}

function initializeTrack(trackId, isReverse = false) {
  const track = document.getElementById(trackId);
  const content = [...games, ...games, ...games]
    .map((game) => createGameCard(game))
    .join("");
  track.innerHTML = content;
  if (isReverse) {
    track.style.right = "0";
    track.style.left = "auto";
  }
  return track;
}

function animateTrack(track, isReverse = false) {
  const cardWidth = 316; // card width (250px) + margin-right (16px)
  const totalWidth = cardWidth * games.length;
  let position = 0;
  let isHovered = false;

  function moveTrack() {
    if (!isHovered) {
      position += 1;
      if (position >= totalWidth) {
        position = 0;
      }
      const translateValue = isReverse ? position : -position;
      track.style.transform = `translateX(${translateValue}px)`;
    }
  }

  const interval = setInterval(moveTrack, 50); // Smoother animation

  // Add event listeners for hover
  track.addEventListener("mouseenter", () => {
    isHovered = true;
  });

  track.addEventListener("mouseleave", () => {
    isHovered = false;
  });

  // Return the interval ID so it can be cleared if needed
  return interval;
}

// Initialize and animate all tracks
const track1 = initializeTrack("track1");
const track2 = initializeTrack("track2", true);
const track3 = initializeTrack("track3");
const track4 = initializeTrack("track4", true);
animateTrack(track1);
animateTrack(track2, true);
animateTrack(track3);
animateTrack(track4, true);






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
