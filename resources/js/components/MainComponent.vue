<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <menu-component></menu-component>
                <chefs-component></chefs-component>
            </div>
            <div class="col-md-4">
                <tshirt-component></tshirt-component>
                <about-widget></about-widget>
            </div>


        </div>
    </div>
</template>

<script>
import AboutWidget from '../widgets/About'

export default {
    components: {
        'about-widget': AboutWidget
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
