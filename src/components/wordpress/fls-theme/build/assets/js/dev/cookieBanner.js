function initCookieBanner() {
  const banner = document.getElementById("cookie-banner");
  const acceptBtn = document.getElementById("cookie-accept");
  const declineBtn = document.getElementById("cookie-decline");
  if (!banner || !acceptBtn || !declineBtn) return;
  const consentKey = "felgilab_cookie_consent";
  const savedConsent = localStorage.getItem(consentKey);
  if (!savedConsent) {
    banner.hidden = false;
    requestAnimationFrame(() => {
      banner.classList.add("--visible");
    });
  }
  if (savedConsent === "accepted") {
    loadTrackingScripts();
  }
  acceptBtn.addEventListener("click", () => {
    localStorage.setItem(consentKey, "accepted");
    hideBanner(banner);
    loadTrackingScripts();
  });
  declineBtn.addEventListener("click", () => {
    localStorage.setItem(consentKey, "declined");
    hideBanner(banner);
  });
}
function hideBanner(banner) {
  banner.classList.remove("--visible");
  setTimeout(() => {
    banner.hidden = true;
  }, 300);
}
function loadTrackingScripts() {
  if (window.felgiLabTrackingLoaded) return;
  window.felgiLabTrackingLoaded = true;
  loadGTM("GTM-PXHSGB3");
}
function loadGTM(containerId) {
  window.dataLayer = window.dataLayer || [];
  window.dataLayer.push({
    "gtm.start": (/* @__PURE__ */ new Date()).getTime(),
    event: "gtm.js"
  });
  const firstScript = document.getElementsByTagName("script")[0];
  const script = document.createElement("script");
  script.async = true;
  script.src = `https://www.googletagmanager.com/gtm.js?id=${containerId}`;
  if (firstScript?.parentNode) {
    firstScript.parentNode.insertBefore(script, firstScript);
  } else {
    document.head.appendChild(script);
  }
}
export {
  initCookieBanner as i
};
