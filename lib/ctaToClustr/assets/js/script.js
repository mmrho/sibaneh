document
  .querySelectorAll(".ctaToClustr-container")
  .forEach((container, index) => {
    const btn = container.querySelector("#productToggle");
    const sheet = container.querySelector("#sheet");
    const overlay = container.querySelector("#overlay");
    const localNav = container.querySelector(".local-nav");
    let lastFocused = null;

    const instanceId = `cta-instance-${index}`;
    container.setAttribute("data-instance", instanceId);

    let spacer = document.createElement("div");
    spacer.style.width = "100%";
    spacer.style.height = "0px";
    spacer.style.transition = "height 0.3s ease";
    spacer.setAttribute("data-spacer", instanceId);
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

      const spacerHeight = sheet.classList.contains("active")
        ? 1 + sheet.scrollHeight 
        : 1; 

      spacer.style.height = spacerHeight + "px";
    }

    function updateSheetPosition() {
      updateLocalNavPosition();
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

      setTimeout(() => {
        updateSheetPosition();
      }, 50);
    }

    function closeSheet() {
      btn.setAttribute("aria-expanded", "false");

      sheet.classList.remove("active");
      overlay.classList.remove("active");

      document.documentElement.classList.remove("scroll-lock");
      document.body.classList.remove("scroll-lock");
      document.body.style.paddingRight = "";

      if (lastFocused) lastFocused.focus();

      setTimeout(() => {
        updateSheetPosition();
      }, 450);
    }
    btn.addEventListener("click", () =>
      sheet.classList.contains("active") ? closeSheet() : openSheet()
    );

    overlay.addEventListener("click", closeSheet);
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeSheet();
    });

    window.addEventListener("load", () => {
      updateLocalNavPosition();
    });

    window.addEventListener("scroll", () => {
      updateLocalNavPosition();
    });

    window.addEventListener("resize", () => {
      updateLocalNavPosition();
    });
  });
