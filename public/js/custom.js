// Inisialisasi grafik setelah DOM siap
document.addEventListener('DOMContentLoaded', function() {
    // Data dari server
    var usersData = JSON.parse(document.getElementById('usersData').textContent);
    var booksData = JSON.parse(document.getElementById('booksData').textContent);
    var loansData = JSON.parse(document.getElementById('loansData').textContent);

    // Users Chart
    var usersChart = echarts.init(document.getElementById('usersChart'));
    var usersOption = {
        title: {
            text: 'Users by Role'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            top: '5%',
            left: 'center'
        },
        series: [
            {
                name: 'Users',
                type: 'pie',
                radius: '50%',
                data: usersData,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    usersChart.setOption(usersOption);

    // Books Chart
    var booksChart = echarts.init(document.getElementById('booksChart'));
    var booksOption = {
        title: {
            text: 'Books Overview'
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: {
            type: 'category',
            data: booksData.categories
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: booksData.counts,
                type: 'bar',
                itemStyle: {
                    color: '#5470C6'
                },
                animationDelay: function (idx) {
                    return idx * 10;
                }
            }
        ],
        animationEasing: 'elasticOut',
        animationDelayUpdate: function (idx) {
            return idx * 5;
        }
    };
    booksChart.setOption(booksOption);

    // Loans Chart
    var loansChart = echarts.init(document.getElementById('loansChart'));
    var loansOption = {
        title: {
            text: 'Loans Overview'
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: {
            type: 'category',
            data: loansData.dates
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: loansData.counts,
                type: 'line',
                smooth: true,
                itemStyle: {
                    color: '#91CC75'
                },
                animationDelay: function (idx) {
                    return idx * 10;
                }
            }
        ],
        animationEasing: 'elasticOut',
        animationDelayUpdate: function (idx) {
            return idx * 5;
        }
    };
    loansChart.setOption(loansOption);

    // Responsif
    window.addEventListener('resize', function() {
        usersChart.resize();
        booksChart.resize();
        loansChart.resize();
    });
});