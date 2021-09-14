<template>
    <div class="container">
        <apexchart width="500" type="bar" :options="options" :series="series"></apexchart>
    </div>
</template>

<script>
export default {

    data() {
        return {
            series: [{
                name: "",
                data: [],
            }],
            chartOptions: {
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                labels: [],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    colors: ['#CD5C5C'],
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: [],
                }
            },
        }
    },
    mounted() {
        axios
            .get('/api/items-date', {})
            .then(response => {
                let amounts = [];
                let dates = []
                for (const item of response['data']) {
                    dates.push(item.date);
                    amounts.push(item.sold_items);
                }
                this.series = [{
                    name: "Cantidad",
                    data: amounts
                }];
                this.chartOptions = {
                    labels: dates
                };
            })
            .catch(error => console.error(error));
    }
}
</script>
