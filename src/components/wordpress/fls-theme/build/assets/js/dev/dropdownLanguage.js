document.addEventListener("DOMContentLoaded", () => {
  const dropdownButton = document.getElementById("languageBtn");
  const languageList = document.getElementById("languageList");
  const arrowIcon = document.getElementById("arrowIcon");
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
