let gainChart;

// Daten für das Diagramm abrufen und Diagramm/Tabelle aktualisieren
function fetchgainData() {
  fetch("get_gain.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("Fetched data:", data);
      const splits = data.map((item) => item.Splits);
      const volume = data.map((item) =>
        item.Volume.map((v) => parseInt(v, 10)),
      );

      const gainOptions = {
        series: splits.map((split, index) => ({
          name: split,
          data: volume[index],
        })),
        chart: {
          type: "line",
          height: 350,
        },
        dataLabels: {
          enabled: false,
        },
        xaxis: {
          title: {
            text: "Gewinnrate (%)",
          },
          categories: data.map((item) => item.Date), // assuming `data` has a `Date` field for categories
        },
        yaxis: {
          title: {
            text: "Personen",
          },
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
          document.querySelector("#win-percentage-chart"),
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
