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
                                <span>Diarias</span>
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
                                <span>{{ buildAmount }}</span>
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
        getBestSeller() {
            for (const item of this.lastHoursData) {
                if (this.amountBestSeller < item.amount) {
                    this.amountBestSeller = item.amount;
                    this.bestSeller = item.name;
                }
            }
        },
        getAxios() {
            axios
                .get('/api/items-summary', {
                    params: {
                        hours: LAST_HOURS,
                    }
                })
                .then(response => {
                    this.lastHoursData = response['data'];
                    console.log(this.lastHoursData);
                    this.getEarns();
                    this.getBestSeller();
                    setTimeout(this.getAxios, 10000);
                })
                .catch(error => console.error(error));
        }
    },
    mounted() {
        this.getAxios();
    }
}
</script>
