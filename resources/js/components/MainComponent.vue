<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <about-component></about-component>
                <tshirt-component></tshirt-component>
            </div>
            <div class="col-md-6">
                <menu-component></menu-component>
                <chefs-component></chefs-component>
            </div>

        </div>
    </div>
</template>

<script>

    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
