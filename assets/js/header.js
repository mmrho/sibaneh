console.log("header.js is loaded!");

try {
    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM fully loaded!");

        // Element selectors
        const elements = {
            menu: {
                btn: document.getElementById("menuBtnIcon"),
                nav: document.getElementById("mobile-nav"),
                overlay: document.getElementById("mobile-nav-overlay"),
                closeBtn: document.querySelector(".mobile-nav-close")
            },
            search: {
                icon: document.getElementById("searchIcon"),
                bar: document.getElementById("mobile-search-bar"),
                cancel: document.querySelector(".search-cancel"),
                input: null // Will be set dynamically
            },
            body: document.body
        };

        // Validate elements exist
        const validateElements = () => {
            const requiredElements = [
                { name: "menuBtnIcon", element: elements.menu.btn },
                { name: "mobile-nav", element: elements.menu.nav },
                { name: "mobile-nav-overlay", element: elements.menu.overlay },
                { name: "mobile-nav-close", element: elements.menu.closeBtn },
                { name: "searchIcon", element: elements.search.icon },
                { name: "mobile-search-bar", element: elements.search.bar },
                { name: "search-cancel", element: elements.search.cancel }
            ];

            requiredElements.forEach(({ name, element }) => {
                if (!element) console.error(`Element not found: ${name}`);
            });

            return requiredElements.every(({ element }) => element !== null);
        };

        if (!validateElements()) {
            console.error('Required header elements not found!');
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
                console.log("Menu classes:", {
                    btn: elements.menu.btn.classList.toString(),
                    nav: elements.menu.nav.classList.toString(),
                    overlay: elements.menu.overlay.classList.toString(),
                    body: elements.body.classList.toString()
                });
            },

            close() {
                console.log("Closing menu!");
                elements.menu.btn.classList.remove("active");
                elements.menu.nav.classList.remove("active");
                elements.menu.overlay.classList.remove("active");
                elements.body.classList.remove("menu-open");
            },

            toggle() {
                console.log("Toggling menu!");
                elements.menu.nav.classList.contains("active") ? menu.close() : menu.open();
            }
        };

        // Search functionality
        const search = {
            open() {
                console.log("Opening search!");
                elements.search.bar.classList.add("active");
                elements.body.classList.add("search-open");
                console.log("Search classes:", {
                    bar: elements.search.bar.classList.toString(),
                    body: elements.body.classList.toString()
                });

                // Focus on input after animation
                setTimeout(() => {
                    elements.search.input = elements.search.bar.querySelector("input");
                    if (elements.search.input) {
                        console.log("Focusing on search input!");
                        elements.search.input.focus();
                    } else {
                        console.error("Search input not found!");
                    }
                }, 200);
            },

            close() {
                console.log("Closing search!");
                elements.search.bar.classList.remove("active");
                elements.body.classList.remove("search-open");
            }
        };

        // Submenu functionality
        const submenu = {
            init() {
                const submenuLinks = document.querySelectorAll('.mobile-nav-link[data-has-submenu="true"]');
                console.log(`Found ${submenuLinks.length} submenu links`);
                submenuLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        console.log("Submenu link clicked!");
                        const parentItem = link.closest('.mobile-nav-item');
                        parentItem.classList.toggle('submenu-open');
                        console.log("Submenu classes:", parentItem.classList.toString());
                    });
                });
            }
        };

        // Header scroll effect
        const headerScroll = {
            init() {
                const mobileHeaderContainer = document.querySelector('.mobile-header-container');
                if (!mobileHeaderContainer) {
                    console.error("mobile-header-container not found!");
                    return;
                }

                let lastScrollY = window.scrollY;
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        mobileHeaderContainer.classList.add('scrolled');
                    } else {
                        mobileHeaderContainer.classList.remove('scrolled');
                    }
                    lastScrollY = window.scrollY;
                });
            }
        };

        // Keyboard shortcuts
        const keyboard = {
            init() {
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        if (elements.search.bar.classList.contains('active')) {
                            console.log("Escape key - closing search!");
                            search.close();
                        }
                        if (elements.menu.nav.classList.contains('active')) {
                            console.log("Escape key - closing menu!");
                            menu.close();
                        }
                    }
                });
            }
        };

        // Event listeners
        const bindEvents = () => {
            // Menu events
            elements.menu.btn.addEventListener("click", () => menu.toggle());
            elements.menu.overlay.addEventListener("click", () => menu.close());
            elements.menu.closeBtn.addEventListener("click", () => menu.close());

            // Search events
            elements.search.icon.addEventListener("click", () => search.open());
            elements.search.cancel.addEventListener("click", () => search.close());
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