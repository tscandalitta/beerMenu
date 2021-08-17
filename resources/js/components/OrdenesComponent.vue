<template>
    <div class="container">
        <div class="row justify-content-center" v-for="(order, index) in orders" v-bind:key="order.id">
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5><strong> Mesa {{ order.table_id }} </strong></h5>
                        <p>Pedido #{{ order.id }}</p>
                    </div>

                    <div class="card-body">
                        <ul>
                            <li v-for="item in order.items">
                                {{ item.amount }} {{ item.items }}
                            </li>
                        </ul>
                        <p v-if="order.comments">Observaciones:</p>
                        <p class="card-text">{{ order.comments }}</p>
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
                    .post(`/api/order/update/${orderId}`, null, {
                        params: {
                            state: orderState,
                        }
                    })
                    .catch(error => console.error());
            },
            openModal: function () {
                $('#commentsTextArea').val('');
                $('#commentsModal').modal('show');
                $('#commentsModal').on('shown.bs.modal', function () {
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
