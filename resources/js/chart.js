import Ch from "chart.js/auto";

const Chart = (({
    canvas: canvas,
    label: label,
    title: title,
    type: type,
    dataset: dataset,
}) => {
    let options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            // title: {
            //     display: true,
            //     text: title,
            //     font: {
            //         size: 20,
            //         weight: 600,
            //     }
            // }
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 10
                }
            }
        }
    };
    let data = {};
    data.labels = Object.keys(dataset);

    switch (type) {
        case 'line':
            data.datasets = [{
                label: label,
                data: dataset,
                fill: false,
                tension: 0.3,
            }];
            options.scales = {
                y: {
                    beginAtZero: true,
                }
            };
            break;
        case 'doughnut':
            data.datasets = [{
                label: label,
                data: Object.values(dataset),
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4,
            }];
            break;
        default:
            return false;
    }
    
    return new Ch(canvas.get(0), {
        type: type,
        data: data,
        options: options,
    });
});

export default {
    Chart: Chart,
}