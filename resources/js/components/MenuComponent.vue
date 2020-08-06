<template>
    <div class="card flat-border border-dark">
        <div class="card-header flat-border bg-dark text-white">
            <img src="/images/bori-white.svg" class="card-header-img"> <strong>Menu van de week</strong></div>

        <div class="card-body">
            <p>Het menu van de week wordt aangeboden door: <strong>Nikita</strong>.</p>

            <ul>
                <li>cassave soep (vega)</li>
                <li>kip (zoutvlees)</li>
                <li>&euro; 12,- per liter</li>
            </ul>
            <div class="text-right">
                <a class="btn btn-dark" href="/register">
                    <i class="fas fa-shopping-basket"></i> Bestellen</a>
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        mounted() {
            console.log('Menu mounted.')
        }
    }
</script>
