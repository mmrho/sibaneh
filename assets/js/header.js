console.log("header.js is loaded!");

try {
  document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM fully loaded!");

    // Element selectors
    const elements = {
      menu: {
        btn: document.getElementById("menuBtnIcon"),
        nav: document.getElementById("mobile-nav"),
        overlay: document.getElementById("mobile-nav-overlay"),
      },
      search: {
        icon: document.getElementById("searchIcon"),
        bar: document.getElementById("mobile-search-bar"),
        input: null,
      },
      shopping: {
        icon: document.getElementById("shoppingBagIcon"),
        panel: document.getElementById("mobile-shopping-panel"),
      },
      headerContent: document.querySelector(".mobile-header-content"),
      body: document.body,
    };

    // Validate elements exist
    const validateElements = () => {
      const requiredElements = [
        { name: "menuBtnIcon", element: elements.menu.btn },
        { name: "mobile-nav", element: elements.menu.nav },
        { name: "mobile-nav-overlay", element: elements.menu.overlay },
        { name: "searchIcon", element: elements.search.icon },
        { name: "mobile-search-bar", element: elements.search.bar },
        { name: "shoppingBagIcon", element: elements.shopping.icon },
        { name: "mobile-shopping-panel", element: elements.shopping.panel },
      ];

      requiredElements.forEach(({ name, element }) => {
        if (!element) console.error(`Element not found: ${name}`);
      });

      return requiredElements.every(({ element }) => element !== null);
    };

    if (!validateElements()) {
      console.error("Required header elements not found!");
      return;
    }

    // === Scroll lock management ===
    let scrollPosition = 0;

    // Lock body scroll
    function lockBody() {
      scrollPosition = window.scrollY;
      elements.body.style.top = `-${scrollPosition}px`;
      elements.body.style.position = "fixed";
      elements.body.style.overflow = "hidden";
      elements.body.style.width = "100%";
    }

    // Unlock body scroll
    function unlockBody() {
      elements.body.style.position = "";
      elements.body.style.overflow = "";
      elements.body.style.width = "";
      elements.body.style.top = "";
      window.scrollTo(0, scrollPosition);
    }

    // =========================================================================
    // Mobile Menu Functionality
    // =========================================================================
    const menu = {
      open() {
        console.log("Opening menu!");
        elements.menu.btn.classList.add("active");
        elements.menu.nav.classList.add("active");
        elements.menu.overlay.classList.add("active");
        elements.body.classList.add("menu-open");
        elements.headerContent.classList.add("menu-open");
        const navContent = elements.menu.nav.querySelector(".mobile-nav-content");
        if (navContent) {
          navContent.classList.add("active");
        }
        lockBody();
      },

      close() {
        console.log("Closing menu!");
        elements.menu.btn.classList.remove("active");
        elements.menu.nav.classList.remove("active");
        elements.menu.overlay.classList.remove("active");
        elements.body.classList.remove("menu-open");
        elements.headerContent.classList.remove("menu-open");
        const navContent = elements.menu.nav.querySelector(".mobile-nav-content");
        if (navContent) {
          navContent.classList.remove("active");
        }
        unlockBody();
      },

      toggle() {
        console.log("Toggling menu!");
        if (elements.menu.nav.classList.contains("active")) {
          menu.close();
        } else if (elements.search.bar.classList.contains("active")) {
          search.close();
        } else if (elements.shopping.panel.classList.contains("active")) {
          shopping.close();
        } else {
          menu.open();
        }
      },
    };

    // =========================================================================
    // Mobile Search Functionality
    // =========================================================================
    const search = {
      open() {
        console.log("Opening search!");
        elements.menu.btn.classList.add("active");
        elements.search.bar.classList.add("active");
        elements.menu.overlay.classList.add("active");
        elements.body.classList.add("search-open");
        elements.headerContent.classList.add("search-open");
        setTimeout(() => {
          elements.search.input = elements.search.bar.querySelector("input");
          if (elements.search.input) {
            elements.search.input.focus();
          }
        }, 200);
        lockBody();
      },

      close() {
        console.log("Closing search!");
        elements.menu.btn.classList.remove("active");
        elements.search.bar.classList.remove("active");
        elements.menu.overlay.classList.remove("active");
        elements.body.classList.remove("search-open");
        elements.headerContent.classList.remove("search-open");
        unlockBody();
      },

      toggle() {
        console.log("Toggling search!");
        elements.search.bar.classList.contains("active")
          ? search.close()
          : search.open();
      },
    };

    // =========================================================================
    // Mobile Shopping Functionality
    // =========================================================================
    const shopping = {
      open() {
        console.log("Opening shopping!");
        elements.menu.btn.classList.add("active");
        elements.shopping.panel.classList.add("active");
        elements.menu.overlay.classList.add("active");
        elements.body.classList.add("shopping-open");
        elements.headerContent.classList.add("shopping-open");
        lockBody();
      },

      close() {
        console.log("Closing shopping!");
        elements.menu.btn.classList.remove("active");
        elements.shopping.panel.classList.remove("active");
        elements.menu.overlay.classList.remove("active");
        elements.body.classList.remove("shopping-open");
        elements.headerContent.classList.remove("shopping-open");
        unlockBody();
      },

      toggle() {
        console.log("Toggling shopping!");
        elements.shopping.panel.classList.contains("active")
          ? shopping.close()
          : shopping.open();
      },
    };

    // =========================================================================
    // Mobile Submenu Functionality
    // =========================================================================
    const submenu = {
      init() {
        const submenuLinks = document.querySelectorAll(
          '.mobile-nav-link[data-has-submenu="true"]'
        );
        submenuLinks.forEach((link) => {
          link.addEventListener("click", (e) => {
            e.preventDefault();
            const parentItem = link.closest(".mobile-nav-item");
            parentItem.classList.toggle("submenu-open");
          });
        });
      },
    };

    // =========================================================================
    // Mobile Header Scroll Effect
    // =========================================================================
    const headerScroll = {
      init() {
        const headerContainer = document.querySelector(".mobile-header-container");
        let lastScrollTop = 0;
        window.addEventListener("scroll", () => {
          const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
          if (scrollTop > 50) {
            headerContainer.classList.add("scrolled");
          } else {
            headerContainer.classList.remove("scrolled");
          }
          lastScrollTop = scrollTop;
        });
      },
    };

    // =========================================================================
    // Global Keyboard Shortcuts (Esc)
    // =========================================================================
    const keyboard = {
      init() {
        document.addEventListener("keydown", (e) => {
          if (e.key === "Escape") {
            // Close mobile elements
            if (elements.search.bar.classList.contains("active")) {
              search.close();
            }
            if (elements.menu.nav.classList.contains("active")) {
              menu.close();
            }
            if (elements.shopping.panel.classList.contains("active")) {
              shopping.close();
            }
            
            // Close desktop menu elements (if active)
            const desktopOverlay = document.querySelector('.desktop-nav-overlay');
            if (desktopOverlay && desktopOverlay.classList.contains('active')) {
                 // Trigger click on overlay to close everything via desktopMenu logic
                 desktopOverlay.click();
            }
          }
        });
      },
    };

    // =========================================================================
    // Desktop Mega Menu (True Apple Implementation - Shared Background)
    // =========================================================================
    const desktopMenu = {
      init() {
        // Only run on desktop devices (breakpoint > 992px)
        if (window.innerWidth <= 992) return;

        console.log("Initializing Apple-style Desktop Menu...");

        const navItems = document.querySelectorAll('.site-nav-item.has-submenu');
        const overlay = document.querySelector('.desktop-nav-overlay');
        const sharedBackground = document.querySelector('.mega-menu-background');
        
        let activeMenu = null;
        let closeTimeout;

        // Function to close all open desktop menus
        const closeAll = () => {
          // Hide all menu contents
          document.querySelectorAll('.mega-menu.is-active').forEach(m => m.classList.remove('is-active'));
          
          // Collapse the shared background
          if (sharedBackground) {
            sharedBackground.style.height = '0px';
            sharedBackground.classList.remove('open');
          }
          
          // Hide overlay
          if (overlay) overlay.classList.remove('active');
          activeMenu = null;
        };

        navItems.forEach(item => {
          const megaMenu = item.querySelector('.mega-menu');
          const contentContainer = megaMenu ? megaMenu.querySelector('.mega-menu-container') : null;

          if (!megaMenu || !contentContainer) return;

          // Mouse Enter Event (Open or Switch Menu)
          item.addEventListener('mouseenter', () => {
            clearTimeout(closeTimeout); // Cancel any pending close action

            // If we are switching from another menu, hide the previous content
            if (activeMenu && activeMenu !== megaMenu) {
              activeMenu.classList.remove('is-active');
            }

            // 1. Show the new content (Fade In)
            megaMenu.classList.add('is-active');
            
            // 2. Calculate the exact height needed for this content
            const height = contentContainer.offsetHeight;

            // 3. Apply the height to the shared background (Morphing Animation)
            if (sharedBackground) {
                sharedBackground.classList.add('open');
                sharedBackground.style.height = height + 'px';
            }

            // 4. Show Overlay
            if (overlay) overlay.classList.add('active');
            
            activeMenu = megaMenu;
          });

          // Mouse Leave Event (Close Menu with Delay)
          item.addEventListener('mouseleave', () => {
            // Set a timeout to allow user to move mouse into the menu area
            closeTimeout = setTimeout(() => {
                closeAll();
            }, 150); 
          });

          // Prevent closing when hovering over the menu content itself
          megaMenu.addEventListener('mouseenter', () => clearTimeout(closeTimeout));
          megaMenu.addEventListener('mouseleave', () => {
            closeTimeout = setTimeout(closeAll, 150);
          });
          
          // Prevent closing when hovering over the shared background (Safety check)
          if(sharedBackground) {
             sharedBackground.addEventListener('mouseenter', () => clearTimeout(closeTimeout));
             sharedBackground.addEventListener('mouseleave', (e) => {
                 // Close only if mouse leaves downwards or sideways, not upwards back to nav
                 if (e.clientY > sharedBackground.getBoundingClientRect().top) {
                      closeTimeout = setTimeout(closeAll, 150);
                 }
             });
          }
        });

        // Close everything when clicking on the overlay
        if (overlay) {
          overlay.addEventListener('click', closeAll);
        }
      }
    };

    // =========================================================================
    // Event Listeners Binding
    // =========================================================================
    const bindEvents = () => {
      // Menu events
      elements.menu.btn.addEventListener("click", () => menu.toggle());
      elements.menu.overlay.addEventListener("click", () => menu.close());

      // Search events
      elements.search.icon.addEventListener("click", () => search.open());

      // Shopping events
      elements.shopping.icon.addEventListener("click", () => shopping.open());
    };

    // Prevent iOS touchmove scroll when panel is open
    document.addEventListener(
      "touchmove",
      (e) => {
        if (
          elements.body.classList.contains("menu-open") ||
          elements.body.classList.contains("search-open") ||
          elements.body.classList.contains("shopping-open")
        ) {
          if (!e.target.closest("#mobile-nav, #mobile-search-bar, #mobile-shopping-panel")) {
            e.preventDefault();
          }
        }
      },
      { passive: false }
    );

    // =========================================================================
    // Application Initialization
    // =========================================================================
    const init = () => {
      console.log("Initializing header functionality...");
      bindEvents();
      submenu.init();
      headerScroll.init();
      keyboard.init();
      
      // Initialize Desktop Menu Logic
      desktopMenu.init();
    };

    // Start the application
    init();
  });
} catch (error) {
  console.error("Error in header script:", error);
}