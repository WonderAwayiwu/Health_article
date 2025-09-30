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
                <input type="text" class="search-input" placeholder="Search articles...">
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
                <article class="featured-article">
                    <div class="featured-image"></div>
                    <div class="featured-content">
                        <span class="featured-badge">Heart Health</span>
                        <h3 class="featured-title">10 Essential Tips for Better Heart Health</h3>
                        <p class="featured-excerpt">Discover evidence-based strategies to improve your cardiovascular health and reduce the risk of heart disease. Learn from leading cardiologists about lifestyle changes that can make a real difference.</p>
                        <div class="featured-meta">
                            <div class="author-info">
                                <div class="author-avatar">DR</div>
                                <div class="author-details">
                                    <div class="author-name">Dr. Sarah Johnson</div>
                                    <div class="article-date">2 hours ago</div>
                                </div>
                            </div>
                            <span class="read-time">8 min read</span>
                        </div>
                    </div>
                </article>
            </section>

            <!-- Categories -->
            <section class="categories">
                <h2 class="section-title">Browse by Category</h2>
                <div class="category-grid">
                    <div class="category-card">
                        <span class="category-icon">❤️</span>
                        <div class="category-name">Heart Health</div>
                        <div class="category-count">245 articles</div>
                    </div>
                    <div class="category-card">
                        <span class="category-icon">🥗</span>
                        <div class="category-name">Nutrition</div>
                        <div class="category-count">189 articles</div>
                    </div>
                    <div class="category-card">
                        <span class="category-icon">🏃</span>
                        <div class="category-name">Fitness</div>
                        <div class="category-count">156 articles</div>
                    </div>
                    <div class="category-card">
                        <span class="category-icon">🧠</span>
                        <div class="category-name">Mental Health</div>
                        <div class="category-count">134 articles</div>
                    </div>
                    <div class="category-card">
                        <span class="category-icon">💊</span>
                        <div class="category-name">Medicine</div>
                        <div class="category-count">98 articles</div>
                    </div>
                    <div class="category-card">
                        <span class="category-icon">🛡️</span>
                        <div class="category-name">Prevention</div>
                        <div class="category-count">87 articles</div>
                    </div>
                </div>
            </section>

            <!-- Latest Articles -->
            <section id="articles">
                <h2 class="section-title">Latest Articles</h2>
                <div class="articles-grid">
                    <article class="article-card">
                        <div class="article-image"></div>
                        <div class="article-content">
                            <span class="article-category">Nutrition</span>
                            <h3 class="article-title">The Complete Guide to Healthy Eating</h3>
                            <p class="article-excerpt">Learn about balanced nutrition and meal planning for optimal wellness...</p>
                            <div class="article-meta">
                                <span class="article-author">Dr. Maria Rodriguez</span>
                                <div class="article-stats">
                                    <span>❤️ 856</span>
                                    <span>💬 45</span>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="article-card">
                        <div class="article-image"></div>
                        <div class="article-content">
                            <span class="article-category">Mental Health</span>
                            <h3 class="article-title">Managing Stress in Modern Life</h3>
                            <p class="article-excerpt">Effective techniques to cope with daily stress and improve mental well-being...</p>
                            <div class="article-meta">
                                <span class="article-author">Dr. James Smith</span>
                                <div class="article-stats">
                                    <span>❤️ 692</span>
                                    <span>💬 73</span>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="article-card">
                        <div class="article-image"></div>
                        <div class="article-content">
                            <span class="article-category">Fitness</span>
                            <h3 class="article-title">Home Workout Routines That Work</h3>
                            <p class="article-excerpt">Effective exercises you can do at home to stay fit and healthy...</p>
                            <div class="article-meta">
                                <span class="article-author">Lisa Chen</span>
                                <div class="article-stats">
                                    <span>❤️ 1.5K</span>
                                    <span>💬 112</span>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="article-card">
                        <div class="article-image"></div>
                        <div class="article-content">
                            <span class="article-category">Wellness</span>
                            <h3 class="article-title">The Science of Better Sleep</h3>
                            <p class="article-excerpt">Understanding sleep cycles and methods to improve sleep quality...</p>
                            <div class="article-meta">
                                <span class="article-author">Dr. Michael Brown</span>
                                <div class="article-stats">
                                    <span>❤️ 934</span>
                                    <span>💬 67</span>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="article-card">
                        <div class="article-image"></div>
                        <div class="article-content">
                            <span class="article-category">Prevention</span>
                            <h3 class="article-title">Immune System Boosting Foods</h3>
                            <p class="article-excerpt">Natural ways to strengthen your immune system through nutrition...</p>
                            <div class="article-meta">
                                <span class="article-author">Dr. Emily Davis</span>
                                <div class="article-stats">
                                    <span>❤️ 778</span>
                                    <span>💬 54</span>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="article-card">
                        <div class="article-image"></div>
                        <div class="article-content">
                            <span class="article-category">Heart Health</span>
                            <h3 class="article-title">Understanding Blood Pressure</h3>
                            <p class="article-excerpt">Everything you need to know about maintaining healthy blood pressure...</p>
                            <div class="article-meta">
                                <span class="article-author">Dr. Robert Wilson</span>
                                <div class="article-stats">
                                    <span>❤️ 623</span>
                                    <span>💬 38</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Trending This Week</h3>
                <div class="trending-item">
                    <div class="trending-image"></div>
                    <div class="trending-content">
                        <h4>COVID-19 Prevention Updates</h4>
                        <div class="trending-meta">2.3K views • 3 hours ago</div>
                    </div>
                </div>
                <div class="trending-item">
                    <div class="trending-image"></div>
                    <div class="trending-content">
                        <h4>Mediterranean Diet Benefits</h4>
                        <div class="trending-meta">1.8K views • 5 hours ago</div>
                    </div>
                </div>
                <div class="trending-item">
                    <div class="trending-image"></div>
                    <div class="trending-content">
                        <h4>Yoga for Beginners</h4>
                        <div class="trending-meta">1.5K views • 8 hours ago</div>
                    </div>
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
        // Article card click functionality
        document.querySelectorAll('.article-card, .featured-article').forEach(card => {
            card.addEventListener('click', function() {
                window.location.href = 'watchpage.php'; // Redirect to article detail page
            });
        });

        // Category card click functionality
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const category = card.querySelector('.category-name').textContent;
                console.log('Filter by category:', category);
            });
        });

        // Smooth scroll for hero CTA
        document.querySelector('.hero-cta').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#articles').scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>