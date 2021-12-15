<template>
    <div>
        <h3>Cervezas y ganancias</h3>
        <apexchart width="500" type="line" :options="options" :series="series"></apexchart>
        `    </div>
</template>

<script>
export default {

    data() {
        return {
            series: [{
                name: "Cervezas",
                type: 'line',
                data: [1,2,3,4,5,6],
            }, {
                name: "Ganancias",
                type: 'line',
                data: [5,6,7,8,9,10],
            }],
            options: {
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    toolbar: {
                        autoSelected: 'zoom'
                    }
                },
                labels: ['a','b','c','d','e','f'],
                stroke: {
                    curve: 'smooth',
                },
                xaxis: {
                    categories: [],
                },
                yaxis: [{
                    title: {
                        text: 'Items',
                    },
                }, {
                    opposite: true,
                    title: {
                        text: 'Pesos $',
                    },
                }],
            },
        }
    },
    methods: {
        updateChart: function (periodo) {
            axios
                .get('/api/items-summary', {
                    params: {
                        days: periodo,
                    }
                })
                .then(response => {
                    this.refreshChart(response['data']);
                })
                .catch(error => console.error(error));
        },
    },
    mounted() {
        //this.updateChart();
    }
}
</script>
