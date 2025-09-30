<?php
require_once 'simple_gnews.php';

echo "<h1>Testing GNews API Integration</h1>";

try {
    $fetcher = new SimpleHealthArticleFetcher('0258543b51c4976984312a681e770c9f');
    
    echo "<h2>Testing Top Health Headlines:</h2>";
    $headlines = $fetcher->fetchTopHealthHeadlines(3);
    
    if (!empty($headlines)) {
        foreach ($headlines as $article) {
            echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
            echo "<h3>" . htmlspecialchars($article['title']) . "</h3>";
            echo "<p><strong>Source:</strong> " . htmlspecialchars($article['source']) . "</p>";
            echo "<p><strong>Published:</strong> " . $article['timeAgo'] . "</p>";
            echo "<p>" . htmlspecialchars(substr($article['description'], 0, 200)) . "...</p>";
            if ($article['image']) {
                echo "<img src='" . htmlspecialchars($article['image']) . "' style='max-width: 200px; height: auto;' />";
            }
            echo "<p><a href='" . htmlspecialchars($article['url']) . "' target='_blank'>Read Full Article</a></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No headlines found.</p>";
    }
    
    echo "<h2>Testing Health Search:</h2>";
    $searchResults = $fetcher->fetchHealthArticles('nutrition', 3);
    
    if (!empty($searchResults)) {
        foreach ($searchResults as $article) {
            echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
            echo "<h3>" . htmlspecialchars($article['title']) . "</h3>";
            echo "<p><strong>Source:</strong> " . htmlspecialchars($article['source']) . "</p>";
            echo "<p><strong>Published:</strong> " . $article['timeAgo'] . "</p>";
            echo "<p>" . htmlspecialchars(substr($article['description'], 0, 200)) . "...</p>";
            if ($article['image']) {
                echo "<img src='" . htmlspecialchars($article['image']) . "' style='max-width: 200px; height: auto;' />";
            }
            echo "<p><a href='" . htmlspecialchars($article['url']) . "' target='_blank'>Read Full Article</a></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No search results found.</p>";
    }
    
    echo "<h2>Testing Category Search (Heart Health):</h2>";
    $categoryResults = $fetcher->fetchByCategory('heart', 2);
    
    if (!empty($categoryResults)) {
        foreach ($categoryResults as $article) {
            echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
            echo "<h3>" . htmlspecialchars($article['title']) . "</h3>";
            echo "<p><strong>Source:</strong> " . htmlspecialchars($article['source']) . "</p>";
            echo "<p><strong>Published:</strong> " . $article['timeAgo'] . "</p>";
            echo "<p>" . htmlspecialchars(substr($article['description'], 0, 200)) . "...</p>";
            if ($article['image']) {
                echo "<img src='" . htmlspecialchars($article['image']) . "' style='max-width: 200px; height: auto;' />";
            }
            echo "<p><a href='" . htmlspecialchars($article['url']) . "' target='_blank'>Read Full Article</a></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No category results found.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>Go to Main Site</a></p>";
?>