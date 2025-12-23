document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll(".gallery-nav__item a");
  const carousels = document.querySelectorAll(".screenshots-carousel");
  let scrollTimeout;

  navLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      navLinks.forEach((l) => l.classList.remove("active"));
      link.classList.add("active");

      // Switch carousel based on tab
      const device = link.textContent.trim().toLowerCase();
      carousels.forEach((carousel) => {
        carousel.style.display =
          carousel.dataset.device === device ? "flex" : "none";
      });
    });
  });

  // Fade scrollbar on scroll
  carousels.forEach((carousel) => {
    carousel.addEventListener("scroll", () => {
      carousel.classList.add("scrolling");
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        carousel.classList.remove("scrolling");
      }, 1000); // Fade out after 1 second of inactivity
    });
  });
});

// JavaScript for Tabs and Modal
document.querySelectorAll(".tab-nav-item").forEach((item) => {
  item.addEventListener("click", (event) => {
    event.preventDefault();
    document
      .querySelectorAll(".tab-nav-item")
      .forEach((el) => el.classList.remove("active"));
    item.classList.add("active");
    document
      .querySelectorAll(".tab-content")
      .forEach((el) => el.classList.remove("active"));
    document.querySelector(`#${item.dataset.tab}`).classList.add("active");
  });
});

document
  .getElementById("version-history-link")
  .addEventListener("click", (event) => {
    event.preventDefault();
    document.getElementById("version-history-modal").showModal();
  });

document.getElementById("close-modal").addEventListener("click", () => {
  document.getElementById("version-history-modal").close();
});

function showVideoModal(videoInput) {
  const modal = document.getElementById("videoModal");
  const content = modal.querySelector(".video-content");

  if (!videoInput) {
    console.error("No video input provided");
    return;
  }

  let iframeHTML = "";

  // If input is an iframe HTML, use it directly (add autoplay and allow)
  if (videoInput.includes("<iframe")) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(videoInput, "text/html");
    let iframe = doc.querySelector("iframe");
    if (iframe) {
      let src = iframe.getAttribute("src");
      if (!src.includes("autoplay")) {
        src += (src.includes("?") ? "&" : "?") + "autoplay=1";
      }
      iframe.setAttribute("src", src);
      iframe.setAttribute("allow", "autoplay; fullscreen");
      iframeHTML = iframe.outerHTML;
    } else {
      iframeHTML = videoInput;
    }
  } else {
    // Assume it's a raw Aparat URL and generate iframe with autoplay
    const match = videoInput.match(/\/v\/([^\/?&]+)/);
    const code = match ? match[1] : null;
    if (code) {
      iframeHTML = `<iframe src="https://www.aparat.com/video/video/embed/videohash/${code}/vt/frame?autoplay=1" width="100%" height="100%" allowfullscreen allow="autoplay; fullscreen"></iframe>`;
    } else {
      console.error("Invalid Aparat video input:", videoInput);
      return;
    }
  }

  content.innerHTML = iframeHTML;

  // Show modal with animation
  modal.classList.add("active");

  // Try to play via JS if possible (but for cross-origin iframe, limited)
  const iframe = content.querySelector("iframe");
  if (iframe) {
    iframe.addEventListener("load", () => {
      console.log("Iframe loaded");
      // If Aparat has API, could postMessage, but no docs found
    });
  }
}

function closeVideoModal() {
  const modal = document.getElementById("videoModal");
  const content = modal.querySelector(".video-content");

  modal.classList.remove("active");
  setTimeout(() => {
    content.innerHTML = ""; // Stop video
  }, 400);
}
