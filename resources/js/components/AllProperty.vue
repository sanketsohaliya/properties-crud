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
                }"
                :search-options="{
                    enabled: true,
                }"
            >
            </vue-good-table>
        </div>
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
                        type: 'number'
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
                        label: 'Description',
                        field: 'description',
                        width: '400px'
                    },
                    {
                        label: 'Address',
                        field: 'address',
                        width: '200px'
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
                        label: 'Postcode',
                        field: 'postcode',
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