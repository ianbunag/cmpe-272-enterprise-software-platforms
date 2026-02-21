# Architecture & Coding Patterns

This document serves as a reference for how the project is structured and how to code new features. It's designed for both human developers and Copilot to understand the codebase patterns.

## Project Structure

```
public/
├── index.php             # Homepage with system info
├── lab-activities/       # Lab assignment submissions
│   └── 02-19/            # Date-based lab directories
│       └── index.php
├── examples/             # Code examples and demonstrations
│   └── routing/          # Routing examples
│       ├── php/          # PHP directory index example
│       ├── html/         # Static HTML example
│       └── dynamic/id/   # Dynamic routing example
│           ├── index.php
│           └── products.php
└── static/               # Static assets (images, icons, CSS)
    └── favicon.ico
migrations/                # Database schema migrations (Phinx)
nginx/                     # Nginx configuration
php-fpm/                   # PHP-FPM configuration
```

## Routing System

### Overview
Routing is handled by Nginx with a 3-level fallback mechanism:
1. Check for static files
2. Check for dynamic routes (map-based)
3. Check for PHP files or directory indexes

All routes support trailing slashes (`/path` and `/path/` work identically).

### Route Resolution Flow

```
Request: /path/to/page
    ↓
[1] Try static file → $uri exists? → Serve directly
    ↓ (No match)
[2] Try dynamic route → Map matches? → Rewrite with query params
    ↓ (No match)
[3] Try PHP file → $uri.php exists? → Rewrite to $uri.php
    ↓ (No match)
[4] Try directory index → $uri/index.php exists? → Rewrite to $uri/index.php
    ↓ (No match)
[5] Try HTML index → $uri/index.html exists? → Rewrite to $uri/index.html
    ↓ (No match)
Return 404
```

### Static Routes (PHP Files)
**Syntax:** `/path/to/file` → Maps to `/path/to/file.php`

**Example:**
- Request: `/examples/routing/php`
- Resolution: `/examples/routing/php/index.php` (directory index)

### Directory Indexes
Nginx automatically serves `index.php` or `index.html` from a directory.

**Examples:**
- `/examples/` → `/examples/index.php`
- `/lab-activities/` → `/lab-activities/index.php`

### Dynamic Routes (Scalable Map Approach)
Dynamic routes are defined using Nginx `map` directives in `nginx/default.conf`. This is scalable and centralized.

**Configuration Structure:**
```nginx
map $request_uri $dynamic_route_target {
    default "";
    ~^/pattern/(\d+)/?$ "/target/path/index.php";
    ~^/pattern/(\d+)/sub/?$ "/target/path/sub.php";
}

map $request_uri $dynamic_route_query_params {
    default "";
    ~^/pattern/(\d+)/?$ "id=$1";
    ~^/pattern/(\d+)/sub/?$ "id=$1";
}
```

**Example: Product IDs**

Define in `nginx/default.conf`:
```nginx
map $request_uri $dynamic_route_target {
    default "";
    ~^/examples/routing/dynamic/(\d+)/?$ "/examples/routing/dynamic/id/index.php";
    ~^/examples/routing/dynamic/(\d+)/products/?$ "/examples/routing/dynamic/id/products.php";
}
map $request_uri $dynamic_route_query_params {
    default "";
    ~^/examples/routing/dynamic/(\d+)/?$ "id=$1";
    ~^/examples/routing/dynamic/(\d+)/products/?$ "id=$1";
}
```

**Usage in PHP:**
```php
<?php
$id = $_GET['id'];
// Now you can use $id safely
?>
```

**Requests:**
- `/examples/routing/dynamic/123` → Routes to `/examples/routing/dynamic/id/index.php?id=123`
- `/examples/routing/dynamic/456/products` → Routes to `/examples/routing/dynamic/id/products.php?id=456`

### Blocked Extensions
All file extension requests are blocked (except in `/static/`). This prevents:
- Direct access to `.php` files
- Information disclosure

### Trailing Slash Support
Both `/path` and `/path/` are treated identically. The Nginx configuration uses `/?$` in regex patterns to support this.

