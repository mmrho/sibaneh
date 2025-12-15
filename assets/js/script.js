










// ================================================================================================
// Footer Styles
// ================================================================================================

/**
 * Footer Accordion Logic
 * Only activates when screen width is <= mobile via CSS classes,
 * but the event listener is attached globally.
 */
document.addEventListener("DOMContentLoaded", function () {
  // Select all column headers within the footer
  const headers = document.querySelectorAll(".site-footer .col-header");

  headers.forEach((header) => {
    header.addEventListener("click", function () {
      // Check if we are on mobile viewport (Adjust breakpoint as needed)
      if (window.innerWidth <= 845) {
        const parentCol = this.parentElement;
        const content = parentCol.querySelector(".link-list");

        // 1. Close other open accordions (Accordion Behavior)
        document.querySelectorAll(".footer-col").forEach((col) => {
          if (col !== parentCol && col.classList.contains("active")) {
            col.classList.remove("active");
            // Set max-height to null to collapse
            col.querySelector(".link-list").style.maxHeight = null;
          }
        });

        // 2. Toggle the clicked column
        if (parentCol.classList.contains("active")) {
          // If active, remove class and collapse content
          parentCol.classList.remove("active");
          content.style.maxHeight = null;
        } else {
          // If not active, add class and expand content
          parentCol.classList.add("active");
          // Calculate the exact height of the content for smooth animation
          content.style.maxHeight = content.scrollHeight + "px";
        }
      }
    });
  });
});