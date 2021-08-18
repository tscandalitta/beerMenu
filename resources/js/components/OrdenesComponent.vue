<template>
    <div class="container">
        <transition-group name="list-complete" tag="div" class="row">
            <div class="card-group col-sm-12 col-lg-6 list-complete-item" v-for="(order, index) in orders" v-bind:key="order.id">
                <div class="card mb-3">
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
                        <button class="btn btn-sm btn-outline-danger">Rechazar</button>
                    </div>
                </div>
            </div>
        </transition-group>
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
