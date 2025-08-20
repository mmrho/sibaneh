document.querySelectorAll(".ctaToClustr-container").forEach((container, index) => {
  const instanceNumber = index + 1;
  const btn = container.querySelector(`#productToggle-${instanceNumber}`);
  const sheet = container.querySelector(`#sheet-${instanceNumber}`);
  const overlay = container.querySelector(`#overlay-${instanceNumber}`);
  const localNav = container.querySelector(".local-nav");
  const navLinks = container.querySelector(".nav-links");
  let lastFocused = null;

  // Get all sheet items
  let sheetItems = Array.from(container.querySelectorAll(".sheet-item"));

  // Function to update nav-links dynamically
  function updateNavLinks() {
    navLinks.innerHTML = ""; // clear existing
    const isMobile = window.matchMedia("(max-width: 849.98px)").matches;

    if (!isMobile) {
      // Desktop: show first 3 items in nav-links
      sheetItems.forEach((item, i) => {
        if (i < 3) {
          const clone = item.cloneNode(true);
          clone.classList.add("nav-link-item");
          navLinks.appendChild(clone);
          item.remove(); // remove from sheet completely
        }
      });
    } else {
      // Mobile: all items stay in sheet, nav-links hidden
      sheetItems.forEach(item => {
        sheet.querySelector(".sheet-inner").appendChild(item);
        item.style.display = "block";
      });
    }
  }

  // Initial update
  updateNavLinks();

  // Update on resize
  window.addEventListener("resize", () => {
    // Recollect sheet items in case they were removed
    sheetItems = Array.from(container.querySelectorAll(".sheet-item"));
    updateNavLinks();
  });

  // -------------------------------
  // Original sheet/overlay/spacer logic
  // -------------------------------
  let spacer = document.createElement("div");
  spacer.style.width = "100%";
  spacer.style.height = "0px";
  spacer.style.transition = "height 0.3s ease";
  spacer.setAttribute("data-spacer", `cta-instance-${instanceNumber}`);
  container.insertBefore(spacer, localNav.nextSibling);

  function getScrollbarWidth() {
    return window.innerWidth - document.documentElement.clientWidth;
  }

  function updateLocalNavPosition() {
    localNav.style.position = "relative";
    localNav.style.top = "0px";
    localNav.style.left = "0";
    localNav.style.right = "0";
    localNav.classList.add("visible");
    spacer.style.height = sheet.classList.contains("active") ? 1 + sheet.scrollHeight + "px" : "1px";
  }

  function openSheet() {
    lastFocused = document.activeElement;
    btn.setAttribute("aria-expanded", "true");
    sheet.classList.add("active");
    overlay.classList.add("active");

    const sw = getScrollbarWidth();
    if (sw > 0) document.body.style.paddingRight = sw + "px";
    document.documentElement.classList.add("scroll-lock");
    document.body.classList.add("scroll-lock");

    setTimeout(updateLocalNavPosition, 50);
  }

  function closeSheet() {
    btn.setAttribute("aria-expanded", "false");
    sheet.classList.remove("active");
    overlay.classList.remove("active");
    document.documentElement.classList.remove("scroll-lock");
    document.body.classList.remove("scroll-lock");
    document.body.style.paddingRight = "";
    if (lastFocused) lastFocused.focus();
    setTimeout(updateLocalNavPosition, 450);
  }

  btn.addEventListener("click", () => sheet.classList.contains("active") ? closeSheet() : openSheet());
  overlay.addEventListener("click", closeSheet);
  document.addEventListener("keydown", e => { if (e.key === "Escape") closeSheet(); });
  window.addEventListener("load", updateLocalNavPosition);
  window.addEventListener("scroll", updateLocalNavPosition);
  window.addEventListener("resize", updateLocalNavPosition);
});
