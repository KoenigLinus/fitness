let gainChart;

function fetchgainData() {
  fetch("get_gain.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("Gain: Fetched data:", data);

      // Wenn data kein Array ist, mach es zum Array, weil sonst schiebt data.map(item) stress
      if (!Array.isArray(data)) {
        if (data !== null && typeof data === "object") {
          data = [data];
        } else {
          throw new Error("Fetched data is neither an array nor an object");
        }
      }

      // map data in zeit und split
      const zeit = data.map((item) => item.zeit);
      const splits = [...new Set(data.map((item) => item.split))];

      // Prepare the series data
      const seriesData = splits.map((split) => {
        return {
          name: split,
          data: data
            .filter((item) => item.split === split)
            .map((item) => item.volumen),
        };
      });

      const gainOptions = {
        series: seriesData,
        chart: {
          type: "line",
          height: 350,
        },
        dataLabels: {
          enabled: false,
        },
        xaxis: {
          categories: zeit, 
          labels: {
            show: false, 
          },
        },
        yaxis: {
          labels: {
            show: false, 
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val.toFixed(2); 
            },
          },
        },
      };

      if (gainChart) { // Wenn es schon gain chart gitb dann update
        gainChart.updateOptions(gainOptions);
      } else { // wenn nicht dann mach neu
        gainChart = new ApexCharts(
          document.querySelector("#gain"),
          gainOptions,
        );
        gainChart.render();
      }
    })
    .catch((error) => console.error("Error fetching data:", error));
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("Document loaded. Fetching data...");
  fetchgainData();
});
