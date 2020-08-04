<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-white bg-dark ">
                    <div class="card-header">Get your T-shirt!</div>

                    <div class="card-body">
                        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ultrices libero tellus,
                            suscipit
                            interdum tellus dapibus non. Fusce sit amet lacus in velit venenatis finibus in id ligula.
                            Mauris ex diam, tristique et rhoncus vel, hendrerit eget mauris. Etiam facilisis rutrum
                            nulla,
                            vitae accumsan magna aliquam et. Donec ac risus eu sem dictum tempus.</p>
                        <p>Vivamus vulputate
                            ullamcorper lectus, ac fringilla nibh varius id. Mauris gravida, erat nec iaculis
                            pellentesque,
                            quam leo finibus ipsum, vel ornare ipsum velit et nunc. Ut condimentum augue et tincidunt
                            maximus. Nam ex ipsum, fringilla eget enim eget, venenatis facilisis metus. Proin congue
                            quam
                            eget dignissim placerat. Proin vestibulum libero nulla, non cursus arcu tincidunt
                             placerat. Proin vestibulum libero nulla, non cursus arcu tincidunt
                            feugiat.</p>


                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white"><img src="/images/bori-white.svg" class="card-header-img"> Menu today</div>

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
