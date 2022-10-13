<template>
    <div>
        <h3 class="text-center">Edit Property</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProperty">
                    <div class="form-group">
                        <label>County</label>
                        <input type="text" class="form-control" v-model="property.county">
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" v-model="property.country">
                    </div>
                    <div class="form-group">
                        <label>Town</label>
                        <input type="text" class="form-control" v-model="property.town">
                    </div>
                    <div class="form-group">
                        <label>Postcode</label>
                        <input type="text" class="form-control" v-model="property.postcode">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea v-model="property.description" cols="73"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Displayable Address</label>
                        <input type="text" class="form-control" v-model="property.address">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="text" class="form-control" v-model="property.image_full">
                    </div>
                    <div class="form-group">
                        <label>Number of Bedrooms</label>
                        <input type="number" class="form-control" v-model="property.num_bedrooms">
                    </div>
                    <div class="form-group">
                        <label>Number of Bathrooms</label>
                        <input type="number" class="form-control" v-model="property.num_bathrooms">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" class="form-control" v-model="property.price">
                    </div>
                    <div class="form-group">
                        <label>Select Property Type: </label>
                        <select v-model="property.property_type">
                            <option disabled value="">Please select one</option>
                            <option>Flat</option>
                            <option>Detatched</option>
                            <option>Semi-detached</option>
                            <option>Terraced</option>
                            <option>End of Terrace</option>
                            <option>Cottage</option>
                            <option>Bungalow</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="for_sale" v-model="property.for_sale" :value="1" /> For Sale
                        <input type="radio" name="for_sale" v-model="property.for_sale" :value="0" /> For Rent
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                property: {}
            }
        },
        created() {
            axios
                .get(`http://localhost:8000/api/properties/${this.$route.params.id}`)
                .then((res) => {
                    this.property = res.data;
                });
        },
        methods: {
            updateProperty() {
                axios
                    .patch(`http://localhost:8000/api/properties/${this.$route.params.id}`, this.property)
                    .then((res) => {
                        this.$router.push({ name: 'home' });
                    });
            }
        }
    }
</script>