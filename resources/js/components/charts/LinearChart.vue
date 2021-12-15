<template>
    <div>
        <h3>Cervezas y ganancias</h3>
        <select id="periodo" @change="updateChart(periodo)" v-model="periodo">
            <option value="1">Por día</option>
            <option value="30">Por mes</option>
        </select>
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
                        enabled: false
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
            periodo: '1',
        }
    },
    mounted() {

    }
}
</script>
