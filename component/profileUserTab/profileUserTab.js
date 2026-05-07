function confirmDelete(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this action!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Delete",
    cancelButtonText: "Cancel",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`profile.php?id=${id}`)
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            Swal.fire({
              title: "Deleted!",
              text: data.msg,
              icon: "success",
              showConfirmButton: false, 
              timerProgressBar: true,
              timer: 1500,
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Failed!",
              text: data.msg,
              icon: "error",
              confirmButtonColor: "#d33",
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          Swal.fire("Error!", "Server request failed.", "error");
        });
    }
  });
}

function confirmReset(userId, fullName) {
  Swal.fire({
    title: "Are you sure?",
    text: `You want to reset the password for ${fullName}?`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    reverseButtons: true,
    cancelButtonText: "Cancel",
    confirmButtonText: "Reset",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(
        `profile.php?reset_id=${userId}&full_name=${encodeURIComponent(fullName)}`,
      )
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            Swal.fire({
              icon: "success",
              title: "Success!",
              text: data.msg,
              showConfirmButton: false,
              timer: 2000,
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error!",
              text: data.msg,
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          Swal.fire("Error!", "Failed to process request.", "error");
        });
    }
  });
}
