document.addEventListener("DOMContentLoaded", (event) => {
  fetch("get_workout.php")
    .then((response) => response.json())
    .then((data) => {
      const container = document.querySelector(".latest-workouts");

      if (data.message) {
        container.innerHTML = `<div>${data.message}</div>`;
      } else {
        data.forEach((item) => {
          const workoutDiv = document.createElement("div");
          workoutDiv.className = "box workout-l";

          const splitDiv = document.createElement("div");
          splitDiv.textContent = item.split;
          const zeitDiv = document.createElement("div");
          zeitDiv.textContent = item.zeit;

          workoutDiv.appendChild(splitDiv);
          workoutDiv.appendChild(zeitDiv);

          container.appendChild(workoutDiv);
        });
      }
    })
    .catch((error) => console.error("Error:", error));
});
