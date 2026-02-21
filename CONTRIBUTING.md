# Contributing to CMPE-272 Enterprise Software Platforms

Thank you for contributing! This document outlines how to contribute to this repository and maintain code quality.

## Code Style & Conventions

### PHP
- Follow PSR-12 coding standards
- Always include error handling for all operations
- Use semantic HTML and avoid unnecessary CSS classes
- Load configuration from environment variables via `getenv()`

### Frontend
- Use **Pico.css** via CDN for styling (no custom CSS files)
- Write semantic HTML (see [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md#html-structure) for guidelines)
- Include all required meta tags: charset, viewport, robots, title, favicon, Pico.css
- Always set `data-theme="light"` or `data-theme="dark"` on `<html>` tag for consistent theming

### Configuration Files
- Docker Compose: Use volume mounts for development, image pulls for production
- Nginx: Use map-based routing for dynamic routes (scalable approach)
- Environment variables: Document in `.env.example` and load in code with `getenv()`

## Security Guidelines

**⚠️ CRITICAL:** Security vulnerabilities are unacceptable. Every code change must adhere to these guidelines.

### XSS Prevention (Cross-Site Scripting)
**Always sanitize user input before rendering in HTML:**

```php
// ❌ DANGEROUS
<?= $user_input ?>

// ✅ SAFE
<?= htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8') ?>
```

**Context-specific escaping:**
- **HTML content:** `htmlspecialchars($input, ENT_QUOTES, 'UTF-8')`
- **HTML attributes:** `htmlspecialchars($input, ENT_QUOTES, 'UTF-8')`
- **URL parameters:** `urlencode($input)` then `htmlspecialchars()`
- **JavaScript:** Never output user input in JavaScript context. Use `json_encode()` if necessary.

**Never trust:**
- `$_GET`, `$_POST`, `$_COOKIE`, `$_SERVER` - Always sanitize
- User-uploaded files - Validate extensions, MIME types, and file content
- Form submissions - Validate and sanitize all data

### SQL Injection Prevention
**Always use parameterized queries with PDO:**

```php
// ❌ DANGEROUS - SQL Injection vulnerability
$sql = "SELECT * FROM users WHERE id = " . $_GET['id'];
$result = $pdo->query($sql);

// ✅ SAFE - Parameterized query
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$result = $stmt->fetchAll();

// ✅ SAFE - Named parameters (preferred for clarity)
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $_GET['id']]);
$result = $stmt->fetchAll();
```

**Rules:**
- Never concatenate user input into SQL queries
- Use `prepare()` + `execute()` for all dynamic queries
- Use named parameters for complex queries (more readable)

### CSRF Protection
- Implement CSRF tokens for form submissions (future: add when forms are created)
- Validate referrer headers where applicable
- Use SameSite cookie attributes

### Input Validation
**Validate all user input:**

```php
// Type validation
if (!is_numeric($_GET['id'])) {
    die('Invalid ID');
}

// Pattern validation
if (!preg_match('/^[a-zA-Z0-9_]+$/', $_GET['username'])) {
    die('Invalid username');
}

// Length validation
if (strlen($_POST['password']) < 8) {
    die('Password too short');
}
```

### File Upload Security
- Validate file MIME type (check magic bytes, not just extension)
- Restrict file extensions to whitelist (e.g., only `.jpg`, `.png`, `.pdf`)
- Store uploaded files outside the web root or in a secure directory
- Rename files to prevent path traversal attacks
- Set proper file permissions (not executable)

### Headers & Configuration
- Set security headers in Nginx (see `nginx/default.conf`)
- Use `X-Content-Type-Options: nosniff` to prevent MIME sniffing
- Use `X-Frame-Options: DENY` to prevent clickjacking
- Validate `Content-Type` headers

### Error Handling
- Never expose sensitive information in error messages to users
- Log detailed errors server-side for debugging
- Show generic error messages to end-users
- Example:
  ```php
  try {
      // Database operation
  } catch (Exception $e) {
      error_log('DB Error: ' . $e->getMessage()); // Log details
      die('An error occurred. Please try again.'); // Generic message to user
  }
  ```

### Environment Variables
- Never commit `.env` files to version control
- Keep sensitive data (passwords, API keys) in `.env` only
- Document all required variables in `.env.example`
- Validate environment variables at startup

## Routing

Routing is handled by Nginx with a fallback mechanism. See [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md#routing-system) for detailed routing documentation.

**Quick Summary:**
- Static files: Served from `/static/` directory
- PHP files: Can be accessed as `/path/to/file` (without `.php` extension)
- Directory indexes: `index.php` or `index.html` files are served automatically
- Dynamic routes: Defined in `nginx/default.conf` using `map` directives for scalability
- Trailing slashes: Both `/path` and `/path/` are supported

## Database Migrations

- Use Phinx for all database schema changes
- Create migration files in the `migrations/` directory
- Migrations run automatically on deployment
- To run manually: `bash /var/lib/app/docker-compose exec php-fpm vendor/bin/phinx migrate`

## Git Workflow

1. Create a feature branch: `git checkout -b feature/your-feature`
2. Make your changes and commit with clear messages
3. Push to your fork and open a pull request
4. Ensure all changes follow the code style guidelines above

## Testing

- Test routing changes against the examples in `/public/examples/routing/`
- Verify database migrations work in both development and production environments
- Test with different trailing slash combinations for routes
- Test security measures: XSS prevention, SQL injection protection, input validation

## Documentation Updates

**⚠️ IMPORTANT:** If you make changes to:
- **Routing behavior** → Update `docs/ARCHITECTURE.md#routing-system`
- **Frontend conventions** → Update `docs/ARCHITECTURE.md#frontend-conventions`
- **Database setup** → Update `SETUP.md`
- **Security practices** → Update this file and `docs/DOCUMENTATION_UPDATES.md`
- **Any coding pattern** → Update both this file and `docs/ARCHITECTURE.md` accordingly

Keep documentation in sync with code changes to ensure future developers (and Copilot) can understand the project structure.

## Questions?

Refer to:
- `SETUP.md` for deployment and environment setup
- `docs/ARCHITECTURE.md` for architecture, routing, and coding patterns
- `docs/DOCUMENTATION_UPDATES.md` for when to update documentation
- `README.md` for project overview

