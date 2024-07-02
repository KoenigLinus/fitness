let gainChart;

// Daten für das Diagramm abrufen und Diagramm/Tabelle aktualisieren
function fetchgainData() {
  fetch("get_gain.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("Gain: Fetched data:", data);

      if (!Array.isArray(data)) {
        if (data !== null && typeof data === "object") {
          // If data is a single object, convert it to an array
          data = [data];
        } else {
          throw new Error("Fetched data is neither an array nor an object");
        }
      }

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
          categories: zeit, // assuming `zeit` has the dates for categories
          labels: {
            show: false, // Versteckt die Beschriftungen der y-Achse
          },
        },
        yaxis: {
          labels: {
            show: false, // Versteckt die Beschriftungen der y-Achse
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val.toFixed(2); // assuming `volumen` is not in percentage
            },
          },
        },
      };

      if (gainChart) {
        gainChart.updateOptions(gainOptions);
      } else {
        gainChart = new ApexCharts(
          document.querySelector("#gain"),
          gainOptions,
        );
        gainChart.render();
      }
    })
    .catch((error) => console.error("Error fetching data:", error));
}

// Initiale Daten laden
document.addEventListener("DOMContentLoaded", () => {
  console.log("Document loaded. Fetching data...");
  fetchgainData();
});
