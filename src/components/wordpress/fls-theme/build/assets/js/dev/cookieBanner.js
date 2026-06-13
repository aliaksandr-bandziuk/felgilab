function initCookieBanner() {
  const banner = document.getElementById("cookie-banner");
  const acceptBtn = document.getElementById("cookie-accept");
  const declineBtn = document.getElementById("cookie-decline");
  if (!banner || !acceptBtn || !declineBtn) return;
  const consentKey = "felgilab_cookie_consent";
  const savedConsent = localStorage.getItem(consentKey);
  window.dataLayer = window.dataLayer || [];
  if (savedConsent === "accepted") {
    updateConsent("granted");
  }
  if (savedConsent === "declined") {
    updateConsent("denied");
  }
  if (!savedConsent) {
    banner.hidden = false;
    requestAnimationFrame(() => {
      banner.classList.add("--visible");
    });
  }
  acceptBtn.addEventListener("click", () => {
    localStorage.setItem(consentKey, "accepted");
    updateConsent("granted");
    hideBanner(banner);
  });
  declineBtn.addEventListener("click", () => {
    localStorage.setItem(consentKey, "declined");
    updateConsent("denied");
    hideBanner(banner);
  });
}
function hideBanner(banner) {
  banner.classList.remove("--visible");
  setTimeout(() => {
    banner.hidden = true;
  }, 300);
}
function updateConsent(status) {
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    window.dataLayer.push(arguments);
  }
  gtag("consent", "update", {
    ad_storage: status,
    ad_user_data: status,
    ad_personalization: status,
    analytics_storage: status,
    functionality_storage: status,
    personalization_storage: status,
    security_storage: "granted"
  });
  window.dataLayer.push({
    event: status === "granted" ? "cookie_consent_accepted" : "cookie_consent_declined",
    cookie_consent_status: status
  });
}
export {
  initCookieBanner as i
};
