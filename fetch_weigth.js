let weigthChart;

// Fetch data and update chart/table
function fetchWeigthData() {
  fetch("get_weigth.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("weigth: Fetched data:", data); // Debugging

      // Ensure data is always treated as an array
      if (!Array.isArray(data)) {
        if (data !== null && typeof data === "object") {
          // If data is a single object, convert it to an array
          data = [data];
        } else {
          throw new Error("Fetched data is neither an array nor an object");
        }
      }

      const weights = data.map((item) => item.gewicht);
      const dates = data.map((item) => item.datum);

      var weigthOptions = {
        series: [
          {
            name: "Weight",
            data: weights,
          },
        ],
        chart: {
          height: 350,
          type: "line",
        },
        xaxis: {
          categories: dates,
          type: "datetime",
        },
        title: {
          text: "Weight Over Time",
          align: "left",
        },
      };

      if (weigthChart) {
        weigthChart.updateOptions(weigthOptions);
      } else {
        weigthChart = new ApexCharts(
          document.querySelector("#weigth"),
          weigthOptions,
        );
        weigthChart.render();
      }
    })
    .catch((error) => console.error("Error fetching data:", error));
}

// Load initial data
document.addEventListener("DOMContentLoaded", () => {
  console.log("Document loaded. Fetching data...");
  fetchWeigthData();
});
