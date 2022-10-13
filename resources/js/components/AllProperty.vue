<template>
    <div>
        <h2 class="text-center">Properties List</h2>
 
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>County</th>
                <th>Country</th>
                <th>Town</th>
                <th>Postcode</th>
                <th>Description</th>
                <th>Image</th>
                <th>Thumbnail</th>
                <th>Address</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Number Of Bedrooms</th>
                <th>Number of Bathrooms</th>
                <th>Price</th>
                <th>Property Type</th>
                <th>For Sale</th>
                <th>For Rent</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="property in properties" :key="property.id">
                <td>{{ property.id }}</td>
                <td>{{ property.county }}</td>
                <td>{{ property.country }}</td>
                <td>{{ property.town }}</td>
                <td>{{ property.postcode }}</td>
                <td>{{ property.description }}</td>
                <td>{{ property.image_full }}</td>
                <td>{{ property.image_thumbnail }}</td>
                <td>{{ property.address }}</td>
                <td>{{ property.latitude }}</td>
                <td>{{ property.longitude }}</td>
                <td>{{ property.num_bedrooms }}</td>
                <td>{{ property.num_bathrooms }}</td>
                <td>{{ property.price }}</td>
                <td>{{ property.property_type }}</td>
                <td>{{ property.for_sale === 1 ? "Yes" : "No" }}</td>
                <td>{{ property.for_sale === 1 ? "No" : "Yes" }}</td>
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