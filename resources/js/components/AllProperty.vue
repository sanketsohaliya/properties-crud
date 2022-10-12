<template>
    <div>
        <h2 class="text-center">Properties List</h2>
 
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Detail</th>
                <!-- <th>Actions</th> -->
            </tr>
            </thead>
            <tbody>
            <tr v-for="property in propertis" :key="property.id">
                <td>{{ property.id }}</td>
                <td>{{ property.name }}</td>
                <td>{{ property.detail }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: property.id }}" class="btn btn-success">Edit</router-link>
                        <button class="btn btn-danger" @click="deleteProperty(property.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                properties: []
            }
        },
        created() {
            axios
                .get('http://localhost:8000/api/properties/')
                .then(response => {
                    this.properties = response.data;
                });
        },
        methods: {
            deleteProperty(id) { 
                axios
                    .delete(`http://localhost:8000/api/properties/${id}`)
                    .then(response => {
                        let i = this.properties.map(data => data.id).indexOf(id);
                        this.properties.splice(i, 1)
                    });
            }
        }
    }
</script>