window.addEventListener("DOMContentLoaded", (event) => {
    console.log("DOM entièrement chargé et analysé");

    /****************************************************************************************************************************************
     * Orders chart.
     ***************************************************************************************************************************************/
    const el = document.getElementById('chartOrders');
    console.log(vars);
    console.log(vars.soldTotalByDay);
    const data = {

        categories: [
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9'
        ],

        series: [{
            name: 'Couts',
            data: vars.purchasedTotalByDay,
        }, {
            name: 'Ventes',
            data: vars.soldTotalByDay,
        }],
    };

    const options = {
        chart: { title: '', width: 600, height: 400 },
        xAxis: { pointOnColumn: false, title: { text: '' } },
        yAxis: { title: '' },
    };

    const chart = toastui.Chart.lineChart({ el, data, options });



    const el1 = document.getElementById('chartConection');

    const dataConnexionLogByHour = {
        categories: ['Connection'],
        series: [{ "name": 12.4, "data": 41 }, { "name": 12, "data": 412 }]

    }

    const optionsConnexionLog = {
        chart: {
            title: 'Consultation du site',
            width: 400,
            height: 400
        },
        legend: {
            visible: false
        },
        series: {
            dataLabels: {
                visible: true,
                anchor: 'outer',

            },
            radiusRange: {
                inner: '60%',
                outer: '100%',
            }
        }

    };
    const chartConection = toastui.Chart.pieChart({ el: el1, data: dataConnexionLogByHour, options: optionsConnexionLog });

});