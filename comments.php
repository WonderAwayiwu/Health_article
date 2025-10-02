<?php
require_once 'config.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch($action) {
    case 'add':
        addComment();
        break;
    case 'get':
        getComments();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function addComment() {
    global $sql;
    
    $article_url = $_POST['article_url'] ?? '';
    $article_title = $_POST['article_title'] ?? '';
    $user_name = $_POST['user_name'] ?? '';
    $user_email = $_POST['user_email'] ?? '';
    $comment_text = $_POST['comment_text'] ?? '';
    
    if (empty($article_url) || empty($user_name) || empty($user_email) || empty($comment_text)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        return;
    }
    
    $stmt = $sql->prepare("INSERT INTO comments (article_url, article_title, user_name, user_email, comment_text) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $article_url, $article_title, $user_name, $user_email, $comment_text);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Comment added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add comment']);
    }
}

function getComments() {
    global $sql;
    
    $article_url = $_GET['article_url'] ?? '';
    $page = max(1, intval($_GET['page'] ?? 1));
    $limit = 10;
    $offset = ($page - 1) * $limit;
    
    if (empty($article_url)) {
        echo json_encode(['success' => false, 'message' => 'Article URL required']);
        return;
    }
    
    // Get total count
    $countStmt = $sql->prepare("SELECT COUNT(*) as total FROM comments WHERE article_url = ?");
    $countStmt->bind_param("s", $article_url);
    $countStmt->execute();
    $totalResult = $countStmt->get_result();
    $total = $totalResult->fetch_assoc()['total'];
    
    // Get paginated comments
    $stmt = $sql->prepare("SELECT user_name, comment_text, created_at FROM comments WHERE article_url = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("sii", $article_url, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    
    $totalPages = ceil($total / $limit);
    
    echo json_encode([
        'success' => true, 
        'comments' => $comments,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_comments' => $total,
            'per_page' => $limit
        ]
    ]);
}
?>