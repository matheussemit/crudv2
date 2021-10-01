<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h3>Visualizar usuário</h3>
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Info</th>
                        <th>Dado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nome</td>
                        <td><?php echo $data['user']->nome . " " . $data['user']->sobrenome; ?></td>
                    </tr>
                    <tr>
                        <td>Usuário</td>
                        <td><?php echo $data['user']->login; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <a
            href="<?php echo URLROOT;?>"
            class="btn btn-sm btn-dark float-right"
        >Voltar</a>
    </div>
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>