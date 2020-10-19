<template>
    <div class="container">
        <div v-if="!loading">
            <div class="card flat-border border-dark">
                <div class="card-header flat-border bg-dark text-white">
                    <img :src="profile.avatar" class="card-header-img"> <strong>{{ profile.name }}</strong>
                </div>

                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-profile"
                               role="tab" aria-controls="nav-home" aria-selected="true"> <i
                                class="far fa-fw fa-user-circle"></i> Profiel</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-dish"
                               role="tab" aria-controls="nav-profile" aria-selected="false"> <i
                                class="fas fa-fw fa-cloud-meatball"></i> Mijn gerecht</a>
                        </div>
                    </nav>
                    <div class="tab-content border padding-20" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel"
                             aria-labelledby="nav-home-tab">
                            <label>Naam</label>
                            <div class="input-group">
                                <input v-model="profile.name" class="form-control" v-on:change="waitToSave"></input>
                            </div>
                            <div><br/></div>
                            <label>Ik ben beschikbaar voor leveringen</label>
                            <div class="input-group">
                                <select v-model="profile.available" class="form-control" v-on:change="waitToSave">
                                    <option value="1">Ja, beschikbaar</option>
                                    <option value="0">Nee, op vakantie</option>
                                </select>
                            </div>
                            <div><br/></div>
                            <label>Specialiteit</label>
                            <div class="input-group">
                                <input v-model="profile.speciality" class="form-control"
                                       v-on:change="waitToSave"></input>
                            </div>
                            <div><br/></div>
                            <label>Picture</label>
                            <div class="input-group">
                                <input v-model="profile.avatar" class="form-control" v-on:change="waitToSave"></input>
                            </div>

                            <div><br/></div>
                            <label>Profiel beschrijving</label>
                            <div class="input-group">
                                <textarea v-model="profile.description" class="form-control" style="min-height: 100px;"
                                          v-on:change="waitToSave"></textarea>
                            </div>

                            <div><br/></div>
                            <div>
                                <button type="button" class="btn btn-dark btn-default">Save</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-dish" role="tabpanel" aria-labelledby="nav-profile-tab"
                             v-if="!loadingDish">
                            <label>Naam gerecht</label>
                            <div class="input-group">
                                <input v-model="dish.name" placeholder="Bijv. Pindasoep" class="form-control"
                                       v-on:change="waitToSaveDish"></input>
                            </div>
                            <div><br/></div>
                            <label>Categorie</label>
                            <div class="input-group">
                                <input v-model="dish.category" placeholder="Bijv. Soepen" class="form-control"
                                       v-on:change="waitToSaveDish"></input>
                            </div>
                            <div><br/></div>
                            <label>Prijs per</label>
                            <div class="input-group">
                                <input v-model="dish.price" placeholder="Bijv. 19,50" class="form-control"
                                       v-on:change="waitToSaveDish"></input>

                                <input v-model="dish.amount" placeholder="Bijv. per liter" class="form-control"
                                       v-on:change="waitToSaveDish"></input>
                            </div>
                            <div><br/></div>
                            <label>Afbeelding(en)</label>
                            <div class="input-group">
                                <input v-model="dish.image1" placeholder="Voer een complete url in" class="form-control"
                                       v-on:change="waitToSaveDish"></input>
                            </div>
                            <div><br/></div>
                            <div class="input-group">
                                <input v-model="dish.image2" placeholder="Voer een complete url in" class="form-control"
                                       v-on:change="waitToSaveDish"></input>
                            </div>
                            <div><br/></div>
                            <div class="input-group">
                                <input v-model="dish.image3" placeholder="Voer een complete url in" class="form-control"
                                       v-on:change="waitToSaveDish"></input>
                            </div>
                            <div><br/></div>
                            <label>Omschrijving</label>
                            <div class="input-group">
                                <textarea v-model="dish.description" class="form-control" style="min-height: 200px;"
                                          placeholder="Text over dit gerecht"
                                          v-on:change="waitToSaveDish"></textarea>
                            </div>
                            <div><br/></div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</template>

<script>


// register modal component


export default {
    mounted() {

    },

    data() {
        return {
            profile: null,
            dish: null,
            loading: true,
            loadingDish: true
        }
    },
    methods: {
        read() {

            axios.get('/api/me').then(({data}) => {

                this.profile = data;
                this.loading = false;

                axios.get('/api/dish').then(({data}) => {

                    this.dish = data;
                    this.loadingDish = false;


                }).catch((err) => console.error(err));

            }).catch((err) => console.error(err));


        },
        waitToSave: function () {
            // Unset previous timeout.
            clearTimeout(this.timeout);
            // Set current timeout.
            // If no further changes after 1 second, then save the change.
            this.timeout = setTimeout(this.signalChange.bind(this), this.waitTime);
        },
        signalChange: function () {
            axios.put('/api/save-me', {
                data: this.profile
            }).then(response => {
                console.log("Change saved...")
            }).catch(e => {
                console.log("Error... ")
            });
        },
        waitToSaveDish: function () {
            // Unset previous timeout.
            clearTimeout(this.timeout);
            // Set current timeout.
            // If no further changes after 1 second, then save the change.
            this.timeout = setTimeout(this.signalChangeDish.bind(this), this.waitTime);
        },
        signalChangeDish: function () {
            axios.put('/api/dish/' + this.dish.id, {
                data: this.dish
            }).then(response => {
                console.log("Change saved...")
            }).catch(e => {
                console.log("Error... ")
            });
        }
    },
    mounted() {
        this.read();
    }
}
</script>
