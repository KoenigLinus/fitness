let weightChart;

// Fetch data and update chart/table
function fetchWeightData() {
  fetch("get_weight.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("weight: Fetched data:", data); // Debugging

      // Ensure data is always treated as an array
      if (!Array.isArray(data)) {
        if (data !== null && typeof data === "object") {
          // If data is a single object, convert it to an array
          data = [data];
        } else {
          throw new Error("Fetched data is neither an array nor an object");
        }
      }

      const dates = data.map((item) => item.datum);
      const weights = data.map((item) => item.gewicht);

      var weightOptions = {
        series: [
          {
            name: "Gewicht",
            data: weights,
          },
        ],
        chart: {
          type: "area",
          height: 350,
          zoom: {
            enabled: false,
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "straight",
        },
        labels: dates,
        xaxis: {
          type: "datetime",
        },
        yaxis: {
          opposite: true,
        },
        legend: {
          horizontalAlign: "left",
        },
      };

      if (weightChart) {
        weightChart.updateOptions(weightOptions);
      } else {
        weightChart = new ApexCharts(
          document.querySelector("#weight"),
          weightOptions,
        );
        weightChart.render();
      }
    })
    .catch((error) => console.error("Error fetching data:", error));
}

// Load initial data
document.addEventListener("DOMContentLoaded", () => {
  console.log("Document loaded. Fetching data...");
  fetchWeightData();
});
