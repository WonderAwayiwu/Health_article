# HealthHub Frontend HTML Files

This folder contains the extracted frontend designs for each page of the HealthHub project. These are pure HTML files with embedded CSS and minimal JavaScript for demonstration purposes.

## Files Included

### 1. `index.html` - Homepage
- **Features**: Complete homepage design with hero section, stats, categories, articles grid, sidebar, about section, and footer
- **Images Used**: All category images, doctor photos, social media icons, background images
- **Sections**: Header with navigation, hero banner, statistics cards, health categories, featured articles, trending sidebar, newsletter signup, about section with team, footer

### 2. `login.html` - Login Page
- **Features**: Modern glassmorphism login form with background image
- **Images Used**: health2.jpg as background
- **Elements**: Username/password inputs, remember me checkbox, login button, signup link

### 3. `register.html` - Registration Page
- **Features**: Clean signup form with glassmorphism design
- **Images Used**: health1.jpg as background
- **Elements**: Username, email, password inputs, signup button, social signup options, login link

### 4. `article_view.html` - Article Reading Page
- **Features**: Split-screen layout with article content and comments section
- **Elements**: Article display area, comments list, comment input form, pagination, back button
- **Functionality**: Load full article, comment system, user avatar generation

### 5. `view_all_comments.html` - Comments Overview Page
- **Features**: All comments display with search functionality
- **Images Used**: view_all_comments_background.jpg as background
- **Elements**: Statistics cards, search box, comment cards with user info, article links

## Design Features

### Color Scheme
- **Primary**: Green (#16a34a, #059669) - Health/Medical theme
- **Secondary**: Blue (#1d4ed8, #3b82f6) - Trust and reliability
- **Neutral**: Grays and whites for content readability

### Typography
- **Primary Font**: Inter (Google Fonts)
- **Fallback**: System fonts (-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto)
- **Weights**: 400, 500, 600, 700, 800

### Visual Effects
- **Glassmorphism**: Backdrop blur effects on login/register pages
- **Gradients**: Linear gradients for buttons and backgrounds
- **Shadows**: Box shadows for depth and elevation
- **Hover Effects**: Transform and color transitions
- **Responsive Design**: Mobile-first approach with media queries

### Image References
All images are referenced relative to the parent directory:
```
../images/[filename]
```

## Usage Instructions

1. **Setup**: Place these HTML files in a `frontend_html` folder within your project
2. **Images**: Ensure the `images` folder is in the parent directory
3. **Navigation**: Update links between pages as needed for your project structure
4. **Customization**: Modify colors, fonts, and content to match your requirements

## Team Collaboration

These files are designed for easy collaboration:
- **Modular Design**: Each page is self-contained
- **Clean Code**: Well-commented CSS and organized structure
- **Responsive**: Works on desktop, tablet, and mobile devices
- **Accessible**: Semantic HTML and proper contrast ratios

## Integration Notes

To integrate with your PHP backend:
1. Copy the HTML structure to your PHP files
2. Replace static content with PHP variables
3. Add form actions and PHP processing logic
4. Implement database connections for dynamic content

## Browser Compatibility

- **Modern Browsers**: Chrome, Firefox, Safari, Edge (latest versions)
- **CSS Features**: Flexbox, Grid, Custom Properties, Backdrop Filter
- **JavaScript**: ES6+ features used minimally

## File Structure
```
frontend_html/
├── index.html          # Homepage
├── login.html          # Login page
├── register.html       # Registration page
├── article_view.html   # Article reading page
├── view_all_comments.html # Comments overview
└── README.md          # This file
```

## Contributing

When working on these files:
1. Maintain consistent styling across pages
2. Test responsiveness on different screen sizes
3. Ensure accessibility standards are met
4. Keep image paths relative and consistent
5. Document any major changes or additions

---

**Created for**: Health Article Project Team Collaboration
**Purpose**: Frontend design extraction for individual team member contributions
**Last Updated**: December 2024