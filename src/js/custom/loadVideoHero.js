function initHeroYoutube() {
  const heroes = document.querySelectorAll("[data-hero-youtube]");
  if (!heroes.length) return;

  const isDesktop = window.matchMedia("(min-width: 768px)").matches;
  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  if (!isDesktop || prefersReducedMotion) {
    heroes.forEach((hero) => hero.classList.add("is-no-video"));
    return;
  }

  let youtubeApiPromise = null;

  const loadYoutubeApi = () => {
    if (window.YT && window.YT.Player) {
      return Promise.resolve(window.YT);
    }

    if (youtubeApiPromise) {
      return youtubeApiPromise;
    }

    youtubeApiPromise = new Promise((resolve) => {
      const previous = window.onYouTubeIframeAPIReady;

      window.onYouTubeIframeAPIReady = function () {
        if (typeof previous === "function") {
          previous();
        }
        resolve(window.YT);
      };

      if (!document.querySelector('script[src="https://www.youtube.com/iframe_api"]')) {
        const tag = document.createElement("script");
        tag.src = "https://www.youtube.com/iframe_api";
        tag.async = true;
        document.head.appendChild(tag);
      }
    });

    return youtubeApiPromise;
  };

  const initPlayerForHero = (hero) => {
    const videoId = hero.dataset.videoId?.trim();
    const videoContainer = hero.querySelector(".main-hero__video");

    if (!videoId || !videoContainer) {
      hero.classList.add("is-no-video");
      return;
    }

    if (hero.dataset.youtubeInitialized === "true") return;
    hero.dataset.youtubeInitialized = "true";
    hero.classList.remove("is-no-video");

    let videoShown = false;

    const showVideo = () => {
      if (videoShown) return;
      videoShown = true;
      hero.classList.add("is-video-loaded");
    };

    new YT.Player(videoContainer, {
      videoId,
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

  heroes.forEach((hero) => {
    const startYoutube = () => {
      loadYoutubeApi().then(() => initPlayerForHero(hero));
    };

    if ("requestIdleCallback" in window) {
      requestIdleCallback(startYoutube, { timeout: 2000 });
    } else {
      setTimeout(startYoutube, 1200);
    }
  });
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initHeroYoutube);
} else {
  initHeroYoutube();
}