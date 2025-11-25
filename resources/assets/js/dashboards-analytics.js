'use strict';

(function () {
  const dataElement = document.getElementById('monthly-data');
  if (!dataElement) return;

  const monthlyData = JSON.parse(dataElement.textContent);

  const chartOptions = {
    chart: {
      height: 400,
      type: 'line',
      toolbar: { show: false }
    },
    series: [{
      name: 'Monthly Payments',
      data: monthlyData
    }],
    xaxis: {
      categories: [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
      ],
      title: { text: 'Month' }
    },
    yaxis: {
      title: { text: 'Amount (₱)' }
    },
    stroke: {
      width: 3,
      curve: 'smooth'
    },
    markers: {
      size: 5,
      colors: ['#7367f0'],
      strokeColors: '#ffffff',
      strokeWidth: 3,
      hover: { size: 7 }
    },
    tooltip: {
      y: {
        formatter: value => `₱${value.toLocaleString()}`
      }
    }
  };

  const chartEl = document.querySelector('#totalProfitLineChart');
  if (chartEl) {
    const chart = new ApexCharts(chartEl, chartOptions);
    chart.render();
  }
})();

(function () {
  const dataElement = document.getElementById('monthly-partial-data');
  if (!dataElement) return;

  const monthlyPartialData = JSON.parse(dataElement.textContent);
  console.log(monthlyPartialData);
  const chartOptions = {
    chart: {
      height: 400,
      type: 'line',
      toolbar: { show: false }
    },
    series: [{
      name: 'Monthly Payments',
      data: monthlyPartialData
    }],
    xaxis: {
      categories: [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
      ],
      title: { text: 'Month' }
    },
    yaxis: {
      title: { text: 'Amount (₱)' }
    },
    stroke: {
      width: 3,
      curve: 'smooth'
    },
    markers: {
      size: 5,
      colors: ['#7367f0'],
      strokeColors: '#ffffff',
      strokeWidth: 3,
      hover: { size: 7 }
    },
    tooltip: {
      y: {
        formatter: value => `₱${value.toLocaleString()}`
      }
    }
  };

  const chartEl = document.querySelector('#totalProfitLineChartPartial');
  if (chartEl) {
    const chart = new ApexCharts(chartEl, chartOptions);
    chart.render();
  }
})();
  // ==========================
  // Customer Satisfaction Gauge
  // ==========================
  const satisfactionEl = document.querySelector('#customerSatisfactionGauge');
  if (satisfactionEl) {
    const satisfactionScore = JSON.parse(document.getElementById('satisfaction-score').textContent);
    const gaugeOptions = {
      chart: {
        type: 'radialBar',
        height: 300,
        sparkline: { enabled: true }
      },
      series: [satisfactionScore],
      labels: ['Satisfaction'],
      plotOptions: {
        radialBar: {
          hollow: { size: '65%' },
          dataLabels: {
            name: { show: true },
            value: {
              formatter: val => `${val}%`,
              fontSize: '24px'
            }
          }
        }
      },
      colors: ['#FFB400']
    };
    new ApexCharts(satisfactionEl, gaugeOptions).render();
  }

  // ==========================
  // Revenue by Category (Bar)
  // ==========================
    // ==========================
  // Revenue by Category (Rooms vs Cottages)
  // ==========================
  const categoryEl = document.querySelector('#revenueByCategoryChart');
  if (categoryEl) {
    const categoryData = JSON.parse(document.getElementById('revenue-category-data').textContent);
    const categories = Object.keys(categoryData);
    const values = Object.values(categoryData);

    const categoryChartOptions = {
      chart: { type: 'bar', height: 320 },
      series: [{ name: 'Revenue', data: values }],
      xaxis: { categories },
      colors: ['#28C76F', '#00CFE8'], // Green for Rooms, Blue for Cottages
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '50%',
          borderRadius: 6,
        }
      },
      dataLabels: {
        enabled: true,
        formatter: val => `₱${val.toLocaleString()}`,
        style: { fontSize: '13px', colors: ['#333'] }
      },
      tooltip: {
        y: { formatter: val => `₱${val.toLocaleString()}` }
      },
      grid: {
        borderColor: '#e7e7e7',
        row: { colors: ['#f9f9f9', 'transparent'], opacity: 0.5 },
      }
    };

    new ApexCharts(categoryEl, categoryChartOptions).render();
  }


  // ==========================
  // Refunds / Cancellations Chart
  // ==========================
  const refundsEl = document.querySelector('#refundsChart');
  if (refundsEl) {
    const refundsData = JSON.parse(document.getElementById('refunds-data').textContent);
    const refundsChartOptions = {
      chart: { type: 'area', height: 300, toolbar: { show: false } },
      series: [{ name: 'Refunds / Cancellations', data: refundsData }],
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      },
      colors: ['#EA5455'],
      fill: { type: 'gradient', gradient: { shadeIntensity: 0.6, opacityFrom: 0.7, opacityTo: 0.3 } },
      tooltip: {
        y: { formatter: val => `₱${val.toLocaleString()}` }
      },
      grid: {
        borderColor: '#e7e7e7',
        row: { colors: ['#f9f9f9', 'transparent'], opacity: 0.5 }
      }
    };
    new ApexCharts(refundsEl, refundsChartOptions).render();
  }

    // ==========================
  // Average Revenue per Reservation Sparkline
  // ==========================
  const avgEl = document.querySelector('#avgRevenueSparkline');
  if (avgEl) {
    const avgData = JSON.parse(document.getElementById('avg-revenue-data').textContent);
    const sparkOptions = {
      chart: {
        type: 'area',
        height: 120,
        sparkline: { enabled: true }
      },
      series: [{ data: avgData }],
      colors: ['#28C76F'],
      stroke: { width: 2.5, curve: 'smooth' },
      fill: { opacity: 0.3 },
      tooltip: {
        y: { formatter: val => `₱${val.toLocaleString()}` }
      }
    };
    new ApexCharts(avgEl, sparkOptions).render();
  }

  