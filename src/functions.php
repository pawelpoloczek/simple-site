<?php

function getFilePathFromUri(
    string $uri,
    string $defaultPath,
    string $postfix
): string {
    $articlesPath = 'articles/';
    $pagesPath = 'pages/';
    $contentPath = $pagesPath;

    if (false === empty($uri) && '/' !== $uri) {
        $uri = ltrim($uri, '/');
        $elements = explode('/', $uri);
        if (count($elements) > 1) {
            $contentPath = $articlesPath;
        }

        $defaultPath = $contentPath . $uri . $postfix;
    }

    return $defaultPath;
}

function assignSeo(
    string $content,
    array $seo
): string {
    return str_replace(
        ['{{title}}', '{{description}}', '{{keywords}}', '{{siteName}}'],
        [$seo['title'], $seo['description'], $seo['keywords'], $seo['siteName']],
        $content
    );
}

function returnErrorResponse(
    int $errorCode,
    string $headerContent,
    string $footerContent,
    array $seo
): void {
    $headerContent = assignSeo($headerContent, $seo);
    $content = file_get_contents($errorCode . '.php');

    http_response_code($errorCode);
    echo $headerContent . $content . $footerContent;
}
