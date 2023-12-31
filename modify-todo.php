<?php
$filename = __DIR__ . "/data/todos.json";

$_POST = filter_input_array(INPUT_POST, [
    'id' => FILTER_VALIDATE_INT,
    'action'=> FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);
$id = $_POST['id'] ?? '';
$action = $_POST['action'] ?? '';

if ($id && $action) {
    $todos = json_decode(file_get_contents($filename), true) ?? [];
    if (count($todos)) {
        $todoIndex = array_search($id, array_column($todos, 'id'));
        if($action === 'edit') {
            $todos[$todoIndex]['done'] = !$todos[$todoIndex]['done'];
        }elseif($action === 'delete') {
            array_splice($todos, $todoIndex, 1);
        }
       
        file_put_contents($filename, json_encode($todos));
    }
}

header('Location:/todo/index.php');
