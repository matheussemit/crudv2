<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Cadastrar filme</h2>
            <form action="<?php echo URLROOT; ?>/filmes/register" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="original_title">Original title: <sup>*</sup></label>
                            <input type="text" name="original_title" class="form-control form-control-lg" value="<?php echo $data['original_title']; ?>">
                        </div>
                        <div class="col-6">                    
                            <label for="overview">Overview: <sup>*</sup></label>
                            <input type="text" name="overview" class="form-control form-control-lg" value="<?php echo $data['overview']; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rating">Rating: <sup>*</sup></label>
                    <input type="text" name="rating" class="form-control form-control-lg" value="<?php echo $data['rating']; ?>">
                </div>

                <div class="row">
                    <div class="col">
                        <input type="submit" value="Cadastrar" class="btn btn-success btn-block">
                    </div>
                    <!-- <div class="col">
                        <a href="<?php echo URLROOT ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                    </div> -->
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>