<?php
if (isset($_GET['url'])) {
    $imageUrl = urldecode($_GET['url']);

    $fileId = null;
    if (preg_match('/drive\.google\.com\/file\/d\/(.+?)\/view/', $imageUrl, $match)) {
        $fileId = $match[1];
    } elseif (preg_match('/drive\.google\.com\/uc\?export=view&id=(.+)/', $imageUrl, $match)) {
        $fileId = $match[1];
    } elseif (preg_match('/drive\.google\.com\/open\?id=(.+)/', $imageUrl, $match)) {
        $fileId = $match[1];
    }

    if ($fileId) {
        $directUrl = "https://drive.google.com/uc?export=download&id=" . $fileId;

        $ch = curl_init($directUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $imageContent = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($imageContent !== false && $httpCode == 200) {

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->buffer($imageContent);

            header('Content-Type: ' . $mime_type);
            header('Content-Length: ' . strlen($imageContent));
            echo $imageContent;
            exit;
        }
    }
}

$defaultImagePath = 'kepek/hiba_kep.jpg';
if (file_exists($defaultImagePath)) {
    header('Content-Type: image/jpeg');
    readfile($defaultImagePath);
} else {
    header('HTTP/1.1 404 Not Found');
    exit('Kép nem található');
}
?>