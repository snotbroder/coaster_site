// Hamburgermenu, generated with claude
document.addEventListener("DOMContentLoaded", function () {
  const burgerBtn = document.getElementById("burger-btn");
  const mobileMenu = document.getElementById("mobile-menu");
  const lines = burgerBtn.querySelectorAll(".burger-line");
  let isOpen = false;

  function setOpen(open) {
    isOpen = open;
    if (open) {
      mobileMenu.classList.remove("hidden");
    } else {
      mobileMenu.classList.add("hidden");
    }
    burgerBtn.setAttribute("aria-expanded", String(open));
    lines[0].style.transform = open ? "translateY(8px) rotate(45deg)" : "";
    lines[1].style.transform = open ? "scaleX(0)" : "";
    lines[1].style.opacity = open ? "0" : "";
    lines[2].style.transform = open ? "translateY(-8px) rotate(-45deg)" : "";
  }

  burgerBtn.addEventListener("click", function () {
    setOpen(!isOpen);
  });

  window.addEventListener("resize", function () {
    if (window.innerWidth >= 768 && isOpen) {
      setOpen(false);
    }
  });
});
