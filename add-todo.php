<?php
/* Vérification requête POST et sanitization */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = filter_input_array(INPUT_POST, [
        "todo" => [
            " filter" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "flags" => FILTER_FLAG_NO_ENCODE_QUOTES | FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_BACKTICK
        ]
    ]);
    $todo = $_POST['todo']  ?? '';

    if (!$todo) {
        $error = ERROR_REQUIRED;
    } else if (mb_strlen($todo) < 5) {
        $error = ERROR_TOO_SHORT;
    } else if (mb_strlen($todo) > 200) {
        $error = ERROR_TOO_LONG;
    } else if (array_search(mb_strtolower($todo), array_map(fn ($el) => mb_strtolower($el['name']), $todos))) {
        $error = ERROR_ALREADY_EXIST;
    }

    if (!$error) {
        $todos = [...$todos, [
            'name' => $todo,
            'done' => false,
            'id' => time()
        ]];
        file_put_contents($filename, json_encode($todos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        header('Location:/todo/index.php');
    }
}
