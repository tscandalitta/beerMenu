<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <h3 v-if="this.item === null">Crear Item</h3>
                <h3 v-else>Actualizar Item</h3>
            </div>
        </div>

        <form>
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="nameInput">Name</label>
                        <input type="text" class="form-control" id="nameInput"
                               v-model="name">
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="form-group mb-3">
                        <div class="form-group">
                            <label for="descriptionInput">Description</label>
                            <input type="text" class="form-control"
                                   v-model="description"
                                   id="descriptionInput"
                                   placeholder="Enter Description">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="form-group mb-3">
                        <div class="form-group">
                            <label for="priceInput">Price</label>
                            <input type="number" class="form-control"
                                   v-model="price"
                                   id="priceInput"
                                   placeholder="Enter Price">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"
                                   v-model="inStock"
                                   id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">In Stock</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-6">
                    <button type="button" class="btn btn-primary" v-on:click="saveItem()">Submit</button>
                </div>
            </div>

        </form>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            default(){
                return null;
            }
        }
    },
    name: "ItemFormComponent",
    data() {
        return {
            name: this.item ? this.item.name: "",
            description: this.item ? this.item.description: "",
            price: this.item ? this.item.price: 0,
            inStock: this.item ? this.item.in_stock: false,
            apiURL: '/api/items'
        }
    },
    methods: {
        saveItem: function() {
            const config = {
                name: this.name,
                description: this.description,
                price: this.price,
                in_stock: this.inStock
            }
            
            if(this.item){
                const id = window.location.href[window.location.href.lastIndexOf('/') + 1];
                this.apiURL = this.apiURL + `/${id}`;     
            }
                 
            axios
                .post(this.apiURL, config)
                .then(_ => {
                    window.location.href = '/items'
                })
                .catch(error => console.error(error));
        }
    },
    mounted() {
        if(this.item){
            console.log(this.item);
            this.name = this.item.name
        }
    },
}
</script>

<style scoped>

</style>
