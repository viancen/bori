<template>
    <div v-if="!loading">
        <div class="card flat-border border-dark" v-if="random.dish && showModal == false && showThanks == false">
            <div class="card-header flat-border bg-dark text-white">
                <img src="/static-images/bori-white.svg" class="card-header-img"> <strong>{{
                    random.dish.name
                }}</strong> van
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

                <div class="margin-top-10 display-block"><Br/>
                    <ul>
                        <li v-if="random.dish.category">
                            {{ random.dish.category }}
                        </li>
                        <li v-if="random.dish.price"> &euro;
                            {{ random.dish.price }} per {{ random.dish.amount }}
                        </li>
                        <li v-if="random.dish.timespan">
                            <strong> {{ random.dish.timespan }}</strong> <span v-if="random.dish.delivery_cost">( bezorging: &euro; {{
                                random.dish.delivery_cost
                            }} )</span>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="card-footer text-center">

                <a class="btn btn-sm btn-primary" href="javascript:void(0);" @click="showModal = true">
                    <i class="fas fa-shopping-basket"></i> Bestellen: &euro;{{ random.dish.price }} <sup>(per
                    portie)</sup></a>

            </div>
        </div>
        <div v-if="showThanks">
            <div class="card flat-border border-success" v-if="random.dish">

                <div class="card-header flat-border bg-success text-white">
                    <img src="/static-images/bori-white.svg" class="card-header-img">
                    Je bestelling is geplaatst: <strong>{{
                        random.dish.name
                    }}</strong> van
                    <img :src="random.avatar" class="card-header-avatar-img"/> <strong>{{ random.name }}</strong>
                </div>

                <div class="card-body">
                    Bedankt voor je bestelling, je hebt een e-mail ontvangen met de details!
                </div>
            </div>
        </div>
        <div v-if="showModal">
            <div class="card flat-border border-dark" v-if="random.dish">

                <div class="card-header flat-border bg-dark text-white">
                    <img src="/static-images/bori-white.svg" class="card-header-img">
                    Bestellen: <strong>{{
                        random.dish.name
                    }}</strong> van
                    <img :src="random.avatar" class="card-header-avatar-img"/> <strong>{{ random.name }}</strong>
                </div>

                <div class="card-body">
                    Je gaat bestellen: <h4>{{ random.dish.name }} van {{ random.name }}</h4>
                    <div class="form-row margin-top-10">

                        <div class="col">

                            <div class="input-group">
                                <input type="text" class="form-control " required id="full_name"
                                       v-model="order.full_name"
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

                            <div class="input-group">
                                <input type="text" class="form-control" required id="email" v-model="order.email"
                                       placeholder="Je e-mail *"
                                       name="email">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-at"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-row margin-top-10">
                        <div class="col">
                            <div class="input-group ">
                                <input type="text" class="form-control" required id="phone" v-model="order.phone"
                                       placeholder="Je telefoonnummer *" name="phone">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-phone"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    <p>&nbsp;</p>
                    <div class="form-row margin-top-10">

                        <div class="col">
                            <label for="portion-amount">Aantal porties</label>
                            <div class="input-group ">
                                <select class="form-control" id="portion-amount" name="amount" v-model="order.amount"
                                        @change="caculateOrder">
                                    <option value="1" selected="selected">1 portie</option>
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

                    <div class="form-row margin-top-10">

                        <div class="col">
                            <label for="portion-transfer">{{ random.dish.timespan }} *</label>
                            <div class="input-group ">
                                <select class="form-control" id="portion-transfer" name="transfer"
                                        v-model="order.transfer"
                                        @change="caculateOrder">
                                    <option value="take-away" selected="selected">Afhalen</option>

                                    <option v-if="random.dish.delivery_cost" value="deliver">Bezorgen (+
                                        &euro; {{ random.dish.delivery_cost }})
                                    </option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i
                                        class="fa fa-car"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row margin-top-10">
                        <div class="col">
                            <label for="comment">Opmerkingen *</label>
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
                    <p>&nbsp;</p>

                    <div class=" margin-top-10 text-right">
                        Totaal:
                        <span class="text-secondary">
                            &euro;
                        </span>
                        <span id="total-price" class="text-secondary strong">
                            {{ random.dish.price }}
                        </span>

                    </div>
                    <div v-if="error" class="display-block">
                        <div class="alert alert-danger">Vul a.u.b. alle verplichte velden in.</div>
                    </div>
                    <div v-if="sendingorder" class="display-block">
                        <div class="alert alert-success">Een moment, je bestelling wordt geplaatst.</div>
                    </div>
                    <div class="display-block margin-top-10">


                        <vue-recaptcha
                            @verify="onVerify"
                            @expired="onExpired"
                            sitekey="6Ld74skZAAAAAJ7MNZyD2ZvzgIKqRE0RY_5Gnxwb">
                            <button class="btn btn-primary btn-default" style="width: 100%" v-if="!order.recaptcha">
                                <i class="fas fa-check"></i> Ik woon in Amsterdam &raquo;
                            </button>
                        </vue-recaptcha>

                        <a @click="showModal = false">annuleren
                        </a>
                    </div>
                    <div class="display-block margin-top-10" v-if="order.recaptcha">
                        <button @click="placeOrder" class="btn btn-success btn-default" style="width: 100%">
                            <i class="fas fa-check"></i> Plaats mijn bestelling!
                        </button>
                    </div>
                </div>
            </div>


        </div>
    </div>

