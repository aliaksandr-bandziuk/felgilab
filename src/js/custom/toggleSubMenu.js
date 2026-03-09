document.addEventListener('DOMContentLoaded', () => {

  const menuItems = document.querySelectorAll('.menu__item.menu__has-submenu');

  const closeAllSubMenus = () => {
    document.querySelectorAll('.menu__sub-list.menu__sub-list--open').forEach(subList => {
      subList.classList.remove('menu__sub-list--open');
    });
    document.querySelectorAll('.menu__arrow--rotated').forEach(arrow => {
      arrow.classList.remove('menu__arrow--rotated');
    });
  };

  menuItems.forEach(menuItem => {
    const subList = menuItem.querySelector('.menu__sub-list');
    const arrow = menuItem.querySelector('.menu__arrow');

    // События для десктопа
    menuItem.addEventListener('mouseenter', () => {
      closeAllSubMenus();

      if (subList) {
        subList.classList.add('menu__sub-list--open');
      }
      if (arrow) {
        arrow.classList.add('menu__arrow--rotated');
      }
    });

    menuItem.addEventListener('mouseleave', () => {
      if (subList) {
        subList.classList.remove('menu__sub-list--open');
      }
      if (arrow) {
        arrow.classList.remove('menu__arrow--rotated');
      }
    });

    // Обработчик клика для мобильных устройств
    if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
      menuItem.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();

        // Если подменю уже открыто, закрываем его, иначе открываем и закрываем все остальные
        if (subList && subList.classList.contains('menu__sub-list--open')) {
          subList.classList.remove('menu__sub-list--open');
          if (arrow) {
            arrow.classList.remove('menu__arrow--rotated');
          }
        } else {
          closeAllSubMenus();
          if (subList) {
            subList.classList.add('menu__sub-list--open');
          }
          if (arrow) {
            arrow.classList.add('menu__arrow--rotated');
          }
        }
      });
    }
  });

  // Закрытие подменю при нажатии Escape
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeAllSubMenus();
    }
  });

  // Закрытие подменю при клике вне области меню
  document.addEventListener('click', (event) => {
    const isClickInside = Array.from(menuItems).some(menuItem => menuItem.contains(event.target));
    if (!isClickInside) {
      closeAllSubMenus();
    }
  });
});
