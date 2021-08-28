<template>
    <div class="container">
        <table class="table text-center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">In Stock</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody v-for="item in items" v-bind:key="item.id">
                <tr>
                    <td>{{ item.name }}</td>
                    <td>{{ item.description }}</td>
                    <td v-if="item.in_stock"> <i class="fas fa-check"></i></td>
                    <td v-else> <i class="fas fa-times"></i></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="/items/create">
            <button type="button" class="btn btn-success float-right">Create Item</button>
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
        }
    },
    mounted() {
        this.getItems();
    }
}
</script>

<style scoped>

</style>
