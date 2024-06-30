let restChart;

// Fetch data and update chart/table
function fetchRestData() {
  fetch("get_rest.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("Fetched data:", data); // Debugging

      // Ensure data is always treated as an array
      if (!Array.isArray(data)) {
        if (data !== null && typeof data === "object") {
          // If data is a single object, convert it to an array
          data = [data];
        } else {
          throw new Error("Fetched data is neither an array nor an object");
        }
      }

      const splits = data.map((item) => item.Split);
      const time = data.map((item) => item.Zeit);
      const rest = data.map((item) => parseInt(item.Rest, 10));

      let today = new Date();
      let differences = [];

      for (let i = 0; i < time.length; i++) {
        // Datum aus dem Array
        let dateFromArray = new Date(time[i]);

        // Differenz in Millisekunden berechnen
        let differenceMs = today - dateFromArray;

        // Differenz in Minuten umrechnen und zur Liste hinzufügen
        let differenceMinutes = Math.floor(differenceMs / 60000);
        differences.push(differenceMinutes);
      }

      console.log(splits); // ["Push", "Pull", ...]
      console.log(time);
      console.log(rest); // [72, 85, ...]
      console.log(differences);

      var restOptions = {
        series: differences,
        chart: {
          height: 390,
          type: "radialBar",
        },
        plotOptions: {
          radialBar: {
            offsetY: 0,
            startAngle: 0,
            endAngle: 270,
            hollow: {
              margin: 5,
              size: "30%",
              background: "transparent",
              image: undefined,
            },
            dataLabels: {
              name: {
                show: false,
              },
              value: {
                show: false,
              },
            },
            track: {
              show: true,
              background: "#f2f2f2",
              strokeWidth: "97%",
              opacity: 1,
              margin: 5, // margin is in pixels
              dropShadow: {
                enabled: true,
                top: 2,
                left: 0,
                blur: 4,
                opacity: 0.15,
              },
            },
          },
        },
        colors: ["#f39f1857"], //, "#f39f1896", "#f39†1868", "#f39†18"],
        labels: splits,
        responsive: [
          {
            breakpoint: 480,
            options: {
              chart: {
                height: 320,
              },
              legend: {
                show: false,
              },
            },
          },
        ],
      };

      if (restChart) {
        restChart.updateOptions(restOptions);
      } else {
        restChart = new ApexCharts(
          document.querySelector("#rest"),
          restOptions,
        );
        restChart.render();
      }
    })
    .catch((error) => console.error("Error fetching data:", error));
}

// Load initial data
document.addEventListener("DOMContentLoaded", () => {
  console.log("Document loaded. Fetching data...");
  fetchRestData();
});
