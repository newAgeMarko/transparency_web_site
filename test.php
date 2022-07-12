<?php
    $file = 'Dear GP.txt';

    # create new zip opbject
    $zip = new ZipArchive();

    # create a temp file & open it
    $tmp_file = tempnam('.','');
    $zip->open($tmp_file, ZipArchive::CREATE);


        #add it to the zip
        $zip->addFromString($file,'adsadasdadsadasdsad');



    # close zip
    $zip->close();

    # send the file to the browser as a download
    header('Content-disposition: attachment; filename=Resumes.zip');
    header('Content-type: application/zip');
    readfile($tmp_file);
 ?>