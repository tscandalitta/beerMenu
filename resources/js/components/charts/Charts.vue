<template>
    <div>
        <h3>Los 5 mas vendidos</h3>
        <select id="periodo" @change="updateChart(periodo)" v-model="periodo">
            <option value="1">día</option> <!-- en realidad son 24hs esto, deberia ser el acumulado del dia !-->
            <option value="7">semana</option>
            <option value="30">mes</option>
            <option value="365">año</option>
            <option value="">histórico</option>
        </select>
        <apexchart width="500" type="bar" :options="options" :series="series"></apexchart>
`    </div>

</template>

<script>
export default {
    data() {
        return {
            options: {
                chart: {
                    id: 'vuechart-example'
                },
                xaxis: {
                    categories: []
                },
                theme: {
                    palette: 'palette1' // upto palette10
                },
                plotOptions: {
                    bar: {
                        distributed: true
                    }
                },
            },
            series: [{
                name: 'series-1',
                data: []
            }],
            periodo: '1',
        }
    },
    methods: {
        refreshChart: function (data) {
            let newData = Object.values(data);
            this.series = [{
                data: newData
            }];
            let newCategories = Object.keys(data);
            this.options = {xaxis: { categories: newCategories}}
        },
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
        this.updateChart(this.periodo);
    }
}
</script>
