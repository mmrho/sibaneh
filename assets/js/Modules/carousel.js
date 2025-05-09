/* carousel-section js code */
const baseUrl = wbs_script.themeUrl;

const games = [
  {
    title: "Sneaky Sasquatch",
    category: "Adventure",
    image: baseUrl + "/images/temp/NBA-game-baner.jpg",
  },
  {
    title: "NBA 2K22",
    category: "Sports",
    image: baseUrl + "/images/temp/GTA-baner.jpeg",
  },
  {
    title: "Angry Birds",
    category: "Action",
    image: baseUrl + "/images/temp/CALLOFDUTY-baner.jpeg",
  },
  {
    title: "LEGO Star",
    category: "Strategy",
    image: baseUrl + "/images/temp/CALLOFDUTY-baner.jpeg",
  },
  {
    title: "Crossy Road",
    category: "Action",
    image: baseUrl + "/images/temp/GTA-baner.jpeg",
  },
];

function createGameCard(game) {
  return `
          <div class="game-card">
          <div class="game-image-container">
          <img src="${game.image}" alt="${game.title}" class="game-image">
          <div class="game-info">
          <div class="game-category">${game.category}</div>
          <div class="game-title">${game.title}</div>
          </div>
          <button class="game-button">دریافت اپلیکیشن</button>
          </div>
          </div>
          
          `;
}

function initializeTrack(trackId, isReverse = false) {
  const track = document.getElementById(trackId);
  const content = [...games, ...games, ...games]
    .map((game) => createGameCard(game))
    .join("");
  track.innerHTML = content;
  if (isReverse) {
    track.style.right = "0";
    track.style.left = "auto";
  }
  return track;
}

function animateTrack(track, isReverse = false) {
  const cardWidth = 316; // card width (250px) + margin-right (16px)
  const totalWidth = cardWidth * games.length;
  let position = 0;
  let isHovered = false;

  function moveTrack() {
    if (!isHovered) {
      position += 1;
      if (position >= totalWidth) {
        position = 0;
      }
      const translateValue = isReverse ? position : -position;
      track.style.transform = `translateX(${translateValue}px)`;
    }
  }

  const interval = setInterval(moveTrack, 50); // Smoother animation

  // Add event listeners for hover
  track.addEventListener("mouseenter", () => {
    isHovered = true;
  });

  track.addEventListener("mouseleave", () => {
    isHovered = false;
  });

  // Return the interval ID so it can be cleared if needed
  return interval;
}

// Initialize and animate all tracks
const track1 = initializeTrack("track1");
const track2 = initializeTrack("track2", true);
const track3 = initializeTrack("track3");
const track4 = initializeTrack("track4", true);
animateTrack(track1);
animateTrack(track2, true);
animateTrack(track3);
animateTrack(track4, true);

