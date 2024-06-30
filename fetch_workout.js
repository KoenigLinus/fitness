fetch("get_workout.php")
  .then((response) => response.json())
  .then((data) => {
    let list = document.getElementById("dynamicList");
    data.forEach((item) => {
      let listItem = document.createElement("li");

      // Datum formatieren
      let date = new Date(item.Date);
      let formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`;

      listItem.textContent = `${item.Split} - ${formattedDate}`;
      listItem.classList.add("workout"); // CSS-Klasse hinzufügen
      list.appendChild(listItem);
    });
  })
  .catch((error) => console.error("Error:", error));
