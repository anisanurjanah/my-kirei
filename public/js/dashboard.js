/* globals Chart:false */

(() => {
    'use strict'

    // Graphs
    const ctx = document.getElementById('outletSalesChart')
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Menu Terjual',
                data: chartData,
                backgroundColor: '#C60E2A',
                barThickness: 48,
                borderRadius: {
                    topLeft: 4,
                    topRight: 4,
                    bottomLeft: 0,
                    bottomRight: 0
                },
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
                    ticks: {
                        stepSize: 20,
                    },
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
})();

(() => {
    const canvas = document.getElementById('orderLineChart');
    if (!canvas) return;

    const outletLinks = document.querySelectorAll('.outlet-filter');
    const ctx = canvas.getContext('2d');
    let chart;

    function renderChart(labels, data) {
        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Pesanan per Hari',
                    data: data,
                    fill: false,
                    borderColor: '#C60E2A',
                    tension: 0.5,
                    pointBackgroundColor: '#C60E2A',
                    pointBorderColor: '#C60E2A',
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
                            text: 'Jumlah Pesanan'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
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
        });
    }

    outletLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const outletId = this.dataset.outletId;
            const outletName = this.textContent.trim();
            const activeLink = document.querySelector('.outlet-filter.active');
            const outletNameTitle = document.getElementById('selectedOutletNameTitle');
            const outletNameDropdown = document.getElementById('selectedOutletNameDropdown');

            outletLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            if (outletNameTitle) outletNameTitle.textContent = outletName;
            if (outletNameDropdown) outletNameDropdown.textContent = outletName;

            fetch(`/dashboard/orders-by-outlet?outlet_id=${outletId}`)
                .then(response => response.json())
                .then(result => {
                    renderChart(result.labels, result.data);
                })
                .catch(error => {
                    console.error('Error fetching outlet data:', error);
                });
        });
    });

    if (outletLinks.length > 0) {
        const defaultLink = document.querySelector('.outlet-filter[data-outlet-id="1"]');
        if (defaultLink) {
            defaultLink.classList.add('active');
            const outletName = defaultLink.textContent.trim();
            const outletNameTitle = document.getElementById('selectedOutletNameTitle');
            const outletNameDropdown = document.getElementById('selectedOutletNameDropdown');

            if (outletNameTitle) outletNameTitle.textContent = outletName;
            if (outletNameDropdown) outletNameDropdown.textContent = outletName;

            fetch(`/dashboard/orders-by-outlet?outlet_id=1`)
                .then(response => response.json())
                .then(result => {
                    renderChart(result.labels, result.data);
                })
                .catch(error => {
                    console.error('Error fetching default outlet data:', error);
                });
            }
    } else {
        renderChart(chartOrderLabels, chartOrderData);
    }
})();
