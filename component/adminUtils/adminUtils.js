const launcherBtn = document.getElementById("launcherBtn");
const ubuntuMenu = document.getElementById("ubuntuMenu");

if (launcherBtn && ubuntuMenu) {
  launcherBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    ubuntuMenu.classList.toggle("active");
  });

  document.addEventListener("click", () => {
    ubuntuMenu.classList.remove("active");
  });
}
