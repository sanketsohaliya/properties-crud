<template>
    <div>
        <h3 class="text-center">Create Property</h3>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form @submit.prevent="addProperty">
                    <div class="form-group">
                        <label>County</label>
                        <input type="text" class="form-control" v-model="property.county">
                    </div><br />
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" v-model="property.country">
                    </div><br />
                    <div class="form-group">
                        <label>Town</label>
                        <input type="text" class="form-control" v-model="property.town">
                    </div><br />
                    <div class="form-group">
                        <label>Postcode</label>
                        <input type="text" class="form-control" v-model="property.postcode">
                    </div><br />
                    <div class="form-group">
                        <label>Description</label>
                        <textarea v-model="property.description" class="form-control"></textarea>
                    </div><br />
                    <div class="form-group">
                        <label>Displayable Address</label>
                        <input type="text" class="form-control" v-model="property.address">
                    </div><br />
                    <div class="form-group">
                        <label>Upload Image</label>
                        <input type="file" class="form-control" v-on:change="onChange">
                    </div><br />
                    <div class="form-group">
                        <label>Number of bedrooms</label>
                        <select v-model="property.num_bedrooms" class="form-select">
                            <option disabled value="">Please select one</option>
                            <option v-for="n in 12">{{ n }}</option>
                        </select>
                    </div><br />
                    <div class="form-group">
                        <label>Number of bathrooms</label>
                        <select v-model="property.num_bathrooms" class="form-select">
                            <option disabled value="">Please select one</option>
                            <option v-for="n in 12">{{ n }}</option>
                        </select>
                    </div><br />
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" class="form-control" v-model="property.price">
                    </div><br />
                    <div class="form-group">
                        <label>Select Property Type</label>
                        <select v-model="property.property_type" class="form-select">
                            <option disabled value="">Please select one</option>
                            <option>Flat</option>
                            <option>Detatched</option>
                            <option>Semi-detached</option>
                            <option>Terraced</option>
                            <option>End of Terrace</option>
                            <option>Cottage</option>
                            <option>Bungalow</option>
                        </select>
                    </div><br />
                    <div class="form-group">
                        <input type="radio" name="for_sale" v-model="property.for_sale" :value="1" /> For Sale
                        <input type="radio" name="for_sale" v-model="property.for_sale" :value="0" /> For Rent
                    </div><br />
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                file: '',
                property : {},
            }
        },
        methods: {
            addProperty() {
                let form_data = new FormData();
                form_data.append('file', this.file);
                for ( var key in this.property ) {
                    form_data.append(key, this.property[key]);
                }
                axios
                .post('http://localhost:8000/api/properties', form_data)
                .then(response => {
                    if (response.data.hasOwnProperty('errors')) {
                        alert(response.data.errors);
                    } else {
                        alert(response.data.success);
                        this.$router.push({name: 'home'});
                    }
                })
            },
            onChange(e) {
                this.file = e.target.files[0];
            },
        }
    }
</script>