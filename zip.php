<?php
function saverZip($password, $zip_filename)
{
    $zip = new ZipArchive();
    $zip->open($zip_filename, ZIPARCHIVE::CREATE);

    $zip -> setPassword($password); 

    for($i = 0; $i < count($_FILES["fileToUpload"]["name"]);$i++)
    {
        $content = file_get_contents($_FILES["fileToUpload"]["tmp_name"][$i] );
        $zip->addFromString($_FILES["fileToUpload"]["name"][$i], $content);
        $zip->setEncryptionName($_FILES["fileToUpload"]["name"][$i], ZipArchive::EM_AES_256);

    }
    $zip->close();
    echo "przesłano plik";

}

function generateDownloadLinks($zip_filename)
{
    $zip = new ZipArchive();
    if ($zip->open($zip_filename) === TRUE) {
        echo "<h2>Zawartość pliku ZIP</h2>";
        echo "<ul>";

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $fileInfo = $zip->statIndex($i);
            $fileName = $fileInfo['name'];
            $fileUrl = 'download.php?file=' . urlencode($zip_filename) . '&name=' . urlencode($fileName);

            $date_added = isset($fileInfo['ctime']) ? date("Y-m-d H:i:s", $fileInfo['ctime']) : 'N/A';
            $date_modified = isset($fileInfo['mtime']) ? date("Y-m-d H:i:s", $fileInfo['mtime']) : 'N/A';


            echo "<li><a href='$fileUrl' download>$fileName</a> - Dodany: $date_added, Zmodyfikowany: $date_modified</li>";
        }

        echo "</ul>";
        $zip->close();
    } 
    else 
        echo "Nie można otworzyć pliku ZIP.<br>";
    
}
function generateDownloadAllLinks($directory)
{
    $files = glob($directory . '*.zip');
    if (count($files) > 0) {
        echo "<h2>Zawartość wszystkich plików ZIP</h2>";
        echo "<ul>";

        foreach ($files as $zip_filename) {
            $zip = new ZipArchive();
            if ($zip->open($zip_filename) === TRUE) {
                echo "<h3>Plik: " . basename($zip_filename) . "</h3>";

                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $fileInfo = $zip->statIndex($i);
                    $fileName = $fileInfo['name'];
                    $fileUrl = 'download.php?file=' . urlencode($zip_filename) . '&name=' . urlencode($fileName);
        
                    $date_added = isset($fileInfo['ctime']) ? date("Y-m-d H:i:s", $fileInfo['ctime']) : 'N/A';
                    $date_modified = isset($fileInfo['mtime']) ? date("Y-m-d H:i:s", $fileInfo['mtime']) : 'N/A';
        
        
                    echo "<li><a href='$fileUrl' download>$fileName</a> - Dodany: $date_added, Zmodyfikowany: $date_modified</li>";
                }

                $zip->close();
            } else {
                echo "<li>Nie można otworzyć pliku ZIP: " . htmlspecialchars($zip_filename) . "</li>";
            }
        }

        echo "</ul>";
    } else {
        echo "Brak plików ZIP do wyświetlenia.";
    }
}
?>