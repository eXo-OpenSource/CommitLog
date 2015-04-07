<?php
    require_once('config.php');

    // Read raw input (to be able to parse application/json)
    $input = file_get_contents('php://input');

    // Get HTTP headers
    $headers = getallheaders();

    // Verify secret key
    if (USE_SECRET_KEY) {
        // Ensure if we got a secret key
        if (!isset($headers['X-Hub-Signature'))
            exit;

        // Check if the signature matches
        if ($headers['X-Hub-Signature'] !== 'sha1='.hash_hmac('sha1', $input, SECRET_KEY))
            exit;
    }

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
            'message' => $commit->message,
            'timestamp' => preg_replace('/(.*)T(.*)\+.*/', '${1} ${2}', $commit->timestamp)
        ));

    }

    // Append "minified" JSON string to data file
    file_put_contents('data/.commits.txt', json_encode($result)."\n", FILE_APPEND);

?>
