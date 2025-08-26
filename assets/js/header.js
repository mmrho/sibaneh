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

    // Menu functionality
    const menu = {
      open() {
        console.log("Opening menu!");
        elements.menu.btn.classList.add("active");
        elements.menu.nav.classList.add("active");
        elements.menu.overlay.classList.add("active");
        elements.body.classList.add("menu-open");
        elements.headerContent.classList.add("menu-open");
        const navContent = elements.menu.nav.querySelector(
          ".mobile-nav-content"
        );
        if (navContent) {
          navContent.classList.add("active");
        }
      },

      close() {
        console.log("Closing menu!");
        elements.menu.btn.classList.remove("active");
        elements.menu.nav.classList.remove("active");
        elements.menu.overlay.classList.remove("active");
        elements.body.classList.remove("menu-open");
        elements.headerContent.classList.remove("menu-open");
        const navContent = elements.menu.nav.querySelector(
          ".mobile-nav-content"
        );
        if (navContent) {
          navContent.classList.remove("active");
        }
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

    // Search functionality
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
      },

      close() {
        console.log("Closing search!");
        elements.menu.btn.classList.remove("active");
        elements.search.bar.classList.remove("active");
        elements.menu.overlay.classList.remove("active");
        elements.body.classList.remove("search-open");
        elements.headerContent.classList.remove("search-open");
      },

      toggle() {
        console.log("Toggling search!");
        elements.search.bar.classList.contains("active")
          ? search.close()
          : search.open();
      },
    };

    // Shopping functionality
    const shopping = {
      open() {
        console.log("Opening shopping!");
        elements.menu.btn.classList.add("active");
        elements.shopping.panel.classList.add("active");
        elements.menu.overlay.classList.add("active");
        elements.body.classList.add("shopping-open");
        elements.headerContent.classList.add("shopping-open");
      },

      close() {
        console.log("Closing shopping!");
        elements.menu.btn.classList.remove("active");
        elements.shopping.panel.classList.remove("active");
        elements.menu.overlay.classList.remove("active");
        elements.body.classList.remove("shopping-open");
        elements.headerContent.classList.remove("shopping-open");
      },

      toggle() {
        console.log("Toggling shopping!");
        elements.shopping.panel.classList.contains("active")
          ? shopping.close()
          : shopping.open();
      },
    };

    // Submenu functionality
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

    // Header scroll effect
    const headerScroll = {
      init() {
        const headerContainer = document.querySelector(
          ".mobile-header-container"
        );
        let lastScrollTop = 0;
        window.addEventListener("scroll", () => {
          const scrollTop =
            window.pageYOffset || document.documentElement.scrollTop;
          if (scrollTop > 50) {
            headerContainer.classList.add("scrolled");
          } else {
            headerContainer.classList.remove("scrolled");
          }
          lastScrollTop = scrollTop;
        });
      },
    };

    // Keyboard shortcuts
    const keyboard = {
      init() {
        document.addEventListener("keydown", (e) => {
          if (e.key === "Escape") {
            if (elements.search.bar.classList.contains("active")) {
              search.close();
            }
            if (elements.menu.nav.classList.contains("active")) {
              menu.close();
            }
            if (elements.shopping.panel.classList.contains("active")) {
              shopping.close();
            }
          }
        });
      },
    };

    // Event listeners
    const bindEvents = () => {
      // Menu events
      elements.menu.btn.addEventListener("click", () => menu.toggle());
      elements.menu.overlay.addEventListener("click", () => menu.close());

      // Search events
      elements.search.icon.addEventListener("click", () => search.open());
      

      // Shopping events
      elements.shopping.icon.addEventListener("click", () => shopping.open());
      
    };

    // Initialize all functionality
    const init = () => {
      console.log("Initializing header functionality...");
      bindEvents();
      submenu.init();
      headerScroll.init();
      keyboard.init();
    };

    // Start the application
    init();
  });
} catch (error) {
  console.error("Error in header script:", error);
}
