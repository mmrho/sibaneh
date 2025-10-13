document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('.gallery-nav__item a');
    const carousels = document.querySelectorAll('.screenshots-carousel');
    let scrollTimeout;

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');

            // Switch carousel based on tab
            const device = link.textContent.trim().toLowerCase();
            carousels.forEach(carousel => {
                carousel.style.display = (carousel.dataset.device === device) ? 'flex' : 'none';
            });
        });
    });

    // Fade scrollbar on scroll
    carousels.forEach(carousel => {
        carousel.addEventListener('scroll', () => {
            carousel.classList.add('scrolling');
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                carousel.classList.remove('scrolling');
            }, 1000); // Fade out after 1 second of inactivity
        });
    });
});

// JavaScript for Tabs and Modal
document.querySelectorAll('.tab-nav-item').forEach(item => {
    item.addEventListener('click', event => {
        event.preventDefault();
        document.querySelectorAll('.tab-nav-item').forEach(el => el.classList.remove('active'));
        item.classList.add('active');
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelector(`#${item.dataset.tab}`).classList.add('active');
    });
});

document.getElementById('version-history-link').addEventListener('click', event => {
    event.preventDefault();
    document.getElementById('version-history-modal').showModal();
});

document.getElementById('close-modal').addEventListener('click', () => {
    document.getElementById('version-history-modal').close();
});