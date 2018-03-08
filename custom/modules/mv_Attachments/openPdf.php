<?php

global $sugar_config;
if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {

    require_once 'include/upload_file.php';
    $uploadDir = $sugar_config['upload_dir'];

    $f = new UploadFile();
    $f->temp_file_location = $uploadDir . $_REQUEST['id'];

    $contents = $f->get_file_contents();
    if (strlen($contents) > 0) {
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename=Test.pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length:' . strlen($contents));
        header('Accept-Ranges: bytes');
        echo $contents;
    } else {
        echo 'File not found or corrupted';
    }
}
