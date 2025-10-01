<?php
require_once 'simple_gnews.php';

class MultipleHealthArticleFetcher {
    private $fetcher;
    private $healthTerms = [
        'medical research', 'nutrition science', 'fitness training', 'mental wellness',
        'cardiovascular health', 'diabetes care', 'cancer research', 'immunology',
        'neurology', 'pediatric health', 'geriatric care', 'women health',
        'men health', 'sports medicine', 'physical therapy', 'public health',
        'epidemiology', 'pharmacology', 'surgery', 'radiology', 'pathology'
    ];
    
    public function __construct($apiKey) {
        $this->fetcher = new SimpleHealthArticleFetcher($apiKey);
    }
    
    public function fetchMultipleHealthArticles($totalArticles = 200) {
        $allArticles = [];
        $articlesPerTerm = 10; // API limit
        $termsNeeded = ceil($totalArticles / $articlesPerTerm);
        
        for ($i = 0; $i < $termsNeeded && $i < count($this->healthTerms); $i++) {
            try {
                $articles = $this->fetcher->fetchHealthArticles($this->healthTerms[$i], $articlesPerTerm);
                $allArticles = array_merge($allArticles, $articles);
                
                if (count($allArticles) >= $totalArticles) {
                    break;
                }
                
                // Small delay to avoid rate limiting
                usleep(100000); // 0.1 second
                
            } catch (Exception $e) {
                error_log("Error fetching articles for term: " . $this->healthTerms[$i]);
                continue;
            }
        }
        
        // Remove duplicates based on URL
        $uniqueArticles = [];
        $seenUrls = [];
        
        foreach ($allArticles as $article) {
            if (!in_array($article['url'], $seenUrls)) {
                $uniqueArticles[] = $article;
                $seenUrls[] = $article['url'];
            }
        }
        
        return array_slice($uniqueArticles, 0, $totalArticles);
    }
}

// API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    try {
        $multiFetcher = new MultipleHealthArticleFetcher('9f7017d1ceb3b6c5bf3e382756bd2426');
        
        switch ($_GET['action']) {
            case 'load_more':
                $count = $_GET['count'] ?? 50;
                $articles = $multiFetcher->fetchMultipleHealthArticles($count);
                break;
                
            default:
                $articles = $multiFetcher->fetchMultipleHealthArticles(50);
        }
        
        echo json_encode(['success' => true, 'articles' => $articles]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
?>