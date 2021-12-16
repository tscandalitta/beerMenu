<template>
    <div class="row">
        <div class="col">
            <h3>Cervezas</h3>
            <select id="periodo" @change="updateChart(periodo)" v-model="periodo">
                <option value="1">día</option>
                <option value="7">semana</option>
                <option value="30">mes</option>
                <option value="365">año</option>
                <option value="">histórico</option>
            </select>
            <apexchart width="500" type="bar" :options="barOptions" :series="barSeries"></apexchart>
        </div>
        <div class="col">
            <h3>Pedidos por mesa</h3>
            <apexchart type="donut" :options="donutOptions" :series="donutSeries"></apexchart>
        </div>
`    </div>

</template>

<script>
export default {
    data() {
        return {
            barOptions: {
                chart: {
                    id: 'barras-items',
                    animations: {
                        speed: 200
                    }
                },
                xaxis: {
                    categories: []
                },
                legend: {
                    show: false
                },
                plotOptions: {
                    bar: {
                        distributed: true
                    }
                },
            },
            barSeries: [{
                name: 'cantidad',
                data: []
            }],
            periodo: '1',
            donutSeries: [],
            donutOptions: {
                chart: {
                    type: 'donut',
                },
                labels: [],
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
        refreshChart: function (data) {
            let newData = Object.values(data);
            this.barSeries = [{
                data: newData
            }];
            let newCategories = Object.keys(data);
            this.barOptions = {xaxis: { categories: newCategories}}
        },
        updateDonutChart: function () {
            axios
                .get('/api/orders/by_table')
                .then(response => {
                    this.refreshDonutChart(response['data']);
                })
                .catch(error => console.error(error));
        },
        refreshDonutChart: function (data) {
            let tables = data.map(item => `Mesa ${item.table}`);
            this.donutOptions = {
                labels: tables
            };
            this.donutSeries = data.map(item => item.orders);
        },
    },
    mounted() {
        this.updateChart(this.periodo);
        this.updateDonutChart();
    }
}
</script>
