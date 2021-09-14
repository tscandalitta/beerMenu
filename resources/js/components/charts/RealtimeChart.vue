<template>
    <div class="container">
        <apexchart width="500" type="bar" :options="options" :series="series"></apexchart>
    </div>
</template>

<script>
const LAST_HOURS = 48;
export default {
    data() {
        return {
            dataResponse: [],
            series: [{
                data: []
            }],
            chartOptions: {
                chart: {
                    type: 'bar',
                    height: 380
                },
                plotOptions: {
                    bar: {
                        barHeight: '100%',
                        distributed: true,
                        horizontal: true,
                        dataLabels: {
                            position: 'bottom'
                        },
                    }
                },
                colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
                    '#f48024', '#69d2e7'
                ],
                dataLabels: {
                    enabled: true,
                    textAnchor: 'start',
                    style: {
                        colors: ['#000']
                    },
                    formatter: function (val, opt) {
                        return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                    },
                    offsetX: 0,
                    dropShadow: {
                        enabled: false
                    }
                },
                labels: [],
                stroke: {
                    width: 1,
                    colors: ['#fff']
                },
                xaxis: {
                    categories: []
                },
                yaxis: {
                    labels: {
                        show: false
                    }
                },
                title: {
                    text: '',
                    align: 'center',
                    floating: true
                },
                subtitle: {
                    text: '',
                    align: 'center',
                },
                tooltip: {
                    theme: 'dark',
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function () {
                                return ''
                            }
                        }
                    }
                }
            },
        }
    },
    mounted() {
        this.getRealTimeData();
    },
    methods: {
        getNamesAndAmounts(data) {
            let names = [];
            let amounts = [];
            for (const item of data) {
                names.push(item.name);
                amounts.push(item.amount);
            }
            return [names, amounts];
        },
        getRealTimeData() {
            axios
                .get('/api/items-summary', {
                    params: {
                        hours: LAST_HOURS,
                    }
                })
                .then(response => {
                    this.dataResponse = response['data'];
                    let data = this.getNamesAndAmounts(this.dataResponse);
                    this.chartOptions = {labels: data[0]};
                    this.series = [{data: data[1]}];
                    setTimeout(this.getRealTimeData, 5000);
                })
                .catch(error => console.error(error));
        }
    },
}
</script>
