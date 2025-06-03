



// Toggle Mobile Search
function toggleMobileSearch() {
    const searchBar = document.getElementById('mobile-search-bar');
    const body = document.body;
    
    console.log('Search toggle clicked'); // برای debug
    
    if (searchBar.classList.contains('active')) {
        searchBar.classList.remove('active');
        body.style.overflow = '';
        body.style.position = '';
        body.style.top = '';
        body.style.width = '';
    } else {
        searchBar.classList.add('active');
        body.style.overflow = 'hidden';
        body.style.position = 'fixed';
        body.style.top = `-${window.scrollY}px`;
        body.style.width = '100%';
        
        // Focus on input after animation
        setTimeout(() => {
            const input = searchBar.querySelector('input');
            if (input) input.focus();
        }, 300);
    }
  }
  
  // Toggle Mobile Menu
  function toggleMobileMenu() {
    const overlay = document.getElementById('mobile-nav-overlay');
    const nav = document.getElementById('mobile-nav');
    const toggle = document.querySelector('.mobile-menu-toggle');
    const body = document.body;
    
    console.log('Menu toggle clicked'); // برای debug
    
    if (nav.classList.contains('active')) {
        // Close menu
        overlay.classList.remove('active');
        nav.classList.remove('active');
        toggle.classList.remove('active');
        body.style.overflow = '';
        body.style.position = '';
        body.style.top = '';
        body.style.width = '';
        
        // Close all submenus
        const activeItems = nav.querySelectorAll('.mobile-nav-item.active');
        activeItems.forEach(item => item.classList.remove('active'));
    } else {
        // Open menu
        overlay.classList.add('active');
        nav.classList.add('active');
        toggle.classList.add('active');
        body.style.overflow = 'hidden';
        body.style.position = 'fixed';
        body.style.top = `-${window.scrollY}px`;
        body.style.width = '100%';
    }
  }
  
  // Close Mobile Menu
  function closeMobileMenu() {
    const overlay = document.getElementById('mobile-nav-overlay');
    const nav = document.getElementById('mobile-nav');
    const toggle = document.querySelector('.mobile-menu-toggle');
    const body = document.body;
    
    overlay.classList.remove('active');
    nav.classList.remove('active');
    toggle.classList.remove('active');
    
    const scrollY = document.body.style.top;
    body.style.overflow = '';
    body.style.position = '';
    body.style.top = '';
    body.style.width = '';
    window.scrollTo(0, parseInt(scrollY || '0') * -1);
    
    // Close all submenus
    const activeItems = nav.querySelectorAll('.mobile-nav-item.active');
    activeItems.forEach(item => item.classList.remove('active'));
  }
  
  // Toggle Mobile Submenu
  function toggleMobileSubmenu(element) {
    const parentItem = element.closest('.mobile-nav-item');
    const isActive = parentItem.classList.contains('active');
    
    // Close all other submenus
    const allItems = document.querySelectorAll('.mobile-nav-item.active');
    allItems.forEach(item => {
        if (item !== parentItem) {
            item.classList.remove('active');
        }
    });
    
    // Toggle current submenu
    if (isActive) {
        parentItem.classList.remove('active');
    } else {
        parentItem.classList.add('active');
    }
  }
  
  // Document ready and event listeners
  document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded'); // برای debug
    
    // Handle search button
    const searchBtn = document.querySelector('.mobile-search-btn');
    if (searchBtn) {
        console.log('Search button found'); // برای debug
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileSearch();
        });
    } else {
        console.log('Search button NOT found'); // برای debug
    }
    
    // Handle menu toggle button
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    if (menuToggle) {
        console.log('Menu toggle found'); // برای debug
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileMenu();
        });
    } else {
        console.log('Menu toggle NOT found'); // برای debug
    }
    
    // Handle search close button
    const searchCloseBtn = document.querySelector('.mobile-search-close');
    if (searchCloseBtn) {
        searchCloseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileSearch();
        });
    }
    
    // Handle overlay click
    const overlay = document.getElementById('mobile-nav-overlay');
    if (overlay) {
        overlay.addEventListener('click', function() {
            closeMobileMenu();
        });
    }
    
    // Handle submenu toggles
    const submenuLinks = document.querySelectorAll('.mobile-nav-link[data-has-submenu="true"]');
    submenuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMobileSubmenu(this);
        });
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const nav = document.getElementById('mobile-nav');
        const toggle = document.querySelector('.mobile-menu-toggle');
        const searchBar = document.getElementById('mobile-search-bar');
        const searchBtn = document.querySelector('.mobile-search-btn');
        
        // Close menu if clicking outside
        if (nav && toggle && nav.classList.contains('active')) {
            if (!nav.contains(event.target) && !toggle.contains(event.target)) {
                closeMobileMenu();
            }
        }
        
        // Close search if clicking outside
        if (searchBar && searchBtn && searchBar.classList.contains('active')) {
            if (!searchBar.contains(event.target) && !searchBtn.contains(event.target)) {
                toggleMobileSearch();
            }
        }
    });
    
    // Handle escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const nav = document.getElementById('mobile-nav');
            const searchBar = document.getElementById('mobile-search-bar');
            
            if (nav && nav.classList.contains('active')) {
                closeMobileMenu();
            }
            
            if (searchBar && searchBar.classList.contains('active')) {
                toggleMobileSearch();
            }
        }
    });
  });
  
  // Make functions global for any inline handlers
  window.toggleMobileSearch = toggleMobileSearch;
  window.toggleMobileMenu = toggleMobileMenu;
  window.closeMobileMenu = closeMobileMenu;
  window.toggleMobileSubmenu = toggleMobileSubmenu;
  