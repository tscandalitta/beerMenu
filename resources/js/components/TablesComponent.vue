<template>
    <div class="container">
        <div class="modal fade" id="confirmDialogue" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="m-0 modal-title" id="modalLabel" style="font-size: 1.3em; font-weight: bolder"><strong>Cerrar mesa {{ selectedTable }}</strong></p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Seguro que desea cerrar la <strong>MESA {{ selectedTable }}</strong>?</p>
                        <p>Los comensales no podrán seguir pidiendo.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" @click="refreshQR">Cerrar</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row mb-4 d-flex justify-content-center">
            <div class="col"></div>
            <select class="form-control" v-model="selectedTable" style="width: 100%">
                <option v-for="mesa in mesas" :value="mesa.id" >Mesa {{ mesa.number }}</option>
            </select>
        </div>
        <div class="form-row mb-4 d-flex justify-content-center">
            <span v-html="qrCodeHTML" v-bind:style="{opacity: opacity}"></span>
        </div>
        <div class="form-row d-flex justify-content-center">
            <button class="btn btn-sm btn-danger" @click="showDialogue" :disabled="disabledButton">
                Cerrar mesa
            </button>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        tables: {
            required: true,
        }
    },
    data() {
        return {
            mesas: JSON.parse(this.tables),
            qrCodeHTML: '',
            selectedTable: 1,
            opacity: 0.3,
            disabledButton: false,
        }
    },
    watch: {
      selectedTable: function () {
          this.updateQRCode();
      }
    },
    methods: {
        refreshQR: function () {
            this.sendPost(this.selectedTable);
        },
        sendPost: function (id) {
            axios
                .post(`/api/tables/${id}`, {
                    //TODO: enviar bearer para autenticar
                })
                .then(response => {
                    this.updateQRCode();
                })
                .catch(error => console.error(error));
        },
        showDialogue: function () {
            $('#confirmDialogue').modal('show');
        },
        getToken: function (tableId) {
            const mesa = this.mesas.find(table => table['id'] === tableId);
            return (mesa !== undefined) ? mesa['token'] : null;
        },
        updateQRCode: function () {
            this.sendRequest(this.selectedTable);
        },
        sendRequest: function (id) {
            this.opacity = 0.3;
            this.disabledButton = true;
            axios
                .get('/api/qrcode', {
                    params: {
                        table: id
                    }
                })
                .then(response => {
                    this.qrCodeHTML = response['data'];
                    this.opacity = 1;
                    this.disabledButton = false;
                })
                .catch(error => console.error(error));
        },
    },
    mounted() {
        this.updateQRCode();
    }
}
</script>
