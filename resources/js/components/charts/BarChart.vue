<template>
    <div class="container">
        <apexchart width="500" type="bar" :options="options" :series="series"></apexchart>
    </div>
</template>

<script>
export default {

    data() {
        return {
            titulo: 'Ventas según ítem',
            dropdown: 'Período',
            historical: [],
            daily: [],
            weekly: [],
            monthly: [],
            yearly: [],
            series: [{
                data: [],
            }],
            options: {
                chart: {
                    height: 350,
                    type: 'bar',
                },
                labels: [],
                title: {
                    text: '',
                    align: 'left'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        distributed: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: [],
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                }
            },
        }
    },
    methods: {
        getData(time, drop) {
            this.dropdown = drop;
            let arr = [];
            let names = [];
            for (const item of time) {
                arr.push(item.amount);
                names.push(item.name);
            }
            this.fillCharts(arr, names);
        },
        fillCharts(data, labels) {
            this.series = [{
                name: "Cantidad",
                data: data
            }];
            this.options = {
                labels: labels
            };
        },
        getAxios(delta) {
            axios
                .get('/api/items-summary', {
                    params: {
                        days: delta
                    }
                })
                .then(response => {
                    switch (delta) {
                        case '1':
                            this.daily = response['data'];
                            this.getData(this.daily, 'Diario');
                            break;
                        case '7':
                            this.weekly = response['data'];
                            this.getData(this.weekly, 'Semanal');
                            break;
                        case '30':
                            this.monthly = response['data'];
                            this.getData(this.monthly, 'Mensual');
                            break;
                        case '360':
                            this.yearly = response['data'];
                            this.getData(this.yearly, 'Anual');
                            break;
                        default:
                            this.historical = response['data'];
                            this.getData(this.historical, 'Histórico');
                            break;
                    }
                })
                .catch(error => console.error(error));
        }
    },
    mounted() {
        this.getAxios('1')
        this.getAxios('7')
        this.getAxios('30')
        this.getAxios('360')
        this.getAxios('-1')
    }
}
</script>
