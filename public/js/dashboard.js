/* globals Chart:false */

(() => {
    'use strict'

    // Graphs
    const ctx = document.getElementById('myChart')
    if (!ctx) return;

    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Menu Terjual (Hari Ini)',
                data: chartData,
                backgroundColor: '#C60E2A',
                barThickness: 48,
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Menu Terjual'
                    },
                    // ticks: {
                    //     stepSize: 20,
                    // },
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Outlet'
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 30
                    },
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 8
                }
            }
        }
    })
})()
