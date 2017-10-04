<?php

global $backend_password;

$password_file_path = realpath(dirname(__FILE__)) . '/pico_edit_password.secret';
$password_file_contents = file_get_contents($password_file_path);

if ($password_file_contents === FALSE) {
    // Log something
    error_log('Could not find the pico_edit_password.secret file.');
    $password_file_contents = '';
}

/*
 * This should be a sha1 hash of your password.
 * Use a tool like http://www.sha1-online.com to generate.
 */
$backend_password = trim($password_file_contents);

?>
