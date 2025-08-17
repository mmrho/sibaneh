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

document.addEventListener("DOMContentLoaded", function() {
  const wrapper = document.querySelector(".breadcrumb-wrapper");
  if (!wrapper) return;

  const items = wrapper.querySelectorAll("a, span");
  if (items.length > 2) {
    items[items.length - 2].classList.add("ellipsis");
  }

  // وقتی موس یا لمس شروع شد، کلاس فعال میشه و اسکرول ظاهر میشه
  function activateScroll() {
    wrapper.classList.add("scroll-active");
  }
  // وقتی موس یا لمس تموم شد، کلاس حذف میشه و اسکرول مخفی میشه
  function deactivateScroll() {
    wrapper.classList.remove("scroll-active");
  }

  wrapper.addEventListener("mouseenter", activateScroll);
  wrapper.addEventListener("mouseleave", deactivateScroll);
  wrapper.addEventListener("touchstart", activateScroll);
  wrapper.addEventListener("touchend", deactivateScroll);
});
