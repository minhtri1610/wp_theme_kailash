document.addEventListener("DOMContentLoaded", () => {
  // Lấy tất cả các phần tử
  const toggleButton = document.getElementById("mobile-menu-button");
  const mobileMenu = document.getElementById("mobile-menu");
  const iconHamburger = document.getElementById("icon-hamburger");
  const iconClose = document.getElementById("icon-close");
  const wapperMenu = document.getElementById("mobile-list-item");

  // Kiểm tra xem mọi thứ có tồn tại không
  if (toggleButton && mobileMenu && iconHamburger && iconClose) {
    // Thêm sự kiện click
    toggleButton.addEventListener("click", () => {
      // 1. Toggle panel menu
      wapperMenu.classList.toggle("hidden");
      
      // 2. Toggle icon hamburger
      iconHamburger.classList.toggle("hidden");
      
      // 3. Toggle icon "X"
      iconClose.classList.toggle("hidden");
    });
  }
});
