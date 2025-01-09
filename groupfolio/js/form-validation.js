document
  .getElementById("profile_image")
  .addEventListener("change", function () {
    const fileInput = this;
    const formData = new FormData(document.getElementById("imageUploadForm"));
    const progressBar = document.querySelector(".progress-bar");
    const progressContainer = document.getElementById("upload-progress");
    const errorContainer = document.getElementById("upload-error");

    progressContainer.style.display = "block";
    errorContainer.style.display = "none";

    fetch("../upload/upload_image.php", {
      // Assuming the upload PHP is in this path
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          // Update profile image preview
          document.getElementById("profileImageDisplay").src = data.imagePath; // Update the src of the image
          progressBar.style.width = "100%";
          progressBar.setAttribute("aria-valuenow", "100");
        } else {
          errorContainer.textContent = data.message;
          errorContainer.style.display = "block";
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        errorContainer.textContent = "An unexpected error occurred.";
        errorContainer.style.display = "block";
      })
      .finally(() => {
        setTimeout(() => {
          progressContainer.style.display = "none";
        }, 3000);
      });
  });

document
  .getElementById("imageUploadForm")
  .addEventListener("submit", function () {
    document.getElementById("upload-progress").style.display = "block"; // Show progress bar
  });
const contactInput = document.getElementById("contact");
const form = document.querySelector(".needs-validation");

form.addEventListener("submit", function (event) {
  if (!/^[0-9]{11}$/.test(contactInput.value)) {
    // Check pattern using JavaScript before submission
    event.preventDefault();
    event.stopPropagation();
    contactInput.classList.add("is-invalid"); // Show invalid feedback
  } else {
    contactInput.classList.remove("is-invalid");
  }

  form.classList.add("was-validated");
});
// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  "use strict";

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll(".needs-validation");

  // Loop over them and prevent submission
  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();
