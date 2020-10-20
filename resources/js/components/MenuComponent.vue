<template>
    <div v-if="!loading">
        <div class="card flat-border border-dark" v-if="random.dish && showModal == false">
            <div class="card-header flat-border bg-dark text-white">
                <img src="/images/bori-white.svg" class="card-header-img"> <strong>{{ random.dish.name }}</strong> van
                <img :src="random.avatar" class="card-header-avatar-img"/> <strong>{{ random.name }}</strong>
            </div>

            <div class="card-body">
                <p v-html="random.dish.description"></p>
                <CoolLightBox
                    :items="items"
                    :index="index"
                    @close="index = null">
                </CoolLightBox>

                <div class="text-center dish-images">
                    <div
                        class="image dish-image cursor-pointer"
                        v-for="(image, imageIndex) in items"
                        :key="imageIndex"
                        @click="index = imageIndex"
                    >
                        <img :src="image">
                    </div>
                </div>

                <div class="margin-top-10 display-block">
                    <h3>
                        <div class=" margin-top-10 badge  badge-dark" v-if="random.dish.category">
                            {{ random.dish.category }}
                        </div>
                        <div v-if="random.dish.amount" class="margin-top-10 badge text-lg-center badge-dark">
                            {{ random.dish.amount }}
                        </div>
                        <div v-if="random.dish.price" class=" margin-top-10 badge  badge-dark"> &euro;
                            {{ random.dish.price }}
                        </div>

                    </h3>
                </div>
            </div>

            <div class="card-footer text-center">

                <a class="btn btn-sm btn-primary" href="javascript:void(0);" @click="showModal = true">
                    <i class="fas fa-shopping-basket"></i> Bestellen: &euro;{{ random.dish.price }} <sup>(per
                    portie)</sup></a>

            </div>
        </div>
        <div v-if="showModal">
            <div class="card flat-border border-dark" v-if="random.dish">

                <div class="card-header flat-border bg-dark text-white">
                    <img src="/images/bori-white.svg" class="card-header-img">
                    Bestellen: <strong>{{
                        random.dish.name
                    }}</strong> van
                    <img :src="random.avatar" class="card-header-avatar-img"/> <strong>{{ random.name }}</strong>
                </div>

                <div class="card-body">
                    Je gaat bestellen: <h4>{{ random.dish.name }} van {{ random.name }}</h4>
                    <div class="form-row margin-top-10">

                        <div class="col">
                            <div class="input-group ">
                                <input type="text" class="form-control" id="full_name" v-model="order.full_name"
                                       placeholder="Je naam *"
                                       name="full_name">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-at"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row margin-top-10">


                        <div class="col">
                            <div class="input-group ">
                                <input type="text" class="form-control" id="email" v-model="order.email"
                                       placeholder="Je e-mail *"
                                       name="email">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-at"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group ">
                                <input type="text" class="form-control" id="phone" v-model="order.phone"
                                       placeholder="Je telefoonnummer *" name="phone">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-phone"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="form-row margin-top-10">
                        <div class="col">
                            <div class="input-group ">
                                <input type="text" class="form-control" id="street" required v-model="order.street"
                                       placeholder="Straat *" name="street">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-map-marker"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group ">
                                <input type="text" class="form-control" id="housenr" required v-model="order.housenr"
                                       placeholder="huisnr *" name="housenr">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-map-marker"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row margin-top-10">
                        <div class="col">
                            <div class="input-group ">
                                <input type="text" class="form-control" id="zipcode" required v-model="order.zipcode"
                                       placeholder="Postcode *" name="zipcode">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-map-marker"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group ">
                                <input type="text" class="form-control" id="city" required v-model="order.city"
                                       placeholder="Plaats *" name="city">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-map-marker"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="form-row margin-top-10">
                        <div class="col">
                            <div class="input-group ">

                                            <textarea class="form-control" id="comment" v-model="order.comment"
                                                      placeholder="Opmerkingen/allergieen/complimenten ;) etc"
                                                      name="comments"></textarea>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-comment-alt"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br/>
                    <div class="form-row margin-top-10">

                        <div class="col">
                            <div class="input-group ">
                                <select class="form-control" id="portion-amount" name="amount" v-model="order.amount"
                                        @change="caculateOrder">
                                    <option value="1">1 portie</option>
                                    <option value="2">2 porties</option>
                                    <option value="3">3 porties</option>
                                    <option value="4">4 porties</option>
                                    <option value="5">5 porties</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-shopping-basket"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="form-row margin-top-10">

                        <div class="col">
                            <div class="input-group ">
                                <select class="form-control" id="portion-transfer" name="transfer"
                                        v-model="order.transfer"
                                        @change="caculateOrder">
                                    <option value="take-away">Afhalen</option>
                                    <option value="deliver">Brengen</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-car"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" margin-top-10 text-right">
                        Totaal:
                        <span class="text-secondary">
                            &euro;
                        </span>
                        <span id="total-price" class="text-secondary strong">
                            {{ random.dish.price }}
                        </span>

                    </div>

                </div>
                <div class="card-footer text-center">
                    <button type="button" class="btn btn-secondary" @click="showModal = false">Sluiten
                    </button>
                    <button type="button" @click="placeorder" class="btn btn-primary">Bestellen</button>
                </div>
            </div>


        </div>
    </div>

</template>

<script>

import CoolLightBox from 'vue-cool-lightbox'
import 'vue-cool-lightbox/dist/vue-cool-lightbox.min.css'

import {VueReCaptcha} from 'vue-recaptcha-v3'

window.Vue.use(VueReCaptcha, {
    siteKey: '6Ld74skZAAAAAJ7MNZyD2ZvzgIKqRE0RY_5Gnxwb'
})
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
            order: {
                token: null,
                city: null,
                full_name: null,
                email: null,
                phone: null,
                street: null,
                housenr: null,
                comment: null,
                zipcode: null,
                transfer: null,
                amount: null
            },
            random: null,
            loading: true
        }
    },
    methods: {
        async recaptcha() {
            // (optional) Wait until recaptcha has been loaded.
            await this.$recaptchaLoaded()

            const recaptcha = this.$recaptchaInstance

            // Hide reCAPTCHA badge:
            recaptcha.hideBadge()

            // Execute reCAPTCHA with action "login".
            this.order.token = await this.$recaptcha('order')

            console.log(this.order);
        },
        placeorder() {
            this.recaptcha();
        },
        read() {

            axios.get('/api/random-dish').then(({data}) => {
                //console.log(data)
                this.items = [
                    data.dish.image1,
                    data.dish.image2,
                    data.dish.image3
                ];
                data.dish.price = data.dish.price.toFixed(2);

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
