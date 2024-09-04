<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);

require_once 'functions.php';
$headerContent = file_get_contents('header.php');
$footerContent = file_get_contents('footer.php');
$seo = include 'seo.php';

try {
    $request = $_SERVER;
    $uri = $request['REQUEST_URI'];
    $contentPath = getFilePathFromUri($uri, 'pages/home.php', '.php');

    if (file_exists($contentPath)) {
        $seoPath = getFilePathFromUri($uri, 'seo.php', '-seo.php');
        if (file_exists($seoPath)) {
            $seo = include $seoPath;
        }

        $headerContent = assignSeo($headerContent, $seo);
        $content = file_get_contents($contentPath);

        http_response_code(200);
        echo $headerContent . $content . $footerContent;
    } else {
        returnErrorResponse(404, $headerContent, $footerContent, $seo);
    }
} catch (Throwable) {
    returnErrorResponse(500, $headerContent, $footerContent, $seo);
}
