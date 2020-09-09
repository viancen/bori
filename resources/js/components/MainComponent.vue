<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <about-widget></about-widget>
               <!-- <tshirt-component></tshirt-component>-->
            </div>
            <div class="col-md-6">
                <menu-component></menu-component>
                <chefs-component></chefs-component>
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
