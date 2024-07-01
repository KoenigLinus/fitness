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
      const splits = data.map((item) => item.split);
      const volumen = data.map((item) => item.volumen);

      const gainOptions = {
        series: splits.map((split, index) => ({
          name: split,
          data: volumen[index],
        })),
        chart: {
          type: "line",
          height: 350,
        },
        dataLabels: {
          enabled: false,
        },
        xaxis: {
          categories: zeit, //data.map((item) => item.Date), // assuming `data` has a `Date` field for categories
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val.toFixed(2) + "%";
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
