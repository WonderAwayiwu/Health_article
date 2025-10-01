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
            background: url('article_view_background.jpg') center/cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .article-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            /* background: linear-gradient(135deg, rgba(22, 163, 74, 0.8), rgba(16, 185, 129, 0.1)); */
        }
        
        .article-card {
            position: relative;
            z-index: 2;
            max-width: 700px;
            max-height: 80vh;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }
        
        .article-title {
            font-size: 32px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 20px;
            line-height: 1.3;
        }
        
        .article-content {
            font-size: 16px;
            line-height: 1.6;
            color: #4b5563;
            margin-bottom: 20px;
            text-align: left;
        }
        
        .article-summary {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .article-full-content {
            display: none;
            text-align: left;
            margin-top: 20px;
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
            width: 420px;
            background: white;
            border-left: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            height: 100vh;
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
        
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }
            
            .article-section {
                height: 60vh;
            }
            
            .comments-section {
                width: 100%;
                height: 40vh;
            }
            
            .article-card {
                padding: 30px 20px;
                margin: 20px;
            }
            
            .article-title {
                font-size: 24px;
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
                </div>
                
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner"></div>
                    <p style="margin-top: 10px;">Loading article...</p>
                </div>
                
                <div class="article-full-content" id="articleFullContent">
                    <button class="back-to-summary" onclick="showSummary()">← Back to Summary</button>
                    <div id="fullArticleText"></div>
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
            
            <div class="comment-input-section">
                <div class="user-info-form" id="userInfoForm">
                    <div class="form-row">
                        <input type="text" id="userName" placeholder="Your name" required>
                        <input type="email" id="userEmail" placeholder="Your email" required>
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
        let userName = localStorage.getItem('healthhub_username') || '';
        let userEmail = localStorage.getItem('healthhub_email') || '';

        // Initialize user info
        if (userName && userEmail) {
            document.getElementById('userAvatar').textContent = userName.charAt(0).toUpperCase();
            document.getElementById('userName').value = userName;
            document.getElementById('userEmail').value = userEmail;
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
                <p><strong>Source:</strong> <button class="read-full-btn" onclick="loadFullArticle()">Read full article</button></p>
                <p>This article is fetched from an external source. Click the button above to read the complete article here.</p>
            `;
            loadComments();
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
            if (!userName || !userEmail) {
                document.getElementById('userInfoForm').style.display = 'block';
                document.getElementById('userName').focus();
            }
        }

        // Save user info
        function saveUserInfo() {
            const nameInput = document.getElementById('userName');
            const emailInput = document.getElementById('userEmail');
            
            if (nameInput.value.trim() && emailInput.value.trim()) {
                userName = nameInput.value.trim();
                userEmail = emailInput.value.trim();
                
                // Save to localStorage
                localStorage.setItem('healthhub_username', userName);
                localStorage.setItem('healthhub_email', userEmail);
                
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
            
            if (!userName || !userEmail) {
                showUserForm();
                return;
            }

            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('article_url', currentArticleUrl);
            formData.append('article_title', currentArticleTitle);
            formData.append('user_name', userName);
            formData.append('user_email', userEmail);
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
                    loadComments();
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
            
            // Create a proxy to fetch the article content
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
                    document.getElementById('fullArticleText').innerHTML = data.content;
                    document.getElementById('articleFullContent').style.display = 'block';
                } else {
                    // Fallback: open in new tab if fetching fails
                    window.open(currentArticleUrl, '_blank');
                    document.getElementById('articleSummary').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error loading article:', error);
                document.getElementById('loadingSpinner').style.display = 'none';
                document.getElementById('articleSummary').style.display = 'block';
                // Fallback: open in new tab
                window.open(currentArticleUrl, '_blank');
            });
        }
        
        // Show summary view
        function showSummary() {
            document.getElementById('articleFullContent').style.display = 'none';
            document.getElementById('articleSummary').style.display = 'block';
        }

        // Load comments
        function loadComments() {
            fetch(`comments.php?action=get&article_url=${encodeURIComponent(currentArticleUrl)}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('commentsContainer');
                    const countElement = document.getElementById('commentsCount');
                    
                    if (data.success && data.comments.length > 0) {
                        countElement.textContent = `${data.comments.length} comment${data.comments.length > 1 ? 's' : ''}`;
                        
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
                    } else {
                        countElement.textContent = '0 comments';
                        container.innerHTML = '<div class="no-comments">No comments yet. Be the first to share your thoughts!</div>';
                    }
                })
                .catch(error => {
                    console.error('Error loading comments:', error);
                });
        }
    </script>
</body>
</html>