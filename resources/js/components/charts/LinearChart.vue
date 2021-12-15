<template>
    <div class="row">
        <div class="col-6">
            <h3>Ventas históricas</h3>
            <apexchart width="500" type="line" :options="optionsCervezas" :series="seriesCervezas"></apexchart>
        </div>
        <div class="col-6">
            <h3>Ganancias históricas</h3>
            <apexchart width="500" type="line" :options="optionsGanancias" :series="seriesGanancias"></apexchart>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            seriesCervezas: [{
                name: "Cervezas",
                type: 'line',
                data: [],
            }],
            seriesGanancias: [{
                name: "Ganancias",
                type: 'line',
                data: [],
            }],
            optionsCervezas: {
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
                labels: [],
                stroke: {
                    curve: 'smooth',
                },
                xaxis: {
                    type: 'datetime',
                    categories: [],
                },
                colors: ['#FFA704'],
            },
            optionsGanancias: {
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
                labels: [],
                stroke: {
                    curve: 'smooth',
                },
                xaxis: {
                    type: 'datetime',
                    categories: [],
                },
                colors: ['#29CC20'],
            },
        }
    },
    methods: {
        setOptions: function (data) {
          let dates = data.map(item => item.date);
            this.optionsCervezas = {xaxis: { categories: dates}}
            this.optionsGanancias = {xaxis: { categories: dates}}
        },
        refreshBeersChart: function (data) {
            let quantities = data.map(item => item.quantities);
            this.seriesCervezas = [{
                data: quantities
            }];
        },
        refreshEarningsChart: function (data) {
            let earnings = data.map(item => item.earnings);
            this.seriesGanancias = [{
                data: earnings
            }];
        },
        updateChart: function () {
            axios
                .get('/api/orders/quantities')
                .then(response => {
                    this.setOptions(response['data']);
                    this.refreshBeersChart(response['data']);
                })
                .catch(error => console.error(error));
            axios
                .get('/api/orders/earnings')
                .then(response => {
                    this.refreshEarningsChart(response['data']);
                })
                .catch(error => console.error(error));
        },
    },
    mounted() {
        this.updateChart();
    }
}
</script>
