import Chart from "chart.js/auto";

const dati = {
    labels: labels,
    datasets: [
        {
            label: "Messaggi",
            backgroundColor: "rgb(255, 99, 132)",
            borderColor: "rgb(255, 99, 132)",
            data: messages,
        },
        {
            label: "Visualizzazioni",
            backgroundColor: "rgb(0, 0, 0)",
            borderColor: "rgb(0, 0, 0)",
            data: views,
        },
    ],
};

const config = {
    type: "line",
    data: dati,
    options: {},
};

new Chart(document.getElementById("myChart"), config);