## Frontend Conventions

### Styling
- **Framework:** Pico.css (via CDN)
- **No custom CSS:** All styling comes from Pico.css through semantic HTML
- **Theme:** Set via `data-theme` attribute on `<html>` tag
- Responsive by default; Pico.css handles mobile, tablet, and desktop layouts

### HTML Structure
Use semantic HTML for proper document structure and accessibility. Pico.css automatically styles these elements.

**Document Structure:**
```html
<html lang="en" data-theme="light">
  <head>
    <!-- Meta tags and stylesheets -->
  </head>
  <body>
    <main class="container">
      <article>
        <header>
          <h1>Page Title</h1>
          <p>Subtitle or description</p>
        </header>
        
        <section>
          <h2>Section Title</h2>
          <!-- Content -->
        </section>
        
        <section>
          <h3>Subsection</h3>
          <!-- More content -->
        </section>
        
        <footer>
          <!-- Footer links, copyright, etc. -->
        </footer>
      </article>
    </main>
  </body>
</html>
```

**Common Elements (NOT limited to these):**
- `<main>` - Main content wrapper (use `.container` class for responsive width)
- `<article>` - Article or self-contained content block
- `<header>` - Introductory content or navigation
- `<footer>` - Footer content
- `<section>` - Thematic grouping of content
- `<nav>` - Navigation links
- `<aside>` - Sidebar or related content
- `<table>` - Tabular data (automatically styled with borders and padding)
- `<figure>` + `<figcaption>` - Images with captions
- `<blockquote>` - Block quotes (automatically styled with borders)
- `<mark>` - Highlighted text (yellow background)
- `<kbd>` - Keyboard input (monospace, bordered)
- `<code>` - Inline code
- `<pre>` - Preformatted text (for code blocks)
- `<ul>`, `<ol>`, `<dl>` - Lists (all styled automatically)
- `<button>`, `<a role="button">` - Interactive elements
- `<form>`, `<input>`, `<textarea>`, `<select>` - Form elements (all styled)
- `<fieldset>`, `<legend>` - Form grouping
- `<label>` - Form labels (properly associated with inputs)

**Don't use:**
- Custom CSS classes for styling (Pico.css handles it)
- Generic `<div>` wrappers when semantic alternatives exist
- Inline styles

### Meta Tags (Required)
```html
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow, noarchive">
<title>Page Title</title>
<link rel="icon" type="image/x-icon" href="/static/favicon.ico">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
```

**Important Details:**
- `charset="UTF-8"` - Must be first meta tag for security
- `viewport` - Required for responsive design
- `robots` - Set to `noindex, nofollow, noarchive` for coursework (internal only)
- `title` - Descriptive page title (shown in browser tab and search results)
- `icon` - Favicon for browser tab
- Pico.css CDN link - Must come after other meta tags

## Database Setup

### Migrations
- Use Phinx for all schema changes
- Create migration files in `migrations/` with timestamp prefix
- Format: `YYYYMMDDHHMMSS_description.php`


## Environment Variables

Variables are stored in `.env` file. Common variables:
- `DB_USER` - Database user
- `DB_PASSWORD` - Database password
- `REPO_URL` - GitHub repository URL

Load with `getenv('VARIABLE_NAME')`.

## Development vs Production

| Aspect | Development | Production |
|--------|-------------|-----------|
| **File** | `docker-compose.yml` | `docker-compose-prod.yml` (copied to server) |
| **Images** | Built locally | Pulled from GHCR |
| **Volumes** | Mounted for live reload | None (immutable containers) |
| **Deploy Command** | `docker compose up -d` | `bash /var/lib/app/docker-compose up -d` |

## Adding New Code Patterns

If you introduce a new coding pattern, convention, or structural change:
1. Document it here in `docs/ARCHITECTURE.md`
2. Update `CONTRIBUTING.md` if it affects contribution guidelines
3. Ensure examples exist in `/public/examples/` or `/public/lab-activities/`
4. Update this file before merging

This keeps documentation synchronized with code and helps Copilot understand project patterns.

