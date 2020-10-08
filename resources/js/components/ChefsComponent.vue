<template>

    <div class="card flat-border border-dark">
        <div class="card-header flat-border bg-dark text-white">
            <img src="/images/bori.svg" class="card-header-img"> <strong>Ontmoet onze chefs</strong></div>

        <div class="card-body">

            <div class="card" v-for="chef in chefs">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img :src="chef.avatar"  class="card-img chef-image"/>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{chef.name}}</h5>
                            <p class="card-text ">{{ chef.description }}</p>
                            <p class="card-text"><small class="text-muted">Specialiteit: {{ chef.speciality }}</small></p>
                        </div>

                    </div>
                </div>

                <div class="hidden card-footer text-center" v-if="chef.dish">
                    <a class="btn btn-sm btn-primary" href="/register">
                        <i class="fas fa-shopping-basket"></i> <strong>Gerecht deze week</strong>: {{ chef.dish.name }}</a>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    mounted() {
        console.log('chefs mounted.')
    },

    data() {
        return {
            chefs: [],
        }
    },
    methods: {
        read() {
            axios.get('/api/chefs').then(({data}) => {
                //console.log(data)
                this.chefs = data;
            }).catch((err) => console.error(err));
        },
    },
    mounted() {
        this.read();
    }
}
</script>
