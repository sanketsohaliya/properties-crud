<template>
    <div>
        <h2 class="text-center">Properties List</h2>
        <div>
            <vue-good-table
                :columns="columns"
                :rows="rows"
                v-on:cell-click="onCellClick"
                :pagination-options="{
                enabled: true,
                position: 'top',
            }">
            </vue-good-table>
        </div>
        <!-- <table class="table">
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
                <td><img :src=property.image_full height="150" /></td>
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
        </table> -->
    </div>
</template>
 
<script>
    export default {
        props: [],
        data() {
            return {
                properties: [],
                columns: [
                    {
                        label: 'Id',
                        field: 'id',
                    },
                    {
                        label: 'County',
                        field: 'county',
                    },
                    {
                        label: 'Country',
                        field: 'country',
                    },
                    {
                        label: 'Town',
                        field: 'town',
                    },
                    {
                        label: 'Postcode',
                        field: 'postcode',
                    },
                    {
                        label: 'Description',
                        field: 'description',
                        width: '400px'
                    },
                    {
                        label: 'Image',
                        field: 'image_full',
                        html: true,
                    },
                    {
                        label: 'Thumbnail',
                        field: 'image_thumbnail',
                        html: true
                    },
                    {
                        label: 'Address',
                        field: 'address',
                    },
                    {
                        label: 'Latitude',
                        field: 'latitude',
                        type: 'number',
                    },
                    {
                        label: 'Longitude',
                        field: 'longitude',
                        type: 'number',
                    },
                    {
                        label: 'Number Of Bedrooms',
                        field: 'num_bedrooms',
                        type: 'number',
                    },
                    {
                        label: 'Number Of Bathrooms',
                        field: 'num_bathrooms',
                        type: 'number',
                    },
                    {
                        label: 'Price',
                        field: 'price',
                        type: 'number',
                    },
                    {
                        label: 'Property Type',
                        field: 'property_type',
                    },
                    {
                        label: 'For Sale',
                        field: 'sale',
                    },
                    {
                        label: 'For Rent',
                        field: 'rent',
                    },
                    {
                        label: 'Edit',
                        field: 'edit',
                        html: true
                    },
                    {
                        label: 'Delete',
                        field: 'delete',
                        html: true
                    }
                ],
                rows: [ ],
            }
        },
        created() {
            axios
                .get('http://localhost:8000/api/properties/')
                .then(response => {
                    this.properties = response.data;
                    this.properties.forEach(function(property) {
                        property.image_full = "<img height='100' width='100' src='" + property.image_full + "' />";
                        property.image_thumbnail = "<img height='100' width='100' src='" + property.image_thumbnail + "' />";
                        property.sale = property.for_sale === 1 ? "Yes" : "No";
                        property.rent = property.for_sale === 1 ? "No" : "Yes";
                        property.edit = "<button class='btn btn-info'>Edit</button>";
                        property.delete = "<button class='btn btn-danger'>Delete</button>";
                    });
                    this.rows = this.properties;
                });
        },
        methods: {
            onCellClick(params) {
                if (params.column.field === "edit") {
                    this.$router.push({name: 'edit', params: { id: params.row.id }});
                }
                if (params.column.field === "delete") {
                    axios
                    .delete(`http://localhost:8000/api/properties/${params.row.id}`)
                    .then(response => {
                        let i = this.properties.map(data => data.id).indexOf(params.row.id);
                        this.properties.splice(i, 1)
                    });
                }
            },
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