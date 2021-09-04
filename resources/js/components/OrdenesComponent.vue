<template>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h3 class="ml-1">Ordenes</h3>
                <transition-group name="list-complete" tag="div" class="row">
                    <div class="card-group col-sm-12 col-lg-6 list-complete-item" v-for="(order, index) in orders" v-bind:key="order.id">
                        <div class="card mb-3 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Mesa {{ order.table }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Pedido #{{ order.id }}</h6>
                                <dl>
                                    <dd v-for="item in order.items">
                                        {{ item.amount }} x {{ item.name }}
                                    </dd>
                                </dl>
                                <template v-if="order.comments">
                                    <hr>
                                    <p class="card-text m-1" >Observaciones:</p>
                                    <p class="card-text m-1">{{ order.comments }}</p>
                                </template>
                                <button class="btn btn-success" @click="acceptOrder(index)">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <div class="col-4">
                <h3 class="ml-4">Solicitudes</h3>
                <div class="card-group list-complete-item" v-for="ar in attention_requests" v-bind:key="ar.id">
                    <div class="card mb-3 ml-3 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Mesa {{ ar.table_id }}</h5>
                            <h6 v-if="ar.type === 'WAITER' " class="card-subtitle mb-2">Solicitan al <b>mozo</b></h6>
                            <h6 v-else class="card-subtitle mb-2">Solicitan la <b>cuenta</b></h6>
                            <template v-if="ar.comments">
                                <hr>
                                <p class="card-text m-1" >Observaciones:</p>
                                <p class="card-text m-1">{{ ar.comments }}</p>
                            </template>
                            <button v-if="ar.type === 'WAITER'" class="btn text-white" @click="acceptOrder(index)" style="background-color: #6f42c1;">Aceptar</button>
                            <button v-else class="btn text-white" @click="acceptOrder(index)" style="background-color: #dc3545;">Aceptar</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {},
        data() {
            return {
                orderToDismiss: null,
                orders: [],
                attention_requests: [],
            }
        },
        methods: {
            acceptOrder: function (index) {
                this.saveConfirmedOrder(this.orders[index].id);
                this.orderToDismiss = index;
                this.dismissOrder();
            },
            dismissOrder: function () {
                this.orders.splice(this.orderToDismiss, 1);
                this.orderToDismiss = null;
            },
            saveConfirmedOrder: function (orderId) {
                this.editOrder(orderId,'CLOSED');
            },
            editOrder: function (orderId, orderState) {
                axios
                    .put(`/api/orders/${orderId}`, {
                        state: orderState,
                    })
                    .catch(error => console.error(error));
            },
            openModal: function () {
                $('#commentsTextArea').val('');
                $('#commentsModal')
                    .modal('show')
                    .on('shown.bs.modal', function () {
                    $('#commentsTextArea').focus();
                })
            },
            retrieveData: function () {
                this.checkForNewOrders();
                this.checkForNewAttentionRequests();
                setInterval(this.checkForNewOrders,10000);
                setInterval(this.checkForNewAttentionRequests,10000);
            },
            checkForNewOrders: function () {
                axios
                    .get('/api/orders', {
                        params: {
                            state: 'OPEN',
                        }
                    })
                    .then(response => {
                        this.orders = response['data'];
                    })
                    .catch(error => console.error(error));;
            },
            checkForNewAttentionRequests: function () {
                axios
                    .get('/api/attention_requests')
                    .then(response => {
                        this.attention_requests = response['data'];
                    })
                    .catch(error => console.error(error));
            },
        },
        mounted() {
            this.retrieveData();
        }
    }
</script>
