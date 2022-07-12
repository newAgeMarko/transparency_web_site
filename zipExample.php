<?php
    $zip = new ZipArchive;
    if ($zip->open('test_new.zip', ZipArchive::CREATE) === TRUE)
    {
        // Add a file new.txt file to zip using the text specified
        $zip->addFromString('new.txt', 'text to be added to the new.txt file');
    
        // All files are added, so close the zip file.
        $zip->close();
    }
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="test_new.zip"');
   // readfile('test_new.zip'); 

?>