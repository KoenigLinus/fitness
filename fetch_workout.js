document.addEventListener("DOMContentLoaded", (event) => {
  fetch("path/to/your_php_script.php") // Adjust the path to your PHP script
    .then((response) => response.json())
    .then((data) => {
      const container = document.getElementById("workoutContainer");
      container.innerHTML = ""; // Clear any existing content

      if (data.message) {
        container.innerHTML = `<div>${data.message}</div>`;
      } else {
        data.forEach((item) => {
          const splitDiv = document.createElement("div");
          splitDiv.textContent = item.split;
          const zeitDiv = document.createElement("div");
          zeitDiv.textContent = item.zeit;

          container.appendChild(splitDiv);
          container.appendChild(zeitDiv);
        });
      }
    })
    .catch((error) => console.error("Error:", error));
});
