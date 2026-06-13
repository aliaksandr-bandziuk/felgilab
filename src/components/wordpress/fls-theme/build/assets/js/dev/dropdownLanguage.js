document.addEventListener("DOMContentLoaded", () => {
  const dropdownButton = document.getElementById("languageDropdown");
  const languageList = document.getElementById("languageList");
  const arrowIcon = document.getElementById("arrowIcon");
  if (!dropdownButton || !languageList || !arrowIcon) return;
  const languageContainer = document.querySelector(".preheader__lang");
  const navWrapper = document.querySelector(".nav__wrapper");
  const moveLanguageDropdown = () => {
    if (!languageContainer || !navWrapper) return;
    if (window.innerWidth <= 980) {
      if (!navWrapper.contains(dropdownButton)) {
        navWrapper.insertBefore(
          dropdownButton,
          document.querySelector(".menu__mob-btn")
        );
      }
    } else {
      if (!languageContainer.contains(dropdownButton)) {
        languageContainer.appendChild(dropdownButton);
      }
    }
  };
  moveLanguageDropdown();
  window.addEventListener("resize", moveLanguageDropdown);
  dropdownButton.addEventListener("click", () => {
    toggleDropdown(languageList, arrowIcon);
  });
  document.addEventListener("click", (event) => {
    const isClickInside = dropdownButton.contains(event.target) || languageList.contains(event.target);
    if (!isClickInside) {
      closeDropdown(languageList, arrowIcon);
    }
  });
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeDropdown(languageList, arrowIcon);
    }
  });
});
const toggleDropdown = (list, arrowIcon) => {
  if (list.classList.contains("open")) {
    closeDropdown(list, arrowIcon);
  } else {
    list.classList.add("open");
    arrowIcon.classList.add("rotate");
  }
};
const closeDropdown = (list, arrowIcon) => {
  list.classList.remove("open");
  arrowIcon.classList.remove("rotate");
};
