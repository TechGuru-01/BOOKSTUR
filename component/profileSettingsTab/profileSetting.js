document.addEventListener("DOMContentLoaded", function () {
  const changePasswordForm = document.getElementById("changePasswordForm");

  if (changePasswordForm) {
    changePasswordForm.addEventListener("submit", function (e) {
      e.preventDefault();

      // Confirmation lang ang ititira natin sa frontend
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want to update your password?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#d33",
        confirmButtonText: "Update",
        reverseButtons: true,
        customClass: { container: "high-z-index" },
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData(this);
          formData.append("action", "change_password");

          fetch("profile.php", {
            method: "POST",
            body: formData,
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.status === "success") {
                Swal.fire({
                  icon: "success",
                  title: "Updated!",
                  text: data.msg,
                  showConfirmButton: false,
                  timer: 2000,
                  customClass: { container: "high-z-index" },
                }).then(() => changePasswordForm.reset());
              } else {
                // Ang errors dito ay galing na mismo sa PHP validation mo (min length, special chars, etc.)
                Swal.fire({
                  icon: "error",
                  title: "Update Failed",
                  text: data.msg, // Dito lalabas yung "Password should atleast be 8 characters long", etc.
                  showConfirmButton: false,
                  timer: 2500,
                  timerProgressBar: true,
                  customClass: { container: "high-z-index" },
                });
              }
            })
            .catch((err) => {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "System connection error.",
                showConfirmButton: false,
                timer: 2000,
                customClass: { container: "high-z-index" },
              });
            });
        }
      });
    });
  }
});
