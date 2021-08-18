<template>
    <div class="container">
        <div class="card-group col-sm-12 col-lg-6" v-for="(order, index) in orders" v-bind:key="order.id">

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <h5><strong> Mesa {{ order.table }} </strong></h5>
                    <p>Pedido #{{ order.id }}</p>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <ul>
                                <li v-for="item in order.items">
                                    {{ item.amount }} {{ item.name }}
                                </li>
                            </ul>
                            <p v-if="order.comments">Observaciones:</p>
                            <p class="card-text">{{ order.comments }}</p>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-success btn-block btn-sm m-1" title="Aceptar"
                                    @click="acceptOrder(index)">
                                <i class="fas fa-check mr-1"></i>Confirmar
                            </button>
                            <button class="btn btn-danger btn-block btn-sm m-1" title="Rechazar"
                                    @click="showCommentsField(index)">
                                <i class="fas fa-times mr-1"></i>Enviar comentario
                            </button>
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
            }
        },
        methods: {
            acceptOrder: function (index) {
                this.saveConfirmedOrder(this.orders[index].id);
                this.orderToDismiss = index;
                this.dismissOrder();
            },
            showCommentsField: function (index) {
                this.orderToDismiss = index;
                this.openModal();
            },
            rejectOrder: function () {
                this.saveRejectedOrder(this.orders[this.orderToDismiss].id);
                this.dismissOrder();
            },
            dismissOrder: function () {
                this.orders.splice(this.orderToDismiss, 1);
                this.orderToDismiss = null;
            },
            saveConfirmedOrder: function (orderId) {
                this.editOrder(orderId,'CLOSED');
            },
            saveRejectedOrder: function (orderId) {
                this.editOrder(orderId,'REJECTED');
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
            checkForNewOrders: function () {
                this.sendRequest();
                setInterval(this.sendRequest,10000);
            },
            sendRequest: function () {
                axios
                    .get('/api/orders', {
                        params: {
                            state: 'OPEN',
                        }
                    })
                    .then(response => {
                        this.orders = response['data'];
                    })
                    .catch(error => console.error(error));
            },
        },
        mounted() {
            this.checkForNewOrders();
        }
    }
</script>
