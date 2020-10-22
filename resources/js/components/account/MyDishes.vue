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
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="file" id="avatar" class="form-control" ref="avatar"
                                               v-on:change="handleAvatar()"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <img v-if="profile.avatar" :src="profile.avatar" id="image-profile"
                                         class="rounded mx-auto d-block max-width-150">
                                </div>
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
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="file" id="image1" class="form-control" ref="image1"
                                               v-on:change="handleFileUpload(1)"/>

                                    </div>
                                </div>
                                <div class="col">
                                    <img v-if="dish.image1" :src="dish.image1" id="dish-image-1"
                                         class="rounded mx-auto d-block max-width-150">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">


                                    <div class="input-group">
                                        <input type="file" id="image2" class="form-control" ref="image2"
                                               v-on:change="handleFileUpload(2)"/>

                                    </div>
                                </div>
                                <div class="col">
                                    <img v-if="dish.image2" :src="dish.image2" id="dish-image-2"
                                         class="rounded mx-auto d-block max-width-150">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="file" id="imag3" class="form-control" ref="image3"
                                               v-on:change="handleFileUpload(3)"/>

                                    </div>
                                </div>
                                <div class="col">
                                    <img v-if="dish.image3" :src="dish.image3" id="dish-image-3"
                                         class="rounded mx-auto d-block max-width-150">
                                </div>
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
            file: '',
            avatar: '',
            dishImageNr: 1,
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
        handleFileUpload(nr) {
            this.dishImageNr = nr;
            if (nr == 1) {
                this.file = this.$refs.image1.files[0];
            } else if (nr == 2) {
                this.file = this.$refs.image2.files[0];
            } else {
                this.file = this.$refs.image3.files[0];
            }
            this.submitFile();
        },
        handleAvatar(nr) {
            this.avatar = this.$refs.avatar.files[0];
            this.submitAvatar();
        },
        /*
           Submits the file to the server
         */
        submitFile() {
            /*
            set a form
             */
            let formData = new FormData();

            /*
                Add the form data we need to submit
            */
            formData.append('file', this.file);

            let imgnr = this.dishImageNr;
            /*
              Make the request to the POST /single-file URL
            */
            axios.post('/api/upload-dish-image/' + this.dish.id + '/' + this.dishImageNr,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(function (resp) {
                document.getElementById('dish-image-' + imgnr).src = resp.data;
            }).catch(function (e) {
                console.log('FAILURE!!', e);
            });
        },
        /*
                   Submits the file to the server
                 */
        submitAvatar() {
            /*
            set a form
             */
            let formData = new FormData();

            /*
                Add the form data we need to submit
            */
            formData.append('file', this.avatar);

            /*
              Make the request to the POST /single-file URL
            */
            axios.post('/api/upload-profile-image',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(function (resp) {
                document.getElementById('image-profile').src = resp.data;
            }).catch(function () {

            });
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
