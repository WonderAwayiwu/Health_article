<?php
require_once 'simple_gnews.php';

// Initialize the article fetcher
try {
    $fetcher = new SimpleHealthArticleFetcher('0258543b51c4976984312a681e770c9f');
    $featuredArticles = $fetcher->fetchTopHealthHeadlines(30);
    $latestArticles = $fetcher->fetchHealthArticles('health wellness', 10);
} catch (Exception $e) {
    $featuredArticles = [];
    $latestArticles = [];
    error_log("Error loading articles: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthHub - Your Wellness Journey</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #fafbfc;
            color: #1a1a1a;
            line-height: 1.6;
        }

        /* Header */
        .header {
            background: white;
            border-bottom: 1px solid #e1e8ed;
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 16px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #1d4ed8;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .nav-link {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: #1d4ed8;
        }

        .search-container {
            position: relative;
            width: 320px;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 1px solid #e1e8ed;
            border-radius: 24px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .search-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(29, 78, 216, 0.95), rgba(59, 130, 246, 0.95)), url('hero.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .hero-title {
            font-size: 56px;
            font-weight: 800;
            margin-bottom: 24px;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 20px;
            opacity: 0.9;
            margin-bottom: 40px;
            font-weight: 400;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: white;
            color: #1d4ed8;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .hero-cta:hover {
            transform: translateY(-2px);
        }

        /* Stats */
        .stats {
            background: white;
            padding: 60px 0;
            border-bottom: 1px solid #e1e8ed;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            padding: 0 24px;
            text-align: center;
        }

        .stat-item {
            padding: 20px;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 800;
            color: #1d4ed8;
            display: block;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #64748b;
            font-weight: 500;
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 24px;
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 60px;
        }

        /* Featured Article */
        .featured-section {
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 32px;
            color: #1a1a1a;
        }

        .featured-article {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s;
            cursor: pointer;
        }

        .featured-article:hover {
            transform: translateY(-4px);
        }

        .featured-image {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            position: relative;
            overflow: hidden;
            background-size: cover;
            background-position: center;
        }

        .featured-image::before {
            content: '🏥';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 64px;
            opacity: 0.3;
        }

        .featured-content {
            padding: 32px;
        }

        .featured-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .featured-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.3;
        }

        .featured-excerpt {
            color: #64748b;
            margin-bottom: 24px;
            font-size: 16px;
        }

        .featured-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .author-details {
            font-size: 14px;
        }

        .author-name {
            font-weight: 600;
            color: #1a1a1a;
        }

        .article-date {
            color: #64748b;
        }

        .read-time {
            background: #f1f5f9;
            color: #64748b;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        /* Categories */
        .categories {
            margin-bottom: 60px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
        }

        .category-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e1e8ed;
            transition: all 0.2s;
            cursor: pointer;
        }

        .category-card:hover {
            border-color: #1d4ed8;
            transform: translateY(-2px);
        }

        .category-icon {
            font-size: 32px;
            margin-bottom: 12px;
            display: block;
        }

        .category-name {
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .category-count {
            color: #64748b;
            font-size: 12px;
        }

        /* Articles Grid */
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        .article-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e1e8ed;
            transition: all 0.2s;
            cursor: pointer;
        }

        .article-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        .article-image {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .article-image::before {
            content: '🏥';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            opacity: 0.3;
        }

        .article-content {
            padding: 20px;
        }

        .article-category {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .article-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .article-excerpt {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
        }

        .article-author {
            color: #64748b;
        }

        .article-stats {
            display: flex;
            gap: 12px;
            color: #64748b;
        }

        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .sidebar-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e1e8ed;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .trending-item {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            cursor: pointer;
        }

        .trending-item:last-child {
            margin-bottom: 0;
        }

        .trending-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            flex-shrink: 0;
        }

        .trending-content h4 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .trending-meta {
            font-size: 12px;
            color: #64748b;
        }

        /* Newsletter */
        .newsletter {
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            color: white;
            padding: 24px;
            border-radius: 12px;
            text-align: center;
        }

        .newsletter h3 {
            margin-bottom: 8px;
        }

        .newsletter p {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 16px;
        }

        .newsletter-input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            margin-bottom: 12px;
            outline: none;
        }

        .newsletter-btn {
            width: 100%;
            background: white;
            color: #1d4ed8;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        /* Loading */
        .loading {
            text-align: center;
            padding: 40px;
            color: #64748b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .hero-title {
                font-size: 36px;
            }

            .nav-links {
                display: none;
            }

            .search-container {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                🏥 HealthHub
            </div>
            <nav class="nav-links">
                <a href="#" class="nav-link">Articles</a>
                <a href="#" class="nav-link">Categories</a>
                <a href="#" class="nav-link">Experts</a>
                <a href="#" class="nav-link">About</a>
            </nav>
            <div class="search-container">
                <span class="search-icon">🔍</span>
                <input type="text" class="search-input" placeholder="Search health articles..." id="searchInput">
            </div>
            <div class="user-section">
                <div class="user-avatar">JD</div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Your Health, Our Priority</h1>
            <p class="hero-subtitle">Discover evidence-based health articles, tips, and insights from medical experts worldwide</p>
            <a href="#articles" class="hero-cta">
                Explore Articles
                <span>→</span>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <div class="stat-item">
                <span class="stat-number">10K+</span>
                <span class="stat-label">Health Articles</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">500+</span>
                <span class="stat-label">Medical Experts</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">1M+</span>
                <span class="stat-label">Monthly Readers</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">50+</span>
                <span class="stat-label">Health Topics</span>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <main>
            <!-- Featured Article -->
            <section class="featured-section">
                <h2 class="section-title">Featured Article</h2>
                <div id="featuredArticle">
                    <?php if (!empty($featuredArticles)): ?>
                        <?php $featured = $featuredArticles[0]; ?>
                        <article class="featured-article" onclick="openArticle('<?php echo htmlspecialchars($featured['url']); ?>')">
                            <div class="featured-image" style="background-image: url('<?php echo $featured['image'] ?: 'health_image_fallback.jpg'; ?>')"></div>
                            <div class="featured-content">
                                <span class="featured-badge">Health News</span>
                                <h3 class="featured-title"><?php echo htmlspecialchars($featured['title']); ?></h3>
                                <p class="featured-excerpt"><?php echo htmlspecialchars(substr($featured['description'] ?: '', 0, 200)) . '...'; ?></p>
                                <div class="featured-meta">
                                    <div class="author-info">
                                        <div class="author-avatar"><?php echo strtoupper(substr($featured['source'] ?: 'N', 0, 2)); ?></div>
                                        <div class="author-details">
                                            <div class="author-name"><?php echo htmlspecialchars($featured['source'] ?: 'Unknown Source'); ?></div>
                                            <div class="article-date"><?php echo $featured['timeAgo']; ?></div>
                                        </div>
                                    </div>
                                    <span class="read-time">5 min read</span>
                                </div>
                            </div>
                        </article>
                    <?php else: ?>
                        <div class="loading">Loading featured article...</div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Categories -->
            <section class="categories">
                <h2 class="section-title">Browse by Category</h2>
                <div class="category-grid">
                    <div class="category-card" data-category="heart">
                        <span class="category-icon">❤️</span>
                        <div class="category-name">Heart Health</div>
                        <div class="category-count">Latest articles</div>
                    </div>
                    <div class="category-card" data-category="nutrition">
                        <span class="category-icon">🥗</span>
                        <div class="category-name">Nutrition</div>
                        <div class="category-count">Latest articles</div>
                    </div>
                    <div class="category-card" data-category="fitness">
                        <span class="category-icon">🏃</span>
                        <div class="category-name">Fitness</div>
                        <div class="category-count">Latest articles</div>
                    </div>
                    <div class="category-card" data-category="mental">
                        <span class="category-icon">🧠</span>
                        <div class="category-name">Mental Health</div>
                        <div class="category-count">Latest articles</div>
                    </div>
                    <div class="category-card" data-category="medicine">
                        <span class="category-icon">💊</span>
                        <div class="category-name">Medicine</div>
                        <div class="category-count">Latest articles</div>
                    </div>
                    <div class="category-card" data-category="prevention">
                        <span class="category-icon">🛡️</span>
                        <div class="category-name">Prevention</div>
                        <div class="category-count">Latest articles</div>
                    </div>
                </div>
            </section>

            <!-- Latest Articles -->
            <section id="articles">
                <h2 class="section-title">Latest Health Articles</h2>
                <div class="articles-grid" id="articlesGrid">
                    <?php if (!empty($latestArticles)): ?>
                        <?php foreach ($latestArticles as $article): ?>
                            <article class="article-card" onclick="openArticle('<?php echo htmlspecialchars($article['url']); ?>')">
                                <div class="article-image" style="background-image: url('<?php echo $article['image'] ?: 'health_image_fallback.jpg'; ?>')"></div>
                                <div class="article-content">
                                    <span class="article-category">Health</span>
                                    <h3 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h3>
                                    <p class="article-excerpt"><?php echo htmlspecialchars(substr($article['description'] ?: '', 0, 100)) . '...'; ?></p>
                                    <div class="article-meta">
                                        <span class="article-author"><?php echo htmlspecialchars($article['source'] ?: 'Unknown'); ?></span>
                                        <div class="article-stats">
                                            <span><?php echo $article['timeAgo']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="loading">Loading articles...</div>
                    <?php endif; ?>
                </div>
                <div style="text-align: center; margin: 40px 0;">
                    <button id="loadMoreBtn" class="hero-cta" style="background: #1d4ed8; color: white; border: none; cursor: pointer;">Load More Articles</button>
                </div>
            </section>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Trending This Week</h3>
                <div id="trendingArticles">
                    <div class="loading">Loading trending articles...</div>
                </div>
            </div>

            <div class="newsletter">
                <h3>Stay Updated</h3>
                <p>Get the latest health insights delivered to your inbox</p>
                <input type="email" class="newsletter-input" placeholder="Enter your email">
                <button class="newsletter-btn">Subscribe</button>
            </div>
        </aside>
    </div>

    <script>
        // Open article in new tab
        function openArticle(url) {
            if (url) {
                window.open(url, '_blank');
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    searchArticles(query);
                }
            }
        });

        // Search articles
        function searchArticles(query) {
            const articlesGrid = document.getElementById('articlesGrid');
            articlesGrid.innerHTML = '<div class="loading">Searching articles...</div>';

            fetch(`simple_gnews.php?action=search&q=${encodeURIComponent(query)}&max=6`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.articles.length > 0) {
                        displayArticles(data.articles);
                    } else {
                        articlesGrid.innerHTML = '<div class="loading">No articles found for your search.</div>';
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    articlesGrid.innerHTML = '<div class="loading">Error searching articles.</div>';
                });
        }

        // Category click functionality
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const category = this.dataset.category;
                loadCategoryArticles(category);
            });
        });

        // Load category articles
        function loadCategoryArticles(category) {
            const articlesGrid = document.getElementById('articlesGrid');
            articlesGrid.innerHTML = '<div class="loading">Loading articles...</div>';

            fetch(`simple_gnews.php?action=category&category=${category}&max=200`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.articles.length > 0) {
                        displayArticles(data.articles);
                        document.querySelector('.section-title').textContent = `${category.charAt(0).toUpperCase() + category.slice(1)} Articles`;
                    } else {
                        articlesGrid.innerHTML = '<div class="loading">No articles found for this category.</div>';
                    }
                })
                .catch(error => {
                    console.error('Category load error:', error);
                    articlesGrid.innerHTML = '<div class="loading">Error loading articles.</div>';
                });
        }

        // Display articles
        function displayArticles(articles) {
            const articlesGrid = document.getElementById('articlesGrid');
            articlesGrid.innerHTML = articles.map(article => `
                <article class="article-card" onclick="openArticle('${article.url}')">
                    <div class="article-image" style="background-image: url('${article.image || './health_image_fallback.jpg'}'); background-size: cover; background-position: center;"></div>
                    <div class="article-content">
                        <span class="article-category">Health</span>
                        <h3 class="article-title">${article.title}</h3>
                        <p class="article-excerpt">${(article.description || '').substring(0, 100)}...</p>
                        <div class="article-meta">
                            <span class="article-author">${article.source || 'Unknown'}</span>
                            <div class="article-stats">
                                <span>${article.timeAgo}</span>
                            </div>
                        </div>
                    </div>
                </article>
            `).join('');
        }

        // Load trending articles for sidebar
        function loadTrendingArticles() {
            const trendingQueries = ['medical breakthrough', 'wellness tips', 'health research'];
            const promises = trendingQueries.map(query => 
                fetch(`simple_gnews.php?action=search&q=${encodeURIComponent(query)}&max=1`)
                    .then(response => response.json())
            );
            
            Promise.all(promises)
                .then(results => {
                    const trendingArticles = [];
                    results.forEach(data => {
                        if (data.success && data.articles.length > 0) {
                            trendingArticles.push(data.articles[0]);
                        }
                    });
                    
                    if (trendingArticles.length > 0) {
                        const trendingContainer = document.getElementById('trendingArticles');
                        trendingContainer.innerHTML = trendingArticles.map(article => `
                            <div class="trending-item" onclick="openArticle('${article.url}')">
                                <div class="trending-image" style="background-image: url('${article.image || './health_image_fallback.jpg'}'); background-size: cover; background-position: center;"></div>
                                <div class="trending-content">
                                    <h4>${article.title.substring(0, 60)}...</h4>
                                    <div class="trending-meta">${article.timeAgo}</div>
                                </div>
                            </div>
                        `).join('');
                    }
                })
                .catch(error => console.error('Trending articles error:', error));
        }

        // Smooth scroll for hero CTA
        document.querySelector('.hero-cta').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#articles').scrollIntoView({
                behavior: 'smooth'
            });
        });

        // Load more articles functionality
        document.getElementById('loadMoreBtn').addEventListener('click', function() {
            this.textContent = 'Loading...';
            this.disabled = true;
            
            fetch('load_more_articles.php?action=load_more&count=50')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.articles.length > 0) {
                        const currentArticles = document.querySelectorAll('.article-card').length;

                        
                        // Filter out existing articles
                        const existingUrls = Array.from(document.querySelectorAll('.article-card')).map(card => 
                            card.getAttribute('onclick').match(/'([^']+)'/)[1]
                        );
                        
                        const newArticles = data.articles.filter(article => !existingUrls.includes(article.url));
                        
                        if (newArticles.length > 0) {
                            const newArticlesHtml = newArticles.map(article => `
                                <article class="article-card" onclick="openArticle('${article.url}')">
                                    <div class="article-image" style="background-image: url('${article.image || './health_image_fallback.jpg'}'); background-size: cover; background-position: center;"></div>
                                    <div class="article-content">
                                        <span class="article-category">Health</span>
                                        <h3 class="article-title">${article.title}</h3>
                                        <p class="article-excerpt">${(article.description || '').substring(0, 100)}...</p>
                                        <div class="article-meta">
                                            <span class="article-author">${article.source || 'Unknown'}</span>
                                            <div class="article-stats">
                                                <span>${article.timeAgo}</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            `).join('');
                            
                            document.getElementById('articlesGrid').innerHTML += newArticlesHtml;
                            const totalArticles = document.querySelectorAll('.article-card').length;
                            this.textContent = `Load More Articles (${totalArticles} total)`;
                        } else {
                            this.textContent = 'No new articles found';
                        }
                        this.disabled = false;
                    } else {
                        this.textContent = 'No more articles';
                    }
                })
                .catch(error => {
                    console.error('Load more error:', error);
                    this.textContent = 'Error loading articles';
                    this.disabled = false;
                });
        });

        // Load trending articles on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTrendingArticles();
        });
    </script>
</body>
</html>