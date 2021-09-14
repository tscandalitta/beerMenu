<template>
    <div class="container">
        <apexchart width="500" type="bar" :options="options" :series="series"></apexchart>
    </div>
</template>

<script>
export default {

    data() {
        return {
            series: [],
            chartOptions: {
                chart: {
                    width: 575,
                    type: 'pie',
                },
                labels: [],
                responsive: [{
                    breakpoint: 350,
                    options: {
                        chart: {
                            width: 300,
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                },
                    {
                        breakpoint: 570,
                        options: {
                            chart: {
                                width: 500,
                            },
                            legend: {
                                position: 'bottom'
                            }
                        },
                    }
                ],
                title: {
                    text: '',
                    align: 'left'
                },
            },
        }
    },
    mounted() {
        axios
            .get('/api/items-summary', {params:{days: '-1'}})
            .then(response => {
                let names = [];
                let amounts = [];
                for (const item of response.data) {
                    names.push(item.name);
                    amounts.push(item.amount);
                }
                this.series = amounts;
                this.chartOptions = {
                    labels: names
                };
            })
            .catch(error => console.error(error));
    }
}
</script>
