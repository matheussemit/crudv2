<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Alterar senha</h2>
            <form action="<?php echo URLROOT;?>/users/primeiro_acesso/<?php echo $data['id'];?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="nome">Nome: <sup>*</sup></label>
                            <input type="text" name="nome" readonly class="form-control form-control-lg <?php echo (!empty($data['nome_err'])) ? 'is-invalid' : ''?>" value="<?php echo $data['nome']; ?>">
                            <span class="invalid-feedback"><?php echo $data['nome_err'];  ?></span>
                        </div>
                        <div class="col-6">                    
                            <label for="sobrenome">Sobrenome: <sup>*</sup></label>
                            <input type="text" name="sobrenome" readonly class="form-control form-control-lg <?php echo (!empty($data['sobrenome_err'])) ? 'is-invalid' : ''?>" value="<?php echo $data['sobrenome']; ?>">
                            <span class="invalid-feedback"><?php echo $data['sobrenome_err'];  ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="usuario">Usuário: <sup>*</sup></label>
                    <input type="text" name="usuario" readonly class="form-control form-control-lg <?php echo (!empty($data['usuario_err'])) ? 'is-invalid' : ''?>" value="<?php echo $data['usuario']; ?>">
                    <span class="invalid-feedback"><?php echo $data['usuario_err'];  ?></span>
                </div>

                <div class="form-group">
                    <label for="password">Senha: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''?>" value="">
                    <span class="invalid-feedback"><?php echo $data['password_err'];  ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmação senha: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''?>" value="">
                    <span class="invalid-feedback"><?php echo $data['confirm_password_err'];  ?></span>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="submit" value="Salvar" class="btn btn-success btn-block">
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