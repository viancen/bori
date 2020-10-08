<template>
    <div v-if="!loading">
        <div class="card flat-border border-dark" v-if="random.dish">
            <div class="card-header flat-border bg-dark text-white">
                <img src="/images/bori-white.svg" class="card-header-img"> <strong>{{ random.dish.name }}</strong> van
                <img :src="random.avatar" class="card-header-avatar-img"/> <strong>{{ random.name }}</strong>
            </div>

            <div class="card-body">
                <p>{{ random.dish.description }}</p>
                <CoolLightBox
                    :items="items"
                    :index="index"
                    @close="index = null">
                </CoolLightBox>
                <div
                    class="image cursor-pointer"
                    v-for="(image, imageIndex) in items"
                    :key="imageIndex"
                    @click="index = imageIndex"
                >
                    <img :src="image" class=" dish-image">
                </div>

            </div>
            <div class="card-body">

                <strong>Portie:</strong> <span class="text-danger"> {{ random.dish.amount }}</span><br/>
                <strong>Prijs:</strong> <span class="text-danger"> &euro; {{ random.dish.price }}</span>

            </div>
            <div class="card-footer text-center">

                <a class="btn btn-sm btn-primary" href="#" id="show-modal" @click="showModal = true">
                    <i class="fas fa-shopping-basket"></i> Bestellen: &euro;{{ random.dish.price }} <sup>(per
                    portie)</sup></a>

            </div>
        </div>
        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Bestellen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" @click="showModal = false">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Hier het bestelformulier.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" @click="showModal = false">Close
                                    </button>
                                    <button type="button" class="btn btn-primary">Bestllen</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>

</template>

<script>

import CoolLightBox from 'vue-cool-lightbox'
import 'vue-cool-lightbox/dist/vue-cool-lightbox.min.css'
// register modal component


export default {
    mounted() {
        console.log('Menu mounted.')
    },

    data() {
        return {
            showModal: false,
            items: [],
            index: null,
            random: null,
            loading: true
        }
    },
    methods: {
        read() {

            axios.get('/api/random-dish').then(({data}) => {
                //console.log(data)
                this.items = [
                    data.dish.image1,
                    data.dish.image2,
                    data.dish.image3
                ];
                this.random = data;
                this.loading = false;


            }).catch((err) => console.error(err));
        }
    },
    components: {
        CoolLightBox
    },
    mounted() {
        this.read();
    }
}
</script>
