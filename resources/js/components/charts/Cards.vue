<template>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-5">
            <div class="card">
                <div class="card-content">
                    <div class="card-body ">
                        <div class="media align-items-stretch">
                            <div class="align-self-center">
                                <h1 class="mr-2 text-default">{{ buildPrice }}</h1>
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
        <div class="col-5">
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
        <div class="col-1"></div>
    </div>
</template>

<script>
const LAST_HOURS = 48;


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
        buildPrice() {
            return '$' + new Intl.NumberFormat("de-DE").format(this.earns);
        },
        buildAmount() {
            return new Intl.NumberFormat("de-DE").format(this.amountBestSeller);
        }
    },
    methods: {
        getEarns() {
            this.earns = 0;
            for (const item of this.lastHoursData) {
                this.earns += item.amount * item.price;
            }
        },
        updateEarns(event) {
            axios.get(`/api/orders/total?days=${event.target.value}`)
            .then(response => {
                this.earns = response.data.total;
            })
            .catch(error => console.error(error));
        },
        updateBestSeller(event) {
            axios.get(`/api/items-summary?days=${event.target.value}`)
            .then(response => {
                this.bestSeller = ""
            })
            .catch(error => console.error(error));
        },
        getBestSeller() {
            axios.get(`/api/items-summary?days=1`)
            .then(response => {
                this.bestSeller = ""
            })
            .catch(error => console.error(error));
        },
        getEarns() {
            axios.get(`/api/orders/total?days=1`)
            .then(response => {
                this.earns = response.data.total;
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
