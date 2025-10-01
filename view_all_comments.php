<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Fetch all comments
$stmt = $sql->prepare("SELECT * FROM comments ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$comments = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Comments - HealthHub</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: url('view_all_comments_background.jpg') center/cover fixed;
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            /* background: linear-gradient(135deg, rgba(22, 163, 74, 0.9), rgba(16, 185, 129, 0.8)); */
            z-index: -1;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.95);
            padding: 25px 30px;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .title {
            font-size: 32px;
            font-weight: 800;
            color: #1a1a1a;
            background: linear-gradient(135deg, #16a34a, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #16a34a, #059669);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }
        
        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.4);
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: 800;
            background: linear-gradient(135deg, #16a34a, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        
        .stat-label {
            color: #6b7280;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .search-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .search-box {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
            background: white;
        }
        
        .search-box:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
        }
        
        .comments-container {
            display: grid;
            gap: 20px;
        }
        
        .comment {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }
        
        .comment:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .article-link {
            color: #16a34a;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
            padding: 8px 12px;
            background: rgba(22, 163, 74, 0.1);
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .article-link:hover {
            background: rgba(22, 163, 74, 0.2);
            transform: translateX(3px);
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .comment-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #16a34a, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }
        
        .comment-user {
            font-weight: 700;
            color: #1a1a1a;
            font-size: 16px;
            margin-bottom: 4px;
        }
        
        .comment-article {
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
        }
        
        .comment-date {
            font-size: 12px;
            color: #9ca3af;
            background: #f3f4f6;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .comment-text {
            line-height: 1.6;
            color: #374151;
            font-size: 15px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f3f4f6;
        }
        
        .no-comments {
            text-align: center;
            color: white;
            padding: 60px 20px;
            font-size: 18px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(20px);
        }
        
        @media (max-width: 768px) {
            .container { padding: 15px; }
            .header { flex-direction: column; gap: 15px; text-align: center; }
            .title { font-size: 24px; }
            .stats { grid-template-columns: 1fr; }
            .comment-header { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">All Comments</h1>
            <a href="index.php" class="back-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
                Back to Home
            </a>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($comments); ?></div>
                <div class="stat-label">Total Comments</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count(array_unique(array_column($comments, 'article_url'))); ?></div>
                <div class="stat-label">Articles with Comments</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count(array_unique(array_column($comments, 'user_email'))); ?></div>
                <div class="stat-label">Unique Users</div>
            </div>
        </div>
        
        <div class="search-container">
            <input type="text" class="search-box" id="searchBox" placeholder="🔍 Search comments by user name, article title, or comment text...">
        </div>
        
        <div class="comments-container" id="commentsContainer">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment" data-search="<?php echo strtolower($comment['user_name'] . ' ' . $comment['article_title'] . ' ' . $comment['comment_text']); ?>">
                        <div class="comment-header">
                            <div class="comment-user-info">
                                <div class="user-avatar"><?php echo strtoupper(substr($comment['user_name'], 0, 1)); ?></div>
                                <div>
                                    <div class="comment-user"><?php echo htmlspecialchars($comment['user_name']); ?></div>
                                    <div class="comment-article"><?php echo htmlspecialchars($comment['article_title']); ?></div>
                                </div>
                            </div>
                            <div class="comment-date"><?php echo date('M j, Y', strtotime($comment['created_at'])); ?></div>
                        </div>
                        <div class="comment-text"><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></div>
                        <a href="<?php echo htmlspecialchars($comment['article_url']); ?>" class="article-link">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z"/>
                            </svg>
                            View Article
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-comments">No comments found.</div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchBox').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const comments = document.querySelectorAll('.comment');
            
            comments.forEach(comment => {
                const searchData = comment.getAttribute('data-search');
                if (searchData.includes(searchTerm)) {
                    comment.style.display = 'block';
                } else {
                    comment.style.display = 'none';
                }
            });
        });
        
        // Handle comment click to redirect to article
        document.querySelectorAll('.comment').forEach(comment => {
            comment.addEventListener('click', function(e) {
                // Don't redirect if clicking on the article link itself
                if (e.target.closest('.article-link')) {
                    return;
                }
                
                const articleLink = this.querySelector('.article-link');
                if (articleLink) {
                    window.location.href = articleLink.href;
                }
            });
        });
    </script>
</body>
</html>