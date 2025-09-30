<?php
require_once 'gnews_config.php';

use GNews\GNews;
use GNews\GNewsException;

class HealthArticleFetcher {
    private $gnews;
    
    public function __construct() {
        try {
            $this->gnews = new GNews(GNEWS_API_KEY);
        } catch (GNewsException $e) {
            error_log("GNews initialization error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Fetch health articles by search query
     */
    public function fetchHealthArticles($query = 'health', $max = 100) {
        try {
            $articles = $this->gnews->search($query, [
                'lang' => 'en',
                'max' => $max,
                'sortby' => 'publishedAt'
            ]);
            
            return $this->formatArticles($articles);
        } catch (GNewsException $e) {
            error_log("Error fetching health articles: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Fetch top health headlines
     */
    public function fetchTopHealthHeadlines($max = 100) {
        try {
            $articles = $this->gnews->getTopHeadlines([
                'category' => 'health',
                'lang' => 'en',
                'max' => $max
            ]);
            
            return $this->formatArticles($articles);
        } catch (GNewsException $e) {
            error_log("Error fetching top headlines: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Fetch articles by specific health category
     */
    public function fetchByCategory($category, $max = 100) {
        $categoryQueries = [
            'heart' => 'heart health cardiovascular',
            'nutrition' => 'nutrition diet healthy eating',
            'fitness' => 'fitness exercise workout',
            'mental' => 'mental health wellness stress',
            'medicine' => 'medicine medical treatment',
            'prevention' => 'prevention health tips wellness'
        ];
        
        $query = $categoryQueries[$category] ?? $category;
        return $this->fetchHealthArticles($query, $max);
    }
    
    /**
     * Format articles for display
     */
    private function formatArticles($articleCollection) {
        $formattedArticles = [];
        
        foreach ($articleCollection as $article) {
            $formattedArticles[] = [
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
                'content' => $article->getContent(),
                'url' => $article->getUrl(),
                'image' => $article->getImage(),
                'publishedAt' => $article->getPublishedAt(),
                'source' => $article->getSourceName(),
                'sourceUrl' => $article->getSourceUrl(),
                'timeAgo' => $this->timeAgo($article->getPublishedAt())
            ];
        }
        
        return $formattedArticles;
    }
    
    /**
     * Convert timestamp to "time ago" format
     */
    private function timeAgo($datetime) {
        if (!$datetime) return 'Unknown';
        
        $time = time() - strtotime($datetime);
        
        if ($time < 60) return 'just now';
        if ($time < 3600) return floor($time/60) . ' minutes ago';
        if ($time < 86400) return floor($time/3600) . ' hours ago';
        if ($time < 2592000) return floor($time/86400) . ' days ago';
        if ($time < 31536000) return floor($time/2592000) . ' months ago';
        
        return floor($time/31536000) . ' years ago';
    }
}

// API endpoint for AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    try {
        $fetcher = new HealthArticleFetcher();
        
        switch ($_GET['action']) {
            case 'top_headlines':
                $articles = $fetcher->fetchTopHealthHeadlines($_GET['max'] ?? 100);
                break;
                
            case 'search':
                $query = $_GET['q'] ?? 'health';
                $articles = $fetcher->fetchHealthArticles($query, $_GET['max'] ?? 100);
                break;
                
            case 'category':
                $category = $_GET['category'] ?? 'health';
                $articles = $fetcher->fetchByCategory($category, $_GET['max'] ?? 100);
                break;
                
            default:
                $articles = $fetcher->fetchTopHealthHeadlines(100);
        }
        
        echo json_encode(['success' => true, 'articles' => $articles]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
?>