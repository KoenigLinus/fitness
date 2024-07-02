let restChart;

function fetchRestData() {
  fetch("get_rest.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("Rest: Fetched data:", data); // Debugging

      if (data.error) { // Noch mehr debugging
        console.error("Error fetching data:", data.error);
        document.querySelector("#rest-error").innerText = data.error;
        return;
      }

      // Noch mehr debugging weil wenn data kein array ist schiebt data.map stress
      if (!Array.isArray(data)) {
        if (data !== null && typeof data === "object") {
          data = [data];
        } else {
          throw new Error("Fetched data is neither an array nor an object");
        }
      }

      const splits = data.map((item) => item.Split);
      const time = data.map((item) => item.Zeit);

      let today = new Date();
      let differences = [];

      for (let i = 0; i < time.length; i++) {
        let dateFromArray = new Date(time[i]);
        let differenceMs = today - dateFromArray;
        let differenceHours = Math.floor(100 - differenceMs / 60000 / 60);
        differences.push(differenceHours);
      }

      console.log("Rest: splits:", splits); 
      console.log("Rest: diffrences:", differences);

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
            barLabels: {
              enabled: true,
              useSeriesColors: true,
              margin: 8,
              fontSize: "16px",
              formatter: function (seriesName, opts) {
                return (
                  seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                );
              },
            },
          },
        },
        colors: ["#f39f18"],
        labels: splits,
        responsive: [
          {
            breakpoint: 480,
            options: {
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

document.addEventListener("DOMContentLoaded", () => {
  console.log("Document loaded. Fetching data...");
  fetchRestData();
});
