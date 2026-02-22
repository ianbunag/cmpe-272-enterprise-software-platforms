# Copilot Development Guidelines

These guidelines define how Copilot should approach development tasks for this project.

## Code Quality & Scope

### 1. Specification Compliance
- **Never add functionality that is not in the spec**
- Do not create unused helper functions, utility methods, or extra features
- Only implement what is explicitly requested or directly required for the specification
- Example: Do not add `getFeatured()` method to ProductModel if it's not used anywhere

### 2. Code Organization
- Follow the MVC pattern strictly
- Keep models focused on data access only
- Keep views focused on presentation only
- Keep controllers focused on request handling and data flow

## Documentation

### 1. PHPDoc Standards
- **Always generate PHPDoc** for parameters and return values that are keyed structures
- Keyed structures include:
  - **Arrays** with specific field names (associative arrays)
  - **Objects** with properties
  - Example: `array{ id: int, name: string, email: string }`
  
- **For all other types**, developer will explicitly request documentation if needed
- Examples of types that don't require PHPDoc unless requested:
  - Simple types: `string`, `int`, `bool`, `float`
  - Simple arrays: `array<int, string>` (indexed arrays)
  - Standard return types: `void`, `null`, `PDO`, `PDOException`

### 2. Comment Format
When documenting keyed arrays/objects, use this format:

```php
/**
 * @return array{
 *     id: int,
 *     name: string,
 *     origin_country: string,
 *     taste_profile: string,
 *     image_url: string,
 *     alt_text: string,
 *     price: string
 * }|null Product record if found, null otherwise
 */
```

For arrays of keyed arrays:

```php
/**
 * @return array<int, array{
 *     id: int,
 *     name: string,
 *     origin_country: string
 * }> Array of product records
 */
```

## Deliverables & Output

### 1. No Summary Documents
- **Never create summary documents** after completing a task
- Do not generate:
  - Summary markdown files
  - Implementation checklists
  - Status documents
  - File structure overviews
  
- If a summary or status needs to be communicated, **write it directly in the chat** instead

### 2. Direct Communication
- Use chat messages to:
  - Report completion status
  - Explain changes made
  - Ask clarifying questions
  - Provide any necessary context
  
- All important information goes in the chat, not in separate files

## Banana Buoy Theming

### 1. Theme Philosophy
- **Keep the theme as-is**: The Banana Buoy design uses Pico.css v2.1.1 with a customized ocean-hydrogen color palette
- **Avoid custom styling**: Use existing Pico.css utilities and custom CSS variable classes in `pico.css` whenever possible
- **Never modify theme without asking**: If custom styles or theme changes are needed, ask the developer first

### 2. Available Styling Resources
- **Pico.css v2**: Semantic HTML elements automatically styled (buttons, forms, tables, articles, etc.)
- **CSS Variables** (`pico.css`): All colors and typography defined via `--contrast-color`, `--button-background-color`, etc.
- **Custom Utility Classes** (`styles.css`):
  - `.banana-buoy-grid-card-horizontal-layout` - Responsive card grid
  - `.banana-buoy-grid-card-vertical-layout` - Two-column layout
  - `.banana-buoy-image-hero-landscape` - Hero images
  - `.banana-buoy-image-thumbnail` - Thumbnail images
  - `.banana-buoy-image-hero-square` - Square images with shadow
  - `.banana-buoy-alert-info` - Info boxes
  - `.banana-buoy-tag` - Inline badges
  - `.banana-buoy-text-align-*` - Text alignment
  - `.banana-buoy-layout-space-between` - Flex spacing

### 3. When Adding New Features
- **Step 1**: Use semantic HTML first (Pico.css will style it automatically)
- **Step 2**: Check if an existing utility class matches your needs
- **Step 3**: Use CSS variables for any color or typography needs
- **Step 4**: Only if none of the above work, ask the developer before adding custom styles

### 4. Files to Reference
- `public/static/banana-buoy/pico.css` - Theme customization, CSS variables
- `public/static/banana-buoy/style.css` - All utility classes
- `src/banana-buoy/views/BaseView.php` - Loads Pico.css v2, custom theme, and utility classes
- All child views extend `BaseView` and inherit the theme automatically

---

Last Updated: February 21, 2026

