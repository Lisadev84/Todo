<?php
require_once 'errors.php';

/* sauvegarde des todos */
$filename = __DIR__ . "/data/todos.json";
$todo = '';
$todos = [];
$error = "";

if (file_exists($filename)) {
    $data = file_get_contents($filename);
    $todos = json_decode($data, true) ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once 'add-todo.php';
}
?> 

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php' ?>
    <title>Todo</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="todo-container">
                <h1>Ma Todo</h1>
              
                <form class="todo-form" action="index.php" method="POST">
                    <input value="<?= $todo ?>" type="text" name="todo">
                    <button class="btn btn-primary">Ajouter</button>
                </form>
                <?php if ($error) : ?>
                    <p class="text-danger"><?= $error ?></p>
                <?php endif; ?>
                <ul class="todo-list">
                    <?php foreach ($todos as $t) : ?>
                        <li class="todo-item <?= $t['done'] ? 'low-opacity' : '' ?>">
                            <span class="todo-name"><?= $t['name'] ?></span>
                            <form action="modify-todo.php" method="POST">
                                <input type="hidden" value="edit" name="action">
                                <input type="hidden" value="<?= $t['id'] ?>" name="id">
                                <button class="btn btn-primary btn-small"><?= $t['done'] ? 'Annuler' : 'Valider' ?> </button>
                            </form>
                            <form action="modify-todo.php" method="POST">
                                <input type="hidden" value="delete" name="action">
                                <input type="hidden" value="<?= $t['id'] ?>" name="id">
                                <button class="btn btn-danger btn-small">Supprimer</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>
</html>