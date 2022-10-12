<template>
    <div>
        <h3 class="text-center">Edit Property</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProperty">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="property.name">
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <input type="text" class="form-control" v-model="property.detail">
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