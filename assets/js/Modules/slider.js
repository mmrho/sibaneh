/* slider-section js code */
const slides = document.querySelectorAll(".slide");
const prevBtn = document.querySelector(".prev");
const nextBtn = document.querySelector(".next");
const playBtn = document.querySelector(".play-btn");
let currentSlide = 0;
let isPlaying = true;
let slideInterval;

function showSlide(index) {
  slides.forEach((slide) => slide.classList.remove("active"));
  currentSlide = (index + slides.length) % slides.length;
  slides[currentSlide].classList.add("active");
}

function nextSlide() {
  showSlide(currentSlide + 1);
}

function prevSlide() {
  showSlide(currentSlide - 1);
}

function startAutoplay() {
  slideInterval = setInterval(nextSlide, 3000); // Change slide every 3 seconds
  isPlaying = true;
  playBtn.textContent = "||";
}

function stopAutoplay() {
  clearInterval(slideInterval);
  isPlaying = false;
  playBtn.textContent = "▶";
}

function toggleAutoplay() {
  if (isPlaying) {
    stopAutoplay();
  } else {
    startAutoplay();
  }
}

// Start autoplay when page loads
startAutoplay();

// Event listeners
prevBtn.addEventListener("click", () => {
  prevSlide();
  // Restart the timer when manually changing slides
  if (isPlaying) {
    stopAutoplay();
    startAutoplay();
  }
});

nextBtn.addEventListener("click", () => {
  nextSlide();
  // Restart the timer when manually changing slides
  if (isPlaying) {
    stopAutoplay();
    startAutoplay();
  }
});

playBtn.addEventListener("click", toggleAutoplay);

// Pause autoplay when user hovers over the slider
document
  .querySelector(".slider-container")
  .addEventListener("mouseenter", () => {
    if (isPlaying) {
      stopAutoplay();
    }
  });

// Resume autoplay when user leaves the slider
document
  .querySelector(".slider-container")
  .addEventListener("mouseleave", () => {
    if (!isPlaying) {
      startAutoplay();
    }
  });
