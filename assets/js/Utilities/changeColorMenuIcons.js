export function changeColorMenuIcons() {
  const menuIcons = document.getElementsByClassName('menu-icon');
  if (menuIcons) {
    const menuIconsArray = Array.from(menuIcons);
    menuIconsArray.forEach((menuIconElement) => {
      menuIconElement.classList.add('menu-icon-blackened');
    });
  }
}
