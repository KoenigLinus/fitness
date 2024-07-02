let weightChart;

function fetchWeightData() {
  fetch("get_weight.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("weight: Fetched data:", data); // Debugging

      // Schauen Sie sich die Kommies der anderen fetch_*.js an dies sind besser
      if (!Array.isArray(data)) {
        if (data !== null && typeof data === "object") {
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

// Halt nur wenn document gelanden ist
document.addEventListener("DOMContentLoaded", () => {
  console.log("Document loaded. Fetching data...");
  fetchWeightData();
});
