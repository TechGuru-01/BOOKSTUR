// adminUtils.js

const launcherBtn = document.getElementById("launcherBtn");
const ubuntuMenu = document.getElementById("ubuntuMenu");

// CHECK FIRST: Siguraduhin na hindi null ang mga elements bago lagyan ng listener
if (launcherBtn && ubuntuMenu) {
  launcherBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    ubuntuMenu.classList.toggle("active");
  });

  document.addEventListener("click", () => {
    ubuntuMenu.classList.remove("active");
  });
}

function confirmLogout() {
  // Mas mainam na gamitin ang SweetAlert2 dito dahil may import ka na nito sa profile.php
  Swal.fire({
    title: "Logout?",
    text: "Are you sure you want to logout?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, logout",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "/BOOKSTUR/component/adminUtils/logout.php";
    }
  });
}
