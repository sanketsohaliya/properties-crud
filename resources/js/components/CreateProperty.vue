<template>
    <div>
        <h3 class="text-center">Create Property</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addProperty">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="property.name">
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <input type="text" class="form-control" v-model="property.detail">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
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
        methods: {
            addProperty() {
                axios
                    .post('http://localhost:8000/api/properties', this.property)
                    .then(response => (
                        this.$router.push({ name: 'home' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>