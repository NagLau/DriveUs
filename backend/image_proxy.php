<?php
if (isset($_GET['url'])) {
    $imageUrl = $_GET['url'];

    if (preg_match('/drive\.google\.com\/file\/d\/(.+?)\/view/', $imageUrl, $match)) {
        $fileId = $match[1];
        $directUrl = "https://drive.google.com/uc?export=download&id=" . $fileId;
        
        $imageContent = @file_get_contents($directUrl);
        if ($imageContent === false) {

            header('Content-Type: image/jpeg');
            readfile('kepek/hiba_kep.jpg');
            exit;
        }

        header('Content-Type: image/jpeg');
        header('Content-Length: ' . strlen($imageContent));
        echo $imageContent;
        exit;
    }
}

header('Content-Type: image/jpeg');
readfile('kepek/hiba_kep.jpg');
exit;
?>