<template>
    <div class="row mb-3">
        <div class="col-6">
            <div class="card">
                <div class="card-content">
                    <div class="card-body ">
                        <div class="media align-items-stretch">
                            <div class="align-self-center">
                                <h1 class="mr-2 text-default">{{ priceText }}</h1>
                            </div>
                            <div class="media-body ml-4">
                                <h4 class="text-dark">Ganancias</h4>
                                <div class="row">
                                    <div class="col-3">
                                        <select class="form-control form-control-sm" style="width: 120px" @change="updateEarns($event)">
                                            <option value="1">del dia</option>
                                            <option value="7">de la semana</option>
                                            <option value="30">del mes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="align-self-center mr-3">
                                <i class="fa fa-wallet fa-3x text-default"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-content">
                    <div class="card-body ">
                        <div class="media align-items-stretch">
                            <div class="align-self-center">
                                <h1 class="mr-2 text-warning">{{ bestSeller }}</h1>
                            </div>
                            <div class="media-body ml-4">
                                <h4 class="text-dark">Birra más tomada</h4>
                                 <select class="form-control form-control-sm" style="width: 120px" @change="updateBestSeller($event)">
                                            <option value="1">del dia</option>
                                            <option value="7">de la semana</option>
                                            <option value="30">del mes</option>
                                        </select>
                            </div>
                            <div class="align-self-center mr-3">
                                <i class="fa fa-beer fa-3x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            earns: 0,
            bestSeller: '',
            amountBestSeller: 0,
            lastHoursData: '',
        }
    },
    computed: {
        priceText() {
            return '$' + new Intl.NumberFormat("de-DE").format(this.earns);
        },
    },
    methods: {
        getEarns() {
            axios.get(`/api/orders/total?days=1`)
                .then(response => {
                    this.earns = response.data.total;
                })
                .catch(error => console.error(error));
        },
        updateEarns(event) {
            axios.get(`/api/orders/total?days=${event.target.value}`)
            .then(response => {
                this.earns = response.data.total;
            })
            .catch(error => console.error(error));
        },
        getBestSeller() {
            axios.get(`/api/items-summary?days=1`)
                .then(response => {
                    const entries = Object.entries(response.data).sort((a, b) => a[1] - b[1]);
                    this.bestSeller = entries[entries.length - 1][0]
                })
                .catch(error => console.error(error));
        },
        updateBestSeller(event) {
            axios.get(`/api/items-summary?days=${event.target.value}`)
            .then(response => {
                const entries = Object.entries(response.data).sort((a, b) => a[1] - b[1]);
                this.bestSeller = entries[entries.length - 1][0]
            })
            .catch(error => console.error(error));
        }
    },
    mounted() {
        this.getEarns();
        this.getBestSeller();
    }
}
</script>
