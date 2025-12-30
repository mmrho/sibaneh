/* English Comment: Logic for slider movement via arrows and mouse dragging */
function moveSlider(trackId, direction) {
    const track = document.getElementById(trackId);
    const scrollAmount = track.offsetWidth * 0.8;
    track.scrollBy({ right: direction * scrollAmount, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function() {
    const setups = [
        { track: 'trackColumn', dots: 'dotsLatest' },
        { track: 'trackRow', dots: 'dotsSelected' }
    ];

    setups.forEach(s => {
        const track = document.getElementById(s.track);
        const dotsContainer = document.getElementById(s.dots);
        const cards = track.querySelectorAll('.RAIOA-card');

        cards.forEach((_, i) => {
            const dot = document.createElement('div');
            dot.classList.add('RAIOA-dot');
            if(i === 0) dot.classList.add('active');
            dot.onclick = () => track.scrollTo({ left: i * (track.offsetWidth * 0.8), behavior: 'smooth' });
            dotsContainer.appendChild(dot);
        });

        const dots = dotsContainer.querySelectorAll('.RAIOA-dot');
        track.onscroll = () => {
            const index = Math.round(track.scrollLeft / (track.offsetWidth * 0.7));
            dots.forEach((d, i) => d.classList.toggle('active', i === index));
        };

        // English Comment: Mouse Dragging logic
        let isDown = false, startX, scrollLeft;
        track.onmousedown = (e) => { isDown = true; startX = e.pageX - track.offsetLeft; scrollLeft = track.scrollLeft; };
        track.onmouseleave = () => isDown = false;
        track.onmouseup = () => isDown = false;
        track.onmousemove = (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - track.offsetLeft;
            track.scrollLeft = scrollLeft - (x - startX) * 2;
        };
    });
});