class LineChart {
    constructor () {
        this.init()
    }

    init () {
        this.lineChart()
    }

    lineChart () {
        $.ajax({
            url: '/line-chart',
            method: 'GET',
            success: function (response) {
                const data = {
                    type: 'line',
                    data: {
                        labels: response.months,
                        datasets: [{
                            label: 'Beneficios',
                            backgroundColor: Looper.colors.brand.purple,
                            borderColor: Looper.colors.brand.purple,
                            data: response.data,
                            fill: false,
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Beneficios'
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    let label = `Beneficios: ${data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '0'}`;
                                    if (label) {
                                        label += '€';
                                    }
                                    return label;
                                }
                            }
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                ticks: {
                                    maxRotation: 0,
                                    maxTicksLimit: 5
                                }
                            }]
                        }
                    }
                };

                // init chart line
                const canvas = $('#canvas-line-chart')[0].getContext('2d')
                new Chart(canvas, data)
            }
        })
    }
}

$(document).ready(() => {
    new LineChart()
});