function showLogoutModal() {
  document.getElementById("logoutModal").classList.add("active");
  document.body.style.overflow = "hidden";
}

function hideLogoutModal() {
  document.getElementById("logoutModal").classList.remove("active");
  document.body.style.overflow = "auto";
}

window.onclick = function (event) {
  const modal = document.getElementById("logoutModal");
  if (event.target == modal) {
    hideLogoutModal();
  }
};
