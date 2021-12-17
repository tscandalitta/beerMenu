<template>
    <div class="container">
        <table class="table text-center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">En Stock</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody v-for="item in items" v-bind:key="item.id">
                <tr>
                    <td>{{ item.name }}</td>
                    <td>{{ item.description }}</td>
                    <td v-if="item.in_stock == '1'"> <i class="fas fa-check"></i></td>
                    <td v-else> <i class="fas fa-times"></i></td>
                    <td>
                        <a :href="'/items/update/' + item.id">
                            <button type="button" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                        </a>

                    </td>
                </tr>
            </tbody>
        </table>
        <a href="/items/create">
            <button type="button" class="btn btn-success float-right">Crear Item</button>
        </a>
    </div>
</template>

<script>
export default {
    name: "ItemsComponent",
    data() {
        return {
            items: [],
        }
    },
    methods: {
        getItems: function() {
            axios
                .get('/api/items')
                .then(response => {
                    this.items = response['data'];
                })
                .catch(error => console.error(error));
        },
        getEditUrl: function (item){
            return "/items/update/" + item.id;
        }
    },
    mounted() {
        this.getItems();
    }
}
</script>

<style scoped>

</style>
