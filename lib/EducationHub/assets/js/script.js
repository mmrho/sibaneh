document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.schema-faq-question');
    
    questions.forEach(question => {
        question.addEventListener('click', function() {
            // Toggle active class on question
            this.classList.toggle('active');
            
            // Toggle show class on answer
            const answer = this.nextElementSibling;
            answer.classList.toggle('show');
        });
    });
});

function manageBreadcrumb() {
  const breadcrumb = document.querySelector('.breadcrumb');
  const wrapper = breadcrumb.querySelector('.breadcrumb-wrapper');
  let items = Array.from(wrapper.querySelectorAll('span')); // همه spanهای Yoast

  // جدا کردن ۲ اول و ۲ آخر
  const firstTwo = items.slice(0, 2);
  const lastTwo = items.slice(-2);
  const middleItems = items.slice(2, -2);

  // پاک کردن wrapper
  wrapper.innerHTML = '';

  // اضافه کردن ۲ مسیر اول
  firstTwo.forEach(item => wrapper.appendChild(item));

  // اضافه کردن container برای مسیرهای وسط
  const middleContainer = document.createElement('span');
  middleContainer.className = 'middle-items';
  wrapper.appendChild(middleContainer);

  // اضافه کردن ۲ مسیر آخر
  lastTwo.forEach(item => wrapper.appendChild(item));

  // محاسبه عرض موجود
  const updateMiddleItems = () => {
    const containerWidth = wrapper.clientWidth;
    let totalWidth = 0;

    // عرض ۲ اول + ۲ آخر + separatorها
    firstTwo.concat(lastTwo).forEach(item => {
      totalWidth += item.offsetWidth + 10; // 10 برای gap/separator
    });

    const availableWidth = containerWidth - totalWidth - 20; // 20 برای margin اضافی

    // پاک کردن مسیرهای وسط
    middleContainer.innerHTML = '<span class="ellipsis">...</span>';

    if (middleItems.length === 0) return;

    // اضافه کردن مسیرهای وسط تا جایی که جا بشه
    let shownItems = [];
    let currentMiddleWidth = 0;
    for (let item of middleItems) {
      const itemWidth = item.offsetWidth + 10; // + gap
      if (currentMiddleWidth + itemWidth <= availableWidth) {
        shownItems.push(item);
        currentMiddleWidth += itemWidth;
      } else {
        break;
      }
    }

    // اگر حداقل یکی جا شد، نشون بده
    if (shownItems.length > 0) {
      middleContainer.innerHTML = '';
      shownItems.forEach(item => middleContainer.appendChild(item));
      if (shownItems.length < middleItems.length) {
        const ellipsis = document.createElement('span');
        ellipsis.className = 'ellipsis';
        ellipsis.textContent = '...';
        middleContainer.appendChild(ellipsis);
      }
    }
  };

  // اجرا در لود و resize
  updateMiddleItems();
  window.addEventListener('resize', updateMiddleItems);
}

// فعال کردن اسکرول با هاور/لمس
function toggleScroll() {
  const wrapper = document.querySelector('.breadcrumb-wrapper');
  wrapper.addEventListener('mouseenter', () => wrapper.classList.add('scroll-active'));
  wrapper.addEventListener('mouseleave', () => wrapper.classList.remove('scroll-active'));
  wrapper.addEventListener('touchstart', () => wrapper.classList.add('scroll-active'));
  wrapper.addEventListener('touchend', () => wrapper.classList.remove('scroll-active'));
}

// اجرا
document.addEventListener('DOMContentLoaded', () => {
  manageBreadcrumb();
  toggleScroll();
});
