<template>
    <div class="container">
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
            <button class="btn btn-sm btn-danger" :disabled="disabledButton">Refrescar QR</button>
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
        updateQRCode: function () {
            this.sendRequest(this.selectedTable, this.getToken(this.selectedTable));
        },
        getToken: function (tableId) {
            const mesa = this.mesas.filter(table => table['id'] === tableId);
            return (mesa[0] !== undefined) ? mesa[0]['token'] : null;
        },
        sendRequest: function (id, token) {
            this.opacity = 0.3;
            this.disabledButton = true;
            axios
                .get('/qrcode', {
                    params: {
                        id: id,
                        token: token
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
