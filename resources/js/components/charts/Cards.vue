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
                                        <select class="form-control form-control-sm" style="width: 120px" 
                                            @change="getEarnings()" v-model="deltaDaysEarnings">
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
                                 <select class="form-control form-control-sm" style="width: 120px" 
                                    @change="getBestSeller()" v-model="deltaDaysBestSeller">
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
            deltaDaysBestSeller: 1,
            deltaDaysEarnings: 1
        }
    },
    computed: {
        priceText() {
            return '$' + new Intl.NumberFormat("de-DE").format(this.earns);
        },
    },
    methods: {
        getEarnings() {
            axios.get(`/api/orders/total?days=${this.deltaDaysEarnings}`)
                .then(response => {
                    this.earns = response.data.total;
                })
                .catch(error => console.error(error));
        },
        getBestSeller() {
            axios.get(`/api/items-summary?days=${this.deltaDaysBestSeller}`)
                .then(response => {
                    const entries = Object.entries(response.data).sort((a, b) => a[1] - b[1]);
                    this.bestSeller = entries.at(-1) == undefined ? "-" : entries.at(-1)[0]
                })
                .catch(error => console.error(error));
        },
    },
    mounted() {
        this.getEarnings();
        this.getBestSeller();
    }
}
</script>
