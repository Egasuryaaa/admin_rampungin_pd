document.addEventListener('DOMContentLoaded', function() {
    // Fallback function for charts
    function initializeChartWithFallback(elementId, options) {
        try {
            const element = document.querySelector(elementId);
            if (element && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(element, options);
                chart.render();
            }
        } catch (error) {
            console.warn(`Chart initialization failed for ${elementId}:`, error);
        }
    }

    // Default options for charts
    const defaultOptions = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Data',
            data: [0, 0, 0, 0]
        }],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr']
        }
    };

    // Initialize charts with fallback
    ['#payment-records-chart', '#total-sales-color-graph', '#task-completed-area-chart', '#new-tasks-area-chart', '#leads-overview-donut'].forEach(chartId => {
        initializeChartWithFallback(chartId, defaultOptions);
    });
});