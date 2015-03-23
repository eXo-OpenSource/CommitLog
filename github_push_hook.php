<?php

    // Read raw input (to be able to parse application/json)
    $input = file_get_contents('php://input');

    // Parse JSON
    $json = json_decode($input);
    if (!$json)
        exit;

    // Iterate through pushed commits
    $result = array();
    foreach ($json->commits as $commit) {

        array_push($result, array(
            'id' => $commit->id,
            'author' => $commit->author->username,
            'message' => $commit->message
        ));

    }

    // Append "minified" JSON string to data file
    file_put_contents('data/.commits.txt', json_encode($result)."\n", FILE_APPEND);

?>
