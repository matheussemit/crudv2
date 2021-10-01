<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Editar usuário</h2>
            <form action="<?php echo URLROOT;?>/users/edit/<?php echo $data['user']->id;?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="nome">Nome: <sup>*</sup></label>
                            <input type="text" name="nome" class="form-control form-control-lg <?php echo (!empty($data['nome_err'])) ? 'is-invalid' : ''?>" value="<?php echo $data['user']->nome; ?>">
                            <span class="invalid-feedback"><?php echo $data['nome_err'];  ?></span>
                        </div>
                        <div class="col-6">                    
                            <label for="sobrenome">Sobrenome: <sup>*</sup></label>
                            <input type="text" name="sobrenome" class="form-control form-control-lg <?php echo (!empty($data['sobrenome_err'])) ? 'is-invalid' : ''?>" value="<?php echo $data['user']->sobrenome; ?>">
                            <span class="invalid-feedback"><?php echo $data['sobrenome_err'];  ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="usuario">Usuário: <sup>*</sup></label>
                    <input type="text" name="usuario" readonly class="form-control form-control-lg <?php echo (!empty($data['usuario_err'])) ? 'is-invalid' : ''?>" value="<?php echo $data['user']->login; ?>">
                    <span class="invalid-feedback"><?php echo $data['usuario_err'];  ?></span>
                </div>
                <div class="mb-3">
                    <a href="<?php echo URLROOT;?>/users/reset_password/<?php echo $data['user']->id;?>" onclick="return confirm('Deseja resetar a senha para 123456?');" class="btn btn-dark">Resetar senha</a>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Editar" class="btn btn-success btn-block">
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