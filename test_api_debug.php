<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'simple_gnews.php';

echo "<h2>API Debug Test</h2>";
echo "<p>API Key: 9f7017d1ceb3b6c5bf3e382756bd2426</p>";

try {
    $fetcher = new SimpleHealthArticleFetcher('9f7017d1ceb3b6c5bf3e382756bd2426');
    
    echo "<h3>Testing Top Headlines:</h3>";
    $headlines = $fetcher->fetchTopHealthHeadlines(5);
    echo "Headlines count: " . count($headlines) . "<br>";
    if (!empty($headlines)) {
        foreach ($headlines as $article) {
            echo "- " . htmlspecialchars($article['title']) . "<br>";
        }
    } else {
        echo "No headlines found<br>";
    }
    
    echo "<h3>Testing Search:</h3>";
    $searchResults = $fetcher->fetchHealthArticles('health', 5);
    echo "Search results count: " . count($searchResults) . "<br>";
    if (!empty($searchResults)) {
        foreach ($searchResults as $article) {
            echo "- " . htmlspecialchars($article['title']) . "<br>";
        }
    } else {
        echo "No search results found<br>";
    }
    
    echo "<h3>Testing Direct API Call:</h3>";
    $url = 'https://gnews.io/api/v4/search?q=health&lang=en&max=3&apikey=9f7017d1ceb3b6c5bf3e382756bd2426';
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    echo "Direct API response: " . (isset($data['articles']) ? count($data['articles']) . " articles" : "Error: " . json_encode($data)) . "<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "Stack trace: " . $e->getTraceAsString();
}

echo "<hr><p><a href='index.php'>Back to Main Site</a></p>";
?>