</template>

<script>

import CoolLightBox from 'vue-cool-lightbox'
import 'vue-cool-lightbox/dist/vue-cool-lightbox.min.css'
import VueRecaptcha from 'vue-recaptcha';

// register modal component


export default {
    mounted() {
        console.log('Menu mounted.')
    },

    data() {
        return {
            showModal: false,
            showThanks: false,
            items: [],
            index: null,
            order: {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                user_id: null,
                dish_id: null,
                token: null,
                city: null,
                full_name: null,
                email: null,
                phone: null,
                street: null,
                housenr: null,
                comment: null,
                zipcode: null,
                transfer: 'take-away',
                recaptcha: null,
                amount: 1
            },
            random: null,
            error: false,
            sendingorder: false,
            loading: true
        }
    },

    methods: {

        read() {

            axios.get('/api/random-dish').then(({data}) => {
                //console.log(data)
                this.items = [];
                if (data.dish.image1) {
                    this.items.push(data.dish.image1)
                }
                if (data.dish.image2) {
                    this.items.push(data.dish.image2)
                }
                if (data.dish.image3) {
                    this.items.push(data.dish.image3)
                }

                data.dish.price = data.dish.price.toFixed(2);

                this.random = data;
                this.order.dish_id = data.dish.id;
                this.order.user_id = data.id;
                this.loading = false;


            }).catch((err) => console.error(err));
        },
        async caculateOrder() {
            let price = parseFloat(parseFloat(parseFloat(this.random.dish.price) * parseInt(document.getElementById('portion-amount').value))).toFixed(2);

            document.getElementById('total-price').innerHTML = price;
        },
        placeOrder() {

            if (this.order.full_name && this.order.email && this.order.amount && this.order.zipcode && this.order.phone && this.order.housenr && this.order.recaptcha) {
                this.error = false;
                this.sendingorder = true;


                axios.post('/api/place-order', this.order).then(({data}) => {

                    this.showModal = false;
                    this.showThanks = true;

                }).catch((err) => console.error(err));
            } else {
                console.log(this.order);
                this.error = true;
            }
        },
        onVerify(dara) {
            this.order.recaptcha = (dara);
        },
        onExpired(dara) {
            console.log(dara);
        }
    },
    components: {
        CoolLightBox,
        VueRecaptcha
    },
    mounted() {
        this.read();

    }
}
</script>
