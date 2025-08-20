console.log("header.js is loaded!");

try {
    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM fully loaded!");

        // Menu elements
        const menuBtn = document.getElementById("menuBtnIcon");
        const nav = document.getElementById("mobile-nav");
        const overlay = document.getElementById("mobile-nav-overlay");
        const closeBtn = document.querySelector(".mobile-nav-close");
        const body = document.body;

        // Search elements
        const searchIcon = document.getElementById("searchIcon");
        const searchBar = document.getElementById("mobile-search-bar");
        const searchCancel = document.querySelector(".search-cancel");

        // Log element existence
        console.log("Elements:", {
            menuBtn: !!menuBtn,
            nav: !!nav,
            overlay: !!overlay,
            closeBtn: !!closeBtn,
            searchIcon: !!searchIcon,
            searchBar: !!searchBar,
            searchCancel: !!searchCancel
        });

        if (!menuBtn || !nav || !overlay || !closeBtn || !searchIcon || !searchBar || !searchCancel) {
            console.error("One or more header elements are missing!");
            return;
        }

        // Menu toggle
        menuBtn.addEventListener("click", () => {
            console.log("Menu button clicked!");
            menuBtn.classList.toggle("active");
            nav.classList.toggle("active");
            overlay.classList.toggle("active");
            body.classList.toggle("menu-open");
            console.log("Menu classes:", {
                menuBtn: menuBtn.classList.toString(),
                nav: nav.classList.toString(),
                overlay: overlay.classList.toString(),
                body: body.classList.toString()
            });
        });

        // Close menu
        overlay.addEventListener("click", () => {
            console.log("Overlay clicked!");
            closeMenu();
        });

        closeBtn.addEventListener("click", () => {
            console.log("Close button clicked!");
            closeMenu();
        });

        // Search toggle
        searchIcon.addEventListener("click", () => {
            console.log("Search icon clicked!");
            searchBar.classList.add("active");
            body.classList.add("search-open");
            console.log("Search classes:", {
                searchBar: searchBar.classList.toString(),
                body: body.classList.toString()
            });
            setTimeout(() => {
                const searchInput = searchBar.querySelector("input");
                if (searchInput) {
                    console.log("Focusing on search input!");
                    searchInput.focus();
                } else {
                    console.error("Search input not found!");
                }
            }, 200);
        });

        // Close search
        searchCancel.addEventListener("click", () => {
            console.log("Search cancel clicked!");
            closeSearch();
        });

        // Escape key
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                if (searchBar.classList.contains("active")) {
                    console.log("Escape key - closing search!");
                    closeSearch();
                }
                if (nav.classList.contains("active")) {
                    console.log("Escape key - closing menu!");
                    closeMenu();
                }
            }
        });

        // Close menu function
        function closeMenu() {
            console.log("Closing menu!");
            menuBtn.classList.remove("active");
            nav.classList.remove("active");
            overlay.classList.remove("active");
            body.classList.remove("menu-open");
        }

        // Close search function
        function closeSearch() {
            console.log("Closing search!");
            searchBar.classList.remove("active");
            body.classList.remove("search-open");
        }
    });
} catch (error) {
    console.error("Error in header script:", error);
}