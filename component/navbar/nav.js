function updateNav(){
    const navbar = document.querySelector("nav");
    const isProfilePage = window.location.pathname.includes("profile.php");
    if (window.scrollY > 10 || isProfilePage) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
}
window.addEventListener("scroll", updateNav);
window.addEventListener("DOMContentLoaded", updateNav)