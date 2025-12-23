console.log("header.js loaded - Apple Style Logic Activated");

try {
  document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM fully loaded!");

    // 1. Element selectors (ساختار اصلی شما حفظ شد)
    const elements = {
      menu: {
        btn: document.querySelector(".mobile-menu-toggle"), // تغییر سلکتور برای اطمینان
        nav: document.getElementById("mobile-nav"),
        overlay: document.getElementById("mobile-nav-overlay"),
        container: document.querySelector(".mobile-header-container")
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

    // 2. Validate elements (کد شما حفظ شد)
    const validateElements = () => {
      // بررسی وجود المنت‌ها (ساده شده برای جلوگیری از خطا اگر برخی آیدی‌ها متفاوت باشند)
      if (!elements.menu.nav) console.warn("Mobile nav not found");
      return true; 
    };

    validateElements();

    // 3. Scroll lock management (کد شما حفظ شد)
    let scrollPosition = 0;
    function lockBody() {
      scrollPosition = window.scrollY;
      elements.body.style.top = `-${scrollPosition}px`;
      elements.body.style.position = "fixed";
      elements.body.style.overflow = "hidden";
      elements.body.style.width = "100%";
    }
    function unlockBody() {
      elements.body.style.position = "";
      elements.body.style.overflow = "";
      elements.body.style.width = "";
      elements.body.style.top = "";
      window.scrollTo(0, scrollPosition);
    }

    // =========================================================================
    // Mobile Menu Functionality (Updated Logic)
    // =========================================================================
    const menu = {
      open() {
        if(!elements.menu.nav) return;
        elements.menu.btn.classList.add("active");
        elements.menu.nav.classList.add("active");
        if(elements.menu.overlay) elements.menu.overlay.classList.add("active");
        
        elements.body.classList.add("menu-open");
        // افزودن کلاس به کانتینر هدر برای مدیریت استایل‌ها
        if(elements.menu.container) elements.menu.container.classList.add("menu-open");
        
        lockBody();
      },

      close() {
        if(!elements.menu.nav) return;
        elements.menu.btn.classList.remove("active");
        elements.menu.nav.classList.remove("active");
        if(elements.menu.overlay) elements.menu.overlay.classList.remove("active");
        
        elements.body.classList.remove("menu-open");
        if(elements.menu.container) elements.menu.container.classList.remove("menu-open");
        
        unlockBody();
      },

      toggle() {
        if (elements.menu.nav && elements.menu.nav.classList.contains("active")) {
          menu.close();
        } else {
          // بستن سایر پنل‌ها اگر باز باشند
          if (elements.search.bar && elements.search.bar.classList.contains("active")) search.close();
          if (elements.shopping.panel && elements.shopping.panel.classList.contains("active")) shopping.close();
          menu.open();
        }
      }
    };

    // =========================================================================
    // Mobile Search Functionality (Preserved)
    // =========================================================================
    const search = {
      open() {
        if(!elements.search.bar) return;
        elements.search.bar.classList.add("active");
        elements.body.classList.add("search-open");
        lockBody();
        setTimeout(() => {
            const input = elements.search.bar.querySelector("input");
            if(input) input.focus();
        }, 300);
      },
      close() {
        if(!elements.search.bar) return;
        elements.search.bar.classList.remove("active");
        elements.body.classList.remove("search-open");
        unlockBody();
      },
      toggle() {
        elements.search.bar.classList.contains("active") ? search.close() : search.open();
      }
    };

    // =========================================================================
    // Mobile Shopping Functionality (Preserved)
    // =========================================================================
    const shopping = {
      open() {
        if(!elements.shopping.panel) return;
        elements.shopping.panel.classList.add("active");
        elements.body.classList.add("shopping-open");
        lockBody();
      },
      close() {
        if(!elements.shopping.panel) return;
        elements.shopping.panel.classList.remove("active");
        elements.body.classList.remove("shopping-open");
        unlockBody();
      },
      toggle() {
        elements.shopping.panel.classList.contains("active") ? shopping.close() : shopping.open();
      }
    };

    // =========================================================================
    // Submenu & Scroll (Preserved)
    // =========================================================================
    const submenu = {
      init() {
        const submenuLinks = document.querySelectorAll('.mobile-nav-link[data-has-submenu="true"]');
        submenuLinks.forEach((link) => {
          link.addEventListener("click", (e) => {
            e.preventDefault();
            const parentItem = link.closest(".mobile-nav-item");
            parentItem.classList.toggle("submenu-open");
          });
        });
      },
    };

    const headerScroll = {
      init() {
        const headerContainer = document.querySelector(".mobile-header-container");
        if(!headerContainer) return;
        window.addEventListener("scroll", () => {
          const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
          if (scrollTop > 50) headerContainer.classList.add("scrolled");
          else headerContainer.classList.remove("scrolled");
        });
      },
    };

    // =========================================================================
    // Desktop Mega Menu (Apple Logic + Waterfall Trigger)
    // =========================================================================
    const desktopMenu = {
      init() {
        if (window.innerWidth <= 992) return;

        const navItems = document.querySelectorAll(".site-nav-item");
        const sharedBackground = document.querySelector(".mega-menu-background");
        const overlay = document.querySelector(".desktop-nav-overlay");
        let closeTimeout;

        const closeAll = () => {
          document.querySelectorAll(".mega-menu.is-active").forEach((m) => m.classList.remove("is-active"));
          if (sharedBackground) {
            sharedBackground.style.height = "0px";
            sharedBackground.classList.remove("open");
          }
          if (overlay) overlay.classList.remove("active");
        };

        navItems.forEach((item) => {
          const megaMenu = item.querySelector(".mega-menu");
          if (!megaMenu) return; // Skip items without submenu
          
          const contentContainer = megaMenu.querySelector(".mega-menu-container");

          item.addEventListener("mouseenter", () => {
            clearTimeout(closeTimeout);
            
            // Close other open menus immediately
            document.querySelectorAll(".mega-menu.is-active").forEach(m => {
                if(m !== megaMenu) m.classList.remove("is-active");
            });

            megaMenu.classList.add("is-active"); // Triggers CSS waterfall
            if (overlay) overlay.classList.add("active");

            // Calculate height for morphing background
            if (sharedBackground && contentContainer) {
               const height = contentContainer.offsetHeight;
               sharedBackground.classList.add("open");
               sharedBackground.style.height = height + "px";
            }
          });

          item.addEventListener("mouseleave", () => {
            closeTimeout = setTimeout(closeAll, 100);
          });
          
          // Keep open on hover content
          megaMenu.addEventListener("mouseenter", () => clearTimeout(closeTimeout));
          megaMenu.addEventListener("mouseleave", () => closeTimeout = setTimeout(closeAll, 100));
        });
        
        if (overlay) overlay.addEventListener("click", closeAll);
      },
    };

    // =========================================================================
    // Events & Init
    // =========================================================================
    const bindEvents = () => {
      if(elements.menu.btn) elements.menu.btn.addEventListener("click", (e) => {
          e.preventDefault(); // جلوگیری از رفتار پیش‌فرض لینک
          menu.toggle();
      });
      if(elements.menu.overlay) elements.menu.overlay.addEventListener("click", () => menu.close());
      
      if(elements.search.icon) elements.search.icon.addEventListener("click", () => search.open());
      
      if(elements.shopping.icon) elements.shopping.icon.addEventListener("click", () => shopping.open());
    };

    const init = () => {
      bindEvents();
      submenu.init();
      headerScroll.init();
      desktopMenu.init();
    };

    init();
  });
} catch (error) {
  console.error("Error in header script:", error);
}