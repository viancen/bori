<template>

    <div class="card flat-border border-dark">
        <div class="card-header flat-border bg-dark text-white">
            <img src="/images/bori.svg" class="card-header-img"> <strong>Ontmoet onze chefs</strong></div>

        <div class="card-body">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/images/cook2.jpeg" class="card-img"/>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Nikita Tjon-Affo</h5>
                            <p class="card-text">This is something about me, i cook soups.</p>
                            <p class="card-text"><small class="text-muted">Specialiteit: vegan soup</small></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/images/cook3.jpeg" class="card-img"/>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">John Doe</h5>
                            <p class="card-text">This is something about me, i cook burgers.</p>
                            <p class="card-text"><small class="text-muted">Specialiteit: truck burger</small></p>
                        </div>
                    </div>
                </div>
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
