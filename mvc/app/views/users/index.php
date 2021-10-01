<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="row">
    <div class="col-md-6">
        <h1>Usuários cadastrados</h1>
    </div>
</div>
<?php
flash('update_success');
?>


    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>Nome</th>
                    <th>Login</th>
                    <th>Opções</th>
            </tr>
        </thead>
        <tbody>
<?php foreach($data['users'] as $user): ?>
            <tr>
                <td><?php echo $user->nome_completo;?></td>

                    <td><?php echo $user->login;?></td>
                    <td><a href="<?php echo URLROOT;?>/users/edit/<?php echo $user->id;?>" class="btn btn-dark">Editar</a>
                    <a href="<?php echo URLROOT;?>/users/delete/<?php echo $user->id;?>" onclick="return confirm('Deseja realmente excluir esse usuário?');" class="btn btn-danger" role="button">Excluir</a>
                </td>

            </tr>
<?php endforeach; ?>
        </tbody>
    </table>

<?php require APPROOT . '/views/includes/footer.php'; ?>

