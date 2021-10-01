<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="row">
    <div class="col-md-6">
        <h1>Filmes cadastrados</h1>
    </div>
</div>
<?php
flash('update_success');
?>


    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>Nome</th>
                    <th>Overview</th>
                    <th>Rating</th>
                    <th>Opções</th>
            </tr>
        </thead>
        <tbody>
<?php foreach($data['filmes'] as $filme): ?>
            <tr>
                <td><?php echo $filme->original_title;?></td>
                <td><?php echo $filme->overview;?></td>
                    <td><?php echo $filme->rating;?></td>
                    <td><a href="<?php echo URLROOT;?>/filmes/edit/<?php echo $filme->id;?>" class="btn btn-dark">Editar</a>
                    <a href="<?php echo URLROOT;?>/filmes/delete/<?php echo $filme->id;?>" onclick="return confirm('Deseja realmente excluir esse filme?');" class="btn btn-danger" role="button">Excluir</a>
                </td>

            </tr>
<?php endforeach; ?>
        </tbody>
    </table>

<?php require APPROOT . '/views/includes/footer.php'; ?>

