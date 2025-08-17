document.querySelectorAll('.ctaToClustr-container').forEach((container, index) => {
    const btn = container.querySelector('#productToggle');
    const sheet = container.querySelector('#sheet');
    const overlay = container.querySelector('#overlay');
    const localNav = container.querySelector('.local-nav');
    let lastFocused = null;

    // Add unique identifier
    const instanceId = `cta-instance-${index}`;
    container.setAttribute('data-instance', instanceId);

    // Create spacer
    let spacer = document.createElement('div');
    spacer.style.width = '100%';
    spacer.style.height = '0px';
    spacer.style.transition = 'height 0.3s ease';
    spacer.setAttribute('data-spacer', instanceId);
    container.insertBefore(spacer, localNav.nextSibling);

    function getScrollbarWidth() {
        return window.innerWidth - document.documentElement.clientWidth;
    }

    // Simplified positioning calculation
    function updateLocalNavPosition() {
        const targetSelector = localNav.getAttribute('data-target') || '#site-header';
        let refEl = document.querySelector(targetSelector);
        
        // اگر target پیدا نشد، از خود container استفاده کن
        if (!refEl) {
            refEl = container.closest('section') || container.parentElement;
        }

        if (!refEl) return;

        // استفاده از getBoundingClientRect برای دقت بیشتر
        const containerRect = container.getBoundingClientRect();
        const refRect = refEl.getBoundingClientRect();
        
        // محاسبه موقعیت نسبت به container
        const containerTop = containerRect.top + window.scrollY;
        
        // قرار دادن navbar در بالای container (نه زیر target)
        localNav.style.position = 'absolute';
        localNav.style.top = '0px'; // همیشه در بالای container
        localNav.style.left = '0';
        localNav.style.right = '0';
        localNav.classList.add('visible');

        // Update spacer height
        spacer.style.height = localNav.offsetHeight + 'px';
    }

    function updateSheetPosition() {
        if (!sheet.classList.contains('active')) return;

        // قرار دادن sheet مستقیماً زیر navbar
        sheet.style.position = 'absolute';
        sheet.style.top = localNav.offsetHeight + 'px';
        sheet.style.left = '0';
        sheet.style.right = '0';
    }

    function openSheet() {
        lastFocused = document.activeElement;
        btn.setAttribute('aria-expanded', 'true');

        updateLocalNavPosition();

        sheet.style.transform = 'translateY(-20px)';
        sheet.style.opacity = '0';
        sheet.classList.add('active');
        overlay.classList.add('active');

        sheet.getBoundingClientRect();

        sheet.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
        sheet.style.transform = 'translateY(0)';
        sheet.style.opacity = '1';

        const sw = getScrollbarWidth();
        if (sw > 0) document.body.style.paddingRight = sw + 'px';
        document.documentElement.classList.add('scroll-lock');
        document.body.classList.add('scroll-lock');

        updateSheetPosition();
    }

    function closeSheet() {
        btn.setAttribute('aria-expanded', 'false');

        sheet.style.transform = 'translateY(-20px)';
        sheet.style.opacity = '0';

        setTimeout(() => {
            sheet.classList.remove('active');
            overlay.classList.remove('active');
        }, 300);

        document.documentElement.classList.remove('scroll-lock');
        document.body.classList.remove('scroll-lock');
        document.body.style.paddingRight = '';
        if (lastFocused) lastFocused.focus();
    }

    btn.addEventListener('click', () =>
        sheet.classList.contains('active') ? closeSheet() : openSheet()
    );

    overlay.addEventListener('click', closeSheet);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeSheet();
    });

    // Initial positioning
    window.addEventListener('load', () => {
        updateLocalNavPosition();
        updateSheetPosition();
    });

    window.addEventListener('scroll', () => {
        updateLocalNavPosition();
        updateSheetPosition();
    });
    
    window.addEventListener('resize', () => {
        updateLocalNavPosition();
        updateSheetPosition();
    });
});
