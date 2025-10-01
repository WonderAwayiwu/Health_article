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
    
    if (empty($article_url)) {
        echo json_encode(['success' => false, 'message' => 'Article URL required']);
        return;
    }
    
    $stmt = $sql->prepare("SELECT user_name, comment_text, created_at FROM comments WHERE article_url = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $article_url);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    
    echo json_encode(['success' => true, 'comments' => $comments]);
}
?>