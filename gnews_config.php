<?php
// GNews API Configuration
define('GNEWS_API_KEY', '0258543b51c4976984312a681e770c9f');
define('GNEWS_BASE_URL', 'https://gnews.io/api/v4/');

// Include the GNews library files
require_once __DIR__ . '/gnews-io-php-main/gnews-io-php-main/src/GNewsException.php';
require_once __DIR__ . '/gnews-io-php-main/gnews-io-php-main/src/Article.php';
require_once __DIR__ . '/gnews-io-php-main/gnews-io-php-main/src/ArticleCollection.php';
require_once __DIR__ . '/gnews-io-php-main/gnews-io-php-main/src/GNews.php';

// Health-related search terms
$healthKeywords = [
    'health',
    'medical',
    'wellness',
    'nutrition',
    'fitness',
    'mental health',
    'heart health',
    'diet',
    'exercise',
    'healthcare'
];
?>