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

                <div class="text-center">
                    <div
                        class="image dish-image cursor-pointer"
                        v-for="(image, imageIndex) in items"
                        :key="imageIndex"
                        @click="index = imageIndex"
                    >
                        <img :src="image">
                    </div>
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
                                    Je gaat bestellen: <h4>{{ random.dish.name }} van {{ random.name }}</h4>

                                    Na je bestelling neemt onze chef contact met je op over de levering en betaling.
                                    <div class="form-row margin-top-10">

                                        <div class="col">
                                            <div class="input-group ">
                                                <input type="text" class="form-control" id="email"
                                                       placeholder="Je e-mail *"
                                                       name="email">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i
                                                        class="fa fa-at"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group ">
                                                <input type="text" class="form-control" id="phone"
                                                       placeholder="Je telefoonnummer *" name="phone">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i
                                                        class="fa fa-phone"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="form-row margin-top-10">
                                        <div class="col">
                                            <div class="input-group ">
                                                <input type="text" class="form-control" id="street" required
                                                       placeholder="Straat *" name="street">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i
                                                        class="fa fa-map-marker"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group ">
                                                <input type="text" class="form-control" id="housenr" required
                                                       placeholder="huisnr *" name="housenr">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i
                                                        class="fa fa-map-marker"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row margin-top-10">
                                        <div class="col">
                                            <div class="input-group ">
                                                <input type="text" class="form-control" id="zipcode" required
                                                       placeholder="Postcode *" name="zipcode">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i
                                                        class="fa fa-map-marker"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group ">
                                                <input type="text" class="form-control" id="city" required
                                                       placeholder="Plaats *" name="city">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i
                                                        class="fa fa-map-marker"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="form-row margin-top-10">
                                        <div class="col">
                                            <div class="input-group ">

                                            <textarea class="form-control" id="comment"
                                                      placeholder="Opmerkingen/allergieen/complimenten ;) etc"
                                                      name="comments"></textarea>
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i
                                                        class="fa fa-comment-alt"></i></div>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                    <br/>
                                    <div class="form-row margin-top-10">

                                        <div class="col">
                                            <div class="input-group ">
                                                <select class="form-control" id="portion-amount" name="amount"
                                                        @change="caculateOrder">
                                                    <option value="1">1 portie</option>
                                                    <option value="2">2 porties</option>
                                                    <option value="3">3 porties</option>
                                                    <option value="4">4 porties</option>
                                                    <option value="5">5 porties</option>
                                                </select>
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i
                                                        class="fa fa-shopping-basket"></i></div>
                                                </span>
                                            </div>

                                        </div>


                                    </div>
                                    <div class=" margin-top-10 text-right">
                                        Totaal: <span class="text-secondary">
                                        &euro;</span> <span id="total-price"
                                                            class="text-secondary strong">{{ random.dish.price }}</span>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" @click="showModal = false">Sluiten
                                    </button>
                                    <button type="button" class="btn btn-primary">Bestellen</button>
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
        },
        caculateOrder() {

            console.log(parseFloat(this.random.dish.price));
            console.log(parseInt(document.getElementById('portion-amount').value));

            let price = parseFloat(parseFloat(parseFloat(this.random.dish.price) * parseInt(document.getElementById('portion-amount').value))).toFixed(2);
            document.getElementById('total-price').innerHTML = price;
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
