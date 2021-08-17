<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>

{{--    {% block custom-css %}--}}
{{--    {% load static %}--}}
{{--    <link rel="stylesheet" href="{% static 'css/transitions.css' %}">--}}
{{--    {% endblock custom-css %}--}}
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <div id="app">
        <div class="container">
            <div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Enviar comentario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea name="comments" id="commentsTextArea" rows="5" style="width: 100%;"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-dark-green" data-dismiss="modal" @click="rejectOrder()">Enviar</button>
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <transition-group name="list-complete" tag="div" class="row">
                <div class="card-group col-sm-12 col-lg-6 list-complete-item"
                     v-for="(order, index) in orders" v-bind:key="order.id">
                    <div class="card mb-3">

                        <div class="card-header d-flex justify-content-between">
                            <h5><strong> Mesa [[order.table]] </strong></h5>
                            <small>Pedido #[[order.id]]</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <ul>
                                        <li v-for="item in order.items">
                                            [[item.amount]] [[item.items]]
                                        </li>
                                    </ul>
                                    <p v-if="order.comments">Observaciones:</p>
                                    <p class="card-text">[[order.comments]]</p>
                                </div>
                                <div class="col-5">
                                    <div class="text-center">
                                        <button class="btn btn-green btn-block btn-sm mb-2" title="Aceptar y descartar"
                                                @click="acceptOrder(index)">
                                            <i class="fas fa-check mr-1"></i>Confirmar
                                        </button>
                                        <button class="btn btn-yellow btn-block btn-sm" title="Enviar comentario"
                                                @click="showCommentsField(index)">
                                            <i class="fas fa-times mr-1"></i>Enviar comentario
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </transition-group>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.14.1/lodash.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
    var app = new Vue({
    delimiters: ['[[', ']]'],
    el: '#app',
    data: {
    orderToDismiss: null,
    orders: [],
    localISOTime: '',
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
                        .catch(error => console.error(error));
                },
                openModal: function () {
                    $('#commentsTextArea').val('');
                    $('#commentsModal').modal('show');
                    $('#commentsModal').on('shown.bs.modal', function () {
                        $('#commentsTextArea').focus();
                    })
                },
                checkForNewOrders: function () {
                    // setInterval(this.getInitializedOrders,10000);
                },
                getInitializedOrders: function () {
                    axios
                        .get('/api/last-initialized-orders')
                        .then(response => {
                            this.orders = response['data'];
                        })
                        .catch(error => console.error(error));
                },
            },
            mounted() {
                this.checkForNewOrders();
            }
        });
    </script>
</x-app-layout>
