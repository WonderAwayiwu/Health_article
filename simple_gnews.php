<?php
/**
 * Simple GNews API Client without external dependencies
 */
class SimpleGNews {
    private $apiKey;
    private $baseUrl = 'https://gnews.io/api/v4/';
    
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }
    
    /**
     * Search for articles
     */
    public function search($query, $params = []) {
        $endpoint = 'search';
        $params['q'] = $query;
        return $this->makeRequest($endpoint, $params);
    }
    
    /**
     * Get top headlines
     */
    public function getTopHeadlines($params = []) {
        $endpoint = 'top-headlines';
        return $this->makeRequest($endpoint, $params);
    }
    
    /**
     * Make HTTP request to GNews API
     */
    private function makeRequest($endpoint, $params = []) {
        $params['apikey'] = $this->apiKey;
        
        // Build URL
        $url = $this->baseUrl . $endpoint . '?' . http_build_query($params);
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'HealthHub/1.0');
        
        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        // Handle cURL errors
        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }
        
        // Decode JSON response
        $data = json_decode($response, true);
        
        if ($httpCode !== 200) {
            $errorMsg = 'Unknown API error';
            if (isset($data['errors']) && is_array($data['errors'])) {
                $errorMsg = $data['errors'][0];
            } elseif (isset($data['message'])) {
                $errorMsg = $data['message'];
            } elseif ($response) {
                $errorMsg = $response;
            }
            throw new Exception("API Error ($httpCode): " . $errorMsg);
        }
        
        if (!$data || !isset($data['articles'])) {
            throw new Exception("Invalid API response: " . ($response ?: 'Empty response'));
        }
        
        return $data;
    }
}

/**
 * Simple Article class
 */
class SimpleArticle {
    public $title;
    public $description;
    public $content;
    public $url;
    public $image;
    public $publishedAt;
    public $source;
    
    public function __construct($data) {
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->content = $data['content'] ?? '';
        $this->url = $data['url'] ?? '';
        $this->image = $data['image'] ?? '';
        $this->publishedAt = $data['publishedAt'] ?? '';
        $this->source = $data['source'] ?? [];
    }
    
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getContent() { return $this->content; }
    public function getUrl() { return $this->url; }
    public function getImage() { return $this->image; }
    public function getPublishedAt() { return $this->publishedAt; }
    public function getSource() { return $this->source; }
    public function getSourceName() { return $this->source['name'] ?? ''; }
    public function getSourceUrl() { return $this->source['url'] ?? ''; }
}

/**
 * Health Article Fetcher using Simple GNews
 */
class SimpleHealthArticleFetcher {
    private $gnews;
    
    public function __construct($apiKey) {
        $this->gnews = new SimpleGNews($apiKey);
    }
    
    /**
     * Fetch health articles by search query
     */
    public function fetchHealthArticles($query = 'health', $max = 10) {
        try {
            $response = $this->gnews->search($query, [
                'lang' => 'en',
                'max' => $max,
                'sortby' => 'publishedAt'
            ]);
            
            return $this->formatArticles($response);
        } catch (Exception $e) {
            error_log("Error fetching health articles: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Fetch top health headlines
     */
    public function fetchTopHealthHeadlines($max = 10) {
        try {
            $response = $this->gnews->getTopHeadlines([
                'category' => 'health',
                'lang' => 'en',
                'max' => $max
            ]);
            
            return $this->formatArticles($response);
        } catch (Exception $e) {
            error_log("Error fetching top headlines: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Fetch articles by specific health category
     */
    public function fetchByCategory($category, $max = 6) {
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
    private function formatArticles($response) {
        $formattedArticles = [];
        
        if (isset($response['articles']) && is_array($response['articles'])) {
            foreach ($response['articles'] as $articleData) {
                $article = new SimpleArticle($articleData);
                
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
        $fetcher = new SimpleHealthArticleFetcher('c340b2bd078a952859973d7379bba362');
        
        switch ($_GET['action']) {
            case 'top_headlines':
                $articles = $fetcher->fetchTopHealthHeadlines($_GET['max'] ?? 10);
                break;
                
            case 'search':
                $query = $_GET['q'] ?? 'health';
                $articles = $fetcher->fetchHealthArticles($query, $_GET['max'] ?? 10);
                break;
                
            case 'category':
                $category = $_GET['category'] ?? 'health';
                $articles = $fetcher->fetchByCategory($category, $_GET['max'] ?? 6);
                break;
                
            default:
                $articles = $fetcher->fetchTopHealthHeadlines(10);
        }
        
        echo json_encode(['success' => true, 'articles' => $articles]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
?>