<?php
session_start();
$logged_in_user = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article View - HealthHub</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            height: 100vh;
            overflow: hidden;
        }
        
        .main-container {
            display: flex;
            height: 100vh;
        }
        
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 100;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.9);
            color: #16a34a;
            padding: 10px 16px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .article-section {
            flex: 1;
            background: white;
            position: relative;
            overflow-y: auto;
            padding: 60px 20px 20px 20px;
        }
        
        .article-card {
            max-width: 100%;
            width: 100%;
            background: white;
            padding: 0;
            margin: 0;
        }
        
        .article-content-display {
            width: 100%;
            height: calc(100vh - 120px);
            overflow-y: auto;
            background: white;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        
        .article-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            line-height: 1.3;
            padding: 0 20px;
        }
        
        .article-content {
            font-size: 16px;
            line-height: 1.6;
            color: #4b5563;
            padding: 0 20px;
        }
        
        .article-summary {
            padding: 20px;
            text-align: center;
            background: #f8fafc;
            border-radius: 12px;
            margin: 20px;
        }
        
        .article-full-content {
            display: none;
            width: 100%;
            height: 100%;
        }
        
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #16a34a;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .read-full-btn {
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 12px 24px;
            background: linear-gradient(135deg, #16a34a, #059669);
            border-radius: 25px;
            transition: all 0.3s ease;
            display: inline-block;
            margin-top: 15px;
            border: none;
            cursor: pointer;
        }
        
        .read-full-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);
        }
        
        .back-to-summary {
            background: #6b7280;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .back-to-summary:hover {
            background: #4b5563;
        }
        
        .comments-section {
            width: 380px;
            background: white;
            border-left: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            height: 100vh;
            flex-shrink: 0;
        }
        
        .comments-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        
        .comments-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 5px;
        }
        
        .comments-count {
            font-size: 14px;
            color: #6b7280;
        }
        
        .comments-list {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }
        
        .comment {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s;
        }
        
        .comment:hover {
            background: #f9fafb;
        }
        
        .comment-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        
        .comment-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #16a34a, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .comment-content {
            flex: 1;
        }
        
        .comment-author {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
            margin-bottom: 4px;
        }
        
        .comment-text {
            color: #374151;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 8px;
        }
        
        .comment-meta {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .comment-date {
            font-size: 12px;
            color: #9ca3af;
        }
        
        .comment-action {
            background: none;
            border: none;
            color: #6b7280;
            font-size: 12px;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s;
            font-weight: 500;
        }
        
        .comment-action:hover {
            color: #16a34a;
            background: rgba(22, 163, 74, 0.1);
        }
        
        .comment-input-section {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            background: white;
        }
        
        .user-info-form {
            display: none;
            margin-bottom: 15px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .user-info-form input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        
        .user-info-form input:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
        }
        
        .save-info-btn {
            background: #16a34a;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .comment-input-container {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #16a34a, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
            cursor: pointer;
        }
        
        .input-wrapper {
            flex: 1;
            position: relative;
        }
        
        .comment-input {
            width: 100%;
            background: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 20px;
            padding: 10px 45px 10px 16px;
            font-size: 14px;
            outline: none;
            resize: none;
            min-height: 40px;
            max-height: 120px;
            font-family: inherit;
            transition: all 0.2s;
        }
        
        .comment-input:focus {
            border-color: #16a34a;
            background: white;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
        }
        
        .comment-input::placeholder {
            color: #9ca3af;
        }
        
        .send-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: #16a34a;
            border: none;
            color: white;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .send-btn:hover {
            background: #059669;
            transform: translateY(-50%) scale(1.1);
        }
        
        .send-btn:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            transform: translateY(-50%) scale(1);
        }
        
        .no-comments {
            text-align: center;
            color: #9ca3af;
            padding: 60px 20px;
            font-size: 14px;
        }
        
        .pagination {
            padding: 15px 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9fafb;
        }
        
        .pagination-info {
            font-size: 12px;
            color: #6b7280;
        }
        
        .pagination-controls {
            display: flex;
            gap: 8px;
        }
        
        .pagination-btn {
            background: white;
            border: 1px solid #d1d5db;
            color: #374151;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .pagination-btn:hover:not(:disabled) {
            background: #f3f4f6;
            border-color: #9ca3af;
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .pagination-btn.active {
            background: #16a34a;
            color: white;
            border-color: #16a34a;
        }
        
        @media (max-width: 1024px) {
            .main-container {
                flex-direction: column;
            }
            
            .article-section {
                height: 65vh;
                padding: 50px 10px 10px 10px;
            }
            
            .comments-section {
                width: 100%;
                height: 35vh;
            }
            
            .article-title {
                font-size: 24px;
                padding: 0 10px;
            }
            
            .article-content {
                padding: 0 10px;
            }
            
            .back-btn {
                top: 15px;
                left: 15px;
                padding: 8px 12px;
                font-size: 13px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <a href="index.php" class="back-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Back to Articles
        </a>
        
        <div class="article-section">
            <div class="article-card">
                <div class="article-title" id="articleTitle">Loading...</div>
                
                <div class="article-summary" id="articleSummary">
                    <p>Click on an article from the main page to view it here with comments.</p>
                    <button class="read-full-btn" onclick="loadFullArticle()" style="display: none;">View Full Article</button>
                </div>
                
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner"></div>
                    <p style="margin-top: 10px;">Loading article...</p>
                </div>
                
                <div class="article-full-content" id="articleFullContent">
                    <div class="article-content-display" id="articleContentDisplay"></div>
                </div>
            </div>
        </div>
        
        <div class="comments-section">
            <div class="comments-header">
                <div class="comments-title">💬 Comments</div>
                <div class="comments-count" id="commentsCount">0 comments</div>
            </div>
            
            <div class="comments-list" id="commentsContainer">
                <div class="no-comments">No comments yet. Be the first to share your thoughts!</div>
            </div>
            
            <div class="pagination" id="commentsPagination" style="display: none;">
                <div class="pagination-info" id="paginationInfo"></div>
                <div class="pagination-controls" id="paginationControls"></div>
            </div>
            
            <div class="comment-input-section">
                <div class="user-info-form" id="userInfoForm" style="<?php echo $logged_in_user ? 'display: none;' : ''; ?>">
                    <div class="form-row">
                        <input type="text" id="userName" placeholder="Your name" <?php echo $logged_in_user ? '' : 'required'; ?>>
                        <input type="email" id="userEmail" placeholder="Your email (optional)">
                    </div>
                    <button class="save-info-btn" onclick="saveUserInfo()">Save Info</button>
                </div>
                
                <div class="comment-input-container">
                    <div class="user-avatar" id="userAvatar" onclick="showUserForm()">?</div>
                    <div class="input-wrapper">
                        <textarea class="comment-input" id="commentInput" placeholder="Add a comment..." rows="1"></textarea>
                        <button class="send-btn" id="sendBtn" onclick="submitComment()" disabled>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentArticleUrl = '';
        let currentArticleTitle = '';
        let userName = '<?php echo $logged_in_user; ?>' || localStorage.getItem('healthhub_username') || '';
        let userEmail = localStorage.getItem('healthhub_email') || '';
        let currentPage = 1;
        let totalPages = 1;

        // Initialize user info
        if (userName) {
            document.getElementById('userAvatar').textContent = userName.charAt(0).toUpperCase();
            document.getElementById('userName').value = userName;
            if (userEmail) {
                document.getElementById('userEmail').value = userEmail;
            }
        }

        // Get article data from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const articleUrl = urlParams.get('url');
        const articleTitle = urlParams.get('title');

        if (articleUrl && articleTitle) {
            currentArticleUrl = articleUrl;
            currentArticleTitle = decodeURIComponent(articleTitle);
            document.getElementById('articleTitle').textContent = currentArticleTitle;
            document.getElementById('articleSummary').innerHTML = `
                <p><strong>Source:</strong> ${new URL(articleUrl).hostname}</p>
                <p>Loading the full article content...</p>
            `;
            loadComments();
            // Auto-load the full article
            setTimeout(loadFullArticle, 1000);
        }

        // Auto-resize textarea
        document.getElementById('commentInput').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            
            // Enable/disable send button
            const sendBtn = document.getElementById('sendBtn');
            sendBtn.disabled = !this.value.trim();
        });

        // Show user form
        function showUserForm() {
            // Only show form if no logged-in user
            if (!userName) {
                document.getElementById('userInfoForm').style.display = 'block';
                document.getElementById('userName').focus();
            }
        }

        // Save user info
        function saveUserInfo() {
            const nameInput = document.getElementById('userName');
            const emailInput = document.getElementById('userEmail');
            
            if (nameInput.value.trim()) {
                userName = nameInput.value.trim();
                userEmail = emailInput.value.trim();
                
                // Save to localStorage only if not logged in
                if (!'<?php echo $logged_in_user; ?>') {
                    localStorage.setItem('healthhub_username', userName);
                    localStorage.setItem('healthhub_email', userEmail);
                }
                
                // Update avatar
                document.getElementById('userAvatar').textContent = userName.charAt(0).toUpperCase();
                
                // Hide form
                document.getElementById('userInfoForm').style.display = 'none';
                
                // Focus comment input
                document.getElementById('commentInput').focus();
            }
        }

        // Handle Enter key in user form
        document.getElementById('userEmail').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                saveUserInfo();
            }
        });

        // Handle comment input
        document.getElementById('commentInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                submitComment();
            }
        });

        // Submit comment
        function submitComment() {
            const commentText = document.getElementById('commentInput').value.trim();
            
            if (!commentText) return;
            
            // If no logged-in user and no stored info, show form
            if (!userName) {
                showUserForm();
                return;
            }

            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('article_url', currentArticleUrl);
            formData.append('article_title', currentArticleTitle);
            formData.append('user_name', userName);
            formData.append('user_email', userEmail || 'user@example.com');
            formData.append('comment_text', commentText);
            
            // Disable send button
            const sendBtn = document.getElementById('sendBtn');
            sendBtn.disabled = true;
            
            fetch('comments.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('commentInput').value = '';
                    document.getElementById('commentInput').style.height = 'auto';
                    loadComments(1); // Reset to first page after new comment
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to post comment');
            })
            .finally(() => {
                sendBtn.disabled = false;
            });
        }

        // Load full article content
        function loadFullArticle() {
            document.getElementById('loadingSpinner').style.display = 'block';
            document.getElementById('articleSummary').style.display = 'none';
            
            fetch('fetch_article.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ url: currentArticleUrl })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingSpinner').style.display = 'none';
                
                if (data.success) {
                    document.getElementById('articleContentDisplay').innerHTML = data.content;
                    document.getElementById('articleFullContent').style.display = 'block';
                } else {
                    document.getElementById('articleSummary').innerHTML = `
                        <p><strong>Unable to load article content</strong></p>
                        <p>Click the button below to view the article in a new tab:</p>
                        <button class="read-full-btn" onclick="window.open('${currentArticleUrl}', '_blank')">Open Article</button>
                    `;
                    document.getElementById('articleSummary').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error loading article:', error);
                document.getElementById('loadingSpinner').style.display = 'none';
                document.getElementById('articleSummary').innerHTML = `
                    <p><strong>Unable to load article content</strong></p>
                    <p>Click the button below to view the article in a new tab:</p>
                    <button class="read-full-btn" onclick="window.open('${currentArticleUrl}', '_blank')">Open Article</button>
                `;
                document.getElementById('articleSummary').style.display = 'block';
            });
        }
        
        // Show summary view
        function showSummary() {
            document.getElementById('articleFullContent').style.display = 'none';
            document.getElementById('articleSummary').style.display = 'block';
            document.getElementById('articleContentDisplay').innerHTML = '';
        }

        // Load comments with pagination
        function loadComments(page = 1) {
            currentPage = page;
            fetch(`comments.php?action=get&article_url=${encodeURIComponent(currentArticleUrl)}&page=${page}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('commentsContainer');
                    const countElement = document.getElementById('commentsCount');
                    const paginationElement = document.getElementById('commentsPagination');
                    
                    if (data.success && data.comments.length > 0) {
                        const total = data.pagination.total_comments;
                        countElement.textContent = `${total} comment${total > 1 ? 's' : ''}`;
                        
                        container.innerHTML = data.comments.map(comment => `
                            <div class="comment">
                                <div class="comment-header">
                                    <div class="comment-avatar">${comment.user_name.charAt(0).toUpperCase()}</div>
                                    <div class="comment-content">
                                        <div class="comment-author">${comment.user_name}</div>
                                        <div class="comment-text">${comment.comment_text}</div>
                                        <div class="comment-meta">
                                            <div class="comment-date">${new Date(comment.created_at).toLocaleDateString()}</div>
                                            <button class="comment-action">Reply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                        
                        // Show pagination if more than 10 comments
                        if (data.pagination.total_pages > 1) {
                            totalPages = data.pagination.total_pages;
                            renderPagination(data.pagination);
                            paginationElement.style.display = 'flex';
                        } else {
                            paginationElement.style.display = 'none';
                        }
                    } else {
                        countElement.textContent = '0 comments';
                        container.innerHTML = '<div class="no-comments">No comments yet. Be the first to share your thoughts!</div>';
                        paginationElement.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error loading comments:', error);
                });
        }
        
        // Render pagination controls
        function renderPagination(pagination) {
            const infoElement = document.getElementById('paginationInfo');
            const controlsElement = document.getElementById('paginationControls');
            
            const start = ((pagination.current_page - 1) * pagination.per_page) + 1;
            const end = Math.min(pagination.current_page * pagination.per_page, pagination.total_comments);
            
            infoElement.textContent = `${start}-${end} of ${pagination.total_comments}`;
            
            let controls = '';
            
            // Previous button
            controls += `<button class="pagination-btn" ${pagination.current_page === 1 ? 'disabled' : ''} onclick="loadComments(${pagination.current_page - 1})">‹ Prev</button>`;
            
            // Page numbers
            const startPage = Math.max(1, pagination.current_page - 2);
            const endPage = Math.min(pagination.total_pages, pagination.current_page + 2);
            
            for (let i = startPage; i <= endPage; i++) {
                controls += `<button class="pagination-btn ${i === pagination.current_page ? 'active' : ''}" onclick="loadComments(${i})">${i}</button>`;
            }
            
            // Next button
            controls += `<button class="pagination-btn" ${pagination.current_page === pagination.total_pages ? 'disabled' : ''} onclick="loadComments(${pagination.current_page + 1})">Next ›</button>`;
            
            controlsElement.innerHTML = controls;
        }
    </script>
</body>
</html>