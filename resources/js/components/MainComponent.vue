<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-white bg-dark">
                    <div class="card-header">Over Bori</div>

                    <div class="card-body">
                        <p> Bori is a Take out service based in Amsterdam!!
                            <Br />
                            <Br />
                            interdum tellus dapibus non. Fusce sit amet lacus in velit venenatis finibus in id ligula.
                            Mauris ex diam, tristique et rhoncus vel, hendrerit eget mauris. Etiam facilisis rutrum
                            nulla, vitae accumsan magna aliquam et. Donec ac risus eu sem dictum tempus.</p>

                    </div>
                </div>

                <div class="card bg-light">
                    <div class="card-header">T-shirt bestellen</div>

                    <div class="card-body">
                        <p> Get your original t-shirt for only &euro; 29,50
                            <Br />
                            <Br />
                            interdum tellus dapibus non. Fusce sit amet lacus in velit venenatis finibus in id ligula.
                            Mauris ex diam, tristique et rhoncus vel, hendrerit eget mauris. Etiam facilisis rutrum
                            nulla,
                            vitae accumsan magna aliquam et. Donec ac risus eu sem dictum tempus.</p>
                        <img src="/images/patta-example.jpeg" />



                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flat-border border-dark">
                    <div class="card-header flat-border bg-dark text-white"><img src="/images/bori-white.svg" class="card-header-img"> <strong>Menu today</strong> </div>

                    <div class="card-body">
                        <p>Praesent vitae ipsum sed nibh convallis vulputate aliquet a erat.</p>

                        <ul>
                            <li>cassave soep (vega)</li>
                            <li>kip (zoutvlees)</li>
                            <li>&euro; 12,- per liter</li>
                        </ul>

                        <hr/>
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with
                                    anyone else.</small>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary ">Submit</button>
                            </div>
                        </form>
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
