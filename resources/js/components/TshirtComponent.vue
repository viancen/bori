<template>
    <div class="card flat-border bg-light">
        <div class="card-header"><i class="fas fa-tshirt"></i> Pre-order jouw t-shirt</div>

        <div class="card-body">
            <p> Get your original t-shirt for only &euro; 29,50
                <Br/>
                <Br/>
                interdum tellus dapibus non. Fusce sit amet lacus in velit venenatis finibus in id ligula.
                Mauris ex diam, tristique et rhoncus vel, hendrerit eget mauris. Etiam facilisis rutrum
                nulla,
                vitae accumsan magna aliquam et. Donec ac risus eu sem dictum tempus.</p>
            <img src="/images/patta-example.jpeg"/>
            <hr/>
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" required class="form-control" id="exampleInputEmail1"
                           aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">Blijft helemaal geheim, we delen geen gegevens met derden.</small>
                </div>

                <div class="form-check">
                    <input type="checkbox" required class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Ik ga akkoord met de privacy policy & algemene
                        voorwaarden</label>
                </div>
                <div class="text-right"><br/>
                    <button type="submit" class="btn btn-primary "><i class="fas fa-check"></i> Pre-order now</button>
                </div>
            </form>


        </div>
    </div>
</template>

<script>

    export default {
        mounted() {
            console.log('T-sjirts mounted.')
        }
    }
</script>
