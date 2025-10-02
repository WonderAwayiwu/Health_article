<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'simple_gnews.php';

// Initialize the article fetcher
try {
    $fetcher = new SimpleHealthArticleFetcher('0258543b51c4976984312a681e770c9f');
    $featuredArticles = $fetcher->fetchTopHealthHeadlines(30);
    $latestArticles = $fetcher->fetchHealthArticles('health wellness', 50);
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
            background: linear-gradient(135deg, #1e40af, #3b82f6, #06b6d4);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 10px 0;
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
            font-size: 26px;
            font-weight: 800;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            padding: 8px 16px;
            border-radius: 8px;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .search-container {
            position: relative;
            width: 320px;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            backdrop-filter: blur(10px);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-input:focus {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .username-display {
            color: white;
            font-weight: 500;
            font-size: 14px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
            cursor: pointer;
        }

        .user-avatar:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.05);
        }

        /* Hero Section */
        .hero {
            background: url('hero.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            text-align: center;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 2;
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
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 12px;
        }

        .stat-item:hover {
            background: rgba(29, 78, 216, 0.05);
            transform: translateY(-2px);
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

        /* About Section */
        /* .about {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 80px 0;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .about-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .about-title {
            font-size: 48px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .about-subtitle {
            font-size: 20px;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            margin-bottom: 80px;
        }

        .about-text {
            font-size: 16px;
            line-height: 1.8;
            color: #374151;
        }

        .about-text h3 {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .about-text p {
            margin-bottom: 20px;
        }

        .about-image {
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            border-radius: 16px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 64px;
            color: white;
        }

        .mission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .mission-card {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s;
        }

        .mission-card:hover {
            transform: translateY(-4px);
        }

        .mission-icon {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
        }

        .mission-card h4 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
        }

        .mission-card p {
            color: #64748b;
            line-height: 1.6;
        }

        .team-section {
            text-align: center;
        }

        .team-title {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 40px;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .team-member {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s;
        }

        .team-member:hover {
            transform: translateY(-4px);
        }

        .team-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            font-weight: 700;
        }

        .team-name {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .team-role {
            color: #1d4ed8;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .team-bio {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        } */

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
                <img src="images/hewale.jpg" alt="" width="60" style="border-radius: 50%;">
            </div>
            <nav class="nav-links">
                <a href="#articles" class="nav-link">Articles</a>
                <a href="#categories" class="nav-link">Categories</a>
                <a href="#experts" class="nav-link">Experts</a>
                <a href="#about" class="nav-link">About</a>
            </nav>
            <div class="search-container">
                <span class="search-icon">🔍</span>
                <input type="text" class="search-input" placeholder="Search health articles..." id="searchInput">
            </div>
            <div class="user-section">
                <span class="username-display">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['username'], 0, 2)); ?></div>
                <a href="logout.php" class="logout-btn">Logout</a>
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
            <div class="stat-item" onclick="scrollToSection('#articles')">
                <span class="stat-number">10K+</span>
                <span class="stat-label">Health Articles</span>
            </div>
            <div class="stat-item" onclick="loadCategoryArticles('medicine')">
                <span class="stat-number">500+</span>
                <span class="stat-label">Medical Experts</span>
            </div>
            <div class="stat-item" onclick="scrollToSection('#categories')">
                <span class="stat-number">1M+</span>
                <span class="stat-label">Monthly Readers</span>
            </div>
            <div class="stat-item" onclick="scrollToSection('#categories')">
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
            <section class="categories" id="categories">
                <h2 class="section-title">Browse by Category</h2>
                <div class="category-grid">
                    <div class="category-card" data-category="all">
                        <span class="category-icon">🏥</span>
                        <div class="category-name">All Categories</div>
                        <div class="category-count">View all articles</div>
                    </div>
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

    <!-- About Section -->
    <!-- <section class="about" id="about">
        <div class="about-container">
            <div class="about-header">
                <h2 class="about-title">About HealthHub</h2>
                <p class="about-subtitle">Empowering lives through trusted health information and expert medical insights</p>
            </div>

            <div class="about-content">
                <div class="about-text">
                    <h3>Our Mission</h3>
                    <p>At HealthHub, we believe that access to reliable, evidence-based health information is a fundamental right. Our mission is to bridge the gap between complex medical research and everyday health decisions.</p>
                    <p>We curate content from leading medical institutions, certified healthcare professionals, and peer-reviewed research to ensure you receive only the most accurate and up-to-date health information.</p>
                    <p>Whether you're managing a chronic condition, seeking preventive care guidance, or simply wanting to live a healthier lifestyle, HealthHub is your trusted companion on your wellness journey.</p>
                </div>
                <div class="about-image">
                    <img src="health_search.jpg" alt="" height="400" style="border-radius: 16px;">
                </div>
            </div>

            <div class="mission-grid">
                <div class="mission-card">
                    <span class="mission-icon">🎯</span>
                    <h4>Evidence-Based Content</h4>
                    <p>All our articles are sourced from peer-reviewed medical journals and verified by healthcare professionals to ensure accuracy and reliability.</p>
                </div>
                <div class="mission-card">
                    <span class="mission-icon">🌍</span>
                    <h4>Global Health Perspective</h4>
                    <p>We bring you health insights from medical experts worldwide, covering diverse health topics and cultural approaches to wellness.</p>
                </div>
                <div class="mission-card">
                    <span class="mission-icon">💡</span>
                    <h4>Easy to Understand</h4>
                    <p>Complex medical information simplified into clear, actionable insights that help you make informed health decisions.</p>
                </div>
            </div>

            <div class="team-section" id="experts">
                <h3 class="team-title">Our Expert Team</h3>
                <div class="team-grid">
                    <div class="team-member">
                        <div class="team-avatar">DR</div>
                        <div class="team-name">Dr. Sarah Johnson</div>
                        <div class="team-role">Chief Medical Officer</div>
                        <div class="team-bio">Board-certified physician with 15+ years in preventive medicine and public health advocacy.</div>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">MK</div>
                        <div class="team-name">Dr. Michael Kim</div>
                        <div class="team-role">Cardiology Specialist</div>
                        <div class="team-bio">Leading cardiologist specializing in heart health research and cardiovascular disease prevention.</div>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">EP</div>
                        <div class="team-name">Dr. Emily Parker</div>
                        <div class="team-role">Nutrition Expert</div>
                        <div class="team-bio">Registered dietitian and nutrition scientist focused on evidence-based dietary recommendations.</div>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">JL</div>
                        <div class="team-name">Dr. James Liu</div>
                        <div class="team-role">Mental Health Specialist</div>
                        <div class="team-bio">Licensed psychiatrist dedicated to mental health awareness and psychological wellness education.</div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <script>
        // Open article in new tab
        function openArticle(url) {
            if (url) {
                window.open(url, '_blank');
            }
        }

        // Scroll to section function
        function scrollToSection(selector) {
            document.querySelector(selector).scrollIntoView({
                behavior: 'smooth'
            });
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
            
            // Handle "All Categories" button
            if (category === 'all') {
                fetch(`simple_gnews.php?action=search&q=${encodeURIComponent('health wellness')}&max=50`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.articles.length > 0) {
                            displayArticles(data.articles);
                            document.querySelector('#articles .section-title').textContent = 'Latest Health Articles';
                            document.querySelector('#articles').scrollIntoView({ behavior: 'smooth' });
                        } else {
                            articlesGrid.innerHTML = '<div class="loading">No articles found.</div>';
                        }
                    })
                    .catch(error => {
                        console.error('All categories load error:', error);
                        articlesGrid.innerHTML = '<div class="loading">Error loading articles.</div>';
                    });
                return;
            }
            
            // Map categories to search terms
            const categoryQueries = {
                'heart': 'heart health cardiovascular',
                'nutrition': 'nutrition diet food healthy eating',
                'fitness': 'fitness exercise workout physical activity',
                'mental': 'mental health psychology wellness',
                'medicine': 'medicine medical treatment drugs',
                'prevention': 'prevention healthcare disease prevention'
            };
            
            const query = categoryQueries[category] || category;

            fetch(`simple_gnews.php?action=search&q=${encodeURIComponent(query)}&max=12`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.articles.length > 0) {
                        displayArticles(data.articles);
                        document.querySelector('#articles .section-title').textContent = `${category.charAt(0).toUpperCase() + category.slice(1)} Articles`;
                        // Scroll to articles section
                        document.querySelector('#articles').scrollIntoView({ behavior: 'smooth' });
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
            const trendingQueries = ['medical breakthrough', 'wellness tips', 'health research', 'nutrition facts'];
            const promises = trendingQueries.map(query => 
                fetch(`simple_gnews.php?action=search&q=${encodeURIComponent(query)}&max=4`)
                    .then(response => response.json())
            );
            
            Promise.all(promises)
                .then(results => {
                    const trendingArticles = [];
                    results.forEach(data => {
                        if (data.success && data.articles.length > 0) {
                            trendingArticles.push(...data.articles);
                        }
                    });
                    
                    if (trendingArticles.length > 0) {
                        const trendingContainer = document.getElementById('trendingArticles');
                        trendingContainer.innerHTML = trendingArticles.slice(0, 4).map(article => `
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
        let loadMoreCounter = 0;
        document.getElementById('loadMoreBtn').addEventListener('click', function() {
            this.textContent = 'Loading...';
            this.disabled = true;
            
            // Use different search terms to get variety
            const searchTerms = [
                'medical research health',
                'wellness fitness nutrition',
                'healthcare medicine',
                'health news medical',
                'disease prevention health',
                'mental health wellness',
                'nutrition diet health',
                'medical breakthrough',
                'health tips wellness',
                'healthcare news'
            ];
            
            const searchTerm = searchTerms[loadMoreCounter % searchTerms.length];
            loadMoreCounter++;
            
            fetch(`simple_gnews.php?action=search&q=${encodeURIComponent(searchTerm)}&max=30`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.articles.length > 0) {
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
                            
                            // Hide button if we have 150+ articles
                            if (totalArticles >= 150) {
                                this.textContent = 'All articles loaded';
                                this.disabled = true;
                            }
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