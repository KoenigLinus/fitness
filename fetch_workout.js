document.addEventListener("DOMContentLoaded", (event) => {
  fetch("get_workout.php")
    .then((response) => response.json())
    .then((data) => {
      // Der Äußerste Contrainer
      const container = document.querySelector(".latest-workouts");

      if (data.message) {
        // Wenn keine Daten vorhanden sind dann wird es halt ein Error sein
        container.innerHTML = `<div>${data.message}</div>`;
      } else {
        // Für jedes item
        data.forEach((item) => {
          const workoutDiv = document.createElement("div");
          workoutDiv.className = "box workout-l";
          // die orangene Box die man im html sieht

          // split
          const splitDiv = document.createElement("div");
          splitDiv.textContent = item.split;
          //zeit
          const zeitDiv = document.createElement("div");
          zeitDiv.textContent = item.zeit;

          // split und zeit kommen in die orangene box rein
          workoutDiv.appendChild(splitDiv);
          workoutDiv.appendChild(zeitDiv);

          // orangene box in den haupt container
          container.appendChild(workoutDiv);
        });
      }
    })
    .catch((error) => console.error("Error:", error));
});
