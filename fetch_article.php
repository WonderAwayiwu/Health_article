<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Only POST method allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$url = $input['url'] ?? '';

if (empty($url)) {
    echo json_encode(['success' => false, 'error' => 'URL is required']);
    exit;
}

try {
    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200 || !$html) {
        throw new Exception('Failed to fetch article');
    }
    
    // Parse HTML and extract article content
    $content = extractArticleContent($html);
    
    echo json_encode(['success' => true, 'content' => $content]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

function extractArticleContent($html) {
    // Create DOMDocument
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    libxml_clear_errors();
    
    // Common article selectors (in order of preference)
    $selectors = [
        'article',
        '[role="main"]',
        '.article-content',
        '.post-content',
        '.entry-content',
        '.content',
        'main',
        '.article-body',
        '.story-body',
        '.post-body'
    ];
    
    $xpath = new DOMXPath($dom);
    $content = '';
    
    // Try each selector
    foreach ($selectors as $selector) {
        $cssSelector = convertCssToXpath($selector);
        $nodes = $xpath->query($cssSelector);
        
        if ($nodes->length > 0) {
            $node = $nodes->item(0);
            $content = cleanContent($dom->saveHTML($node));
            if (strlen(strip_tags($content)) > 200) { // Ensure we have substantial content
                break;
            }
        }
    }
    
    // Fallback: extract from body if no article content found
    if (strlen(strip_tags($content)) < 200) {
        $bodyNodes = $xpath->query('//body');
        if ($bodyNodes->length > 0) {
            $bodyContent = $dom->saveHTML($bodyNodes->item(0));
            $content = extractMainContent($bodyContent);
        }
    }
    
    return $content ?: '<p>Unable to extract article content. Please visit the original source.</p>';
}

function convertCssToXpath($css) {
    // Simple CSS to XPath conversion
    $css = trim($css);
    
    if (strpos($css, '.') === 0) {
        // Class selector
        $class = substr($css, 1);
        return "//*[contains(@class, '$class')]";
    } elseif (strpos($css, '[') !== false) {
        // Attribute selector
        if (preg_match('/\[([^=]+)="([^"]+)"\]/', $css, $matches)) {
            return "//*[@{$matches[1]}='{$matches[2]}']";
        }
    } else {
        // Element selector
        return "//$css";
    }
    
    return "//$css";
}

function cleanContent($html) {
    // Remove unwanted elements
    $unwantedTags = ['script', 'style', 'nav', 'header', 'footer', 'aside', 'form', 'iframe', 'object', 'embed'];
    
    foreach ($unwantedTags as $tag) {
        $html = preg_replace('/<' . $tag . '.*?<\/' . $tag . '>/is', '', $html);
    }
    
    // Remove comments
    $html = preg_replace('/<!--.*?-->/s', '', $html);
    
    // Clean up whitespace
    $html = preg_replace('/\s+/', ' ', $html);
    
    // Remove empty paragraphs
    $html = preg_replace('/<p[^>]*>\s*<\/p>/', '', $html);
    
    return trim($html);
}

function extractMainContent($html) {
    // Remove navigation, ads, and other non-content elements
    $patterns = [
        '/<nav.*?<\/nav>/is',
        '/<header.*?<\/header>/is',
        '/<footer.*?<\/footer>/is',
        '/<aside.*?<\/aside>/is',
        '/<div[^>]*class="[^"]*ad[^"]*".*?<\/div>/is',
        '/<div[^>]*class="[^"]*menu[^"]*".*?<\/div>/is',
        '/<div[^>]*class="[^"]*sidebar[^"]*".*?<\/div>/is',
        '/<script.*?<\/script>/is',
        '/<style.*?<\/style>/is'
    ];
    
    foreach ($patterns as $pattern) {
        $html = preg_replace($pattern, '', $html);
    }
    
    // Extract paragraphs and headings
    preg_match_all('/<(h[1-6]|p|div)[^>]*>(.*?)<\/\1>/is', $html, $matches);
    
    $content = '';
    foreach ($matches[0] as $match) {
        $text = strip_tags($match, '<strong><em><b><i><a><br>');
        if (strlen(trim($text)) > 20) { // Only include substantial content
            $content .= $match . "\n";
        }
    }
    
    return $content;
}
?>