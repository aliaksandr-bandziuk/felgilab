function initHeroYoutube() {
  const heroes = document.querySelectorAll("[data-hero-youtube]");
  if (!heroes.length) return;

  const isDesktop = window.matchMedia("(min-width: 768px)").matches;
  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  heroes.forEach((hero) => {
    const videoId = hero.dataset.videoId?.trim();
    const videoContainer = hero.querySelector(".main-hero__video");

    if (!videoId || !videoContainer || !isDesktop || prefersReducedMotion) {
      hero.classList.add("is-no-video");
      return;
    }

    hero.classList.remove("is-no-video");

    if (hero.dataset.youtubeInitialized === "true") return;
    hero.dataset.youtubeInitialized = "true";

    let videoShown = false;

    const showVideo = () => {
      if (videoShown) return;
      videoShown = true;
      hero.classList.add("is-video-loaded");
    };

    const createPlayer = () => {
      new YT.Player(videoContainer, {
        videoId: videoId,
        playerVars: {
          autoplay: 1,
          controls: 0,
          disablekb: 1,
          fs: 0,
          modestbranding: 1,
          loop: 1,
          playlist: videoId,
          rel: 0,
          mute: 1,
          playsinline: 1
        },
        events: {
          onReady: function (event) {
            event.target.mute();
            event.target.playVideo();
          },
          onStateChange: function (event) {
            if (event.data === YT.PlayerState.PLAYING) {
              showVideo();
            }
          }
        }
      });
    };

    if (window.YT && window.YT.Player) {
      createPlayer();
      return;
    }

    if (!document.querySelector('script[src="https://www.youtube.com/iframe_api"]')) {
      const tag = document.createElement("script");
      tag.src = "https://www.youtube.com/iframe_api";
      document.head.appendChild(tag);
    }

    const previous = window.onYouTubeIframeAPIReady;
    window.onYouTubeIframeAPIReady = function () {
      if (typeof previous === "function") previous();
      createPlayer();
    };
  });
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initHeroYoutube);
} else {
  initHeroYoutube();
}