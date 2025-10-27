# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a PHP-based web application for displaying QR codes, barcodes, and other scannable images. The application serves as a simple code display system where each "code" has its own folder containing metadata and images.

## Architecture

**Main Entry Point**: `index.php` - The primary application file that handles code display requests via GET parameter `?code=<folder_name>`

**Code Structure**:
- Each code lives in its own folder under `codes/`
- Each code folder contains:
  - `code.json` - Metadata file with CodeName, CodeImage, CodeCaption, and CodeIcon
  - Image files (icons and scannable codes)
  - `index.php` - Redirect handler that forwards requests to the main application

**Key Components**:
- **URL Routing**: Uses `$_GET["code"]` parameter to determine which code folder to load
- **Template System**: Single PHP file generates HTML with embedded CSS for responsive display
- **File Security**: Input sanitization with `preg_replace()` to prevent directory traversal
- **Mobile Optimization**: Responsive CSS with Apple mobile web app meta tags

## Development Commands

**Local Development**:
```bash
# Start PHP built-in server (requires PHP installation)
php -S localhost:8000

# Access example code
# http://localhost:8000/?code=example
```

**Adding New Codes**:
1. Create new folder under `codes/`
2. Add required files:
   - `code.json` with metadata
   - Icon image file
   - Scannable code image file
   - Copy `codes/index.php` for redirect handling

## File Structure

```
/
├── index.php              # Main application
├── codes/
│   ├── index.php         # Redirect handler template
│   └── example/          # Example code folder
│       ├── code.json     # Code metadata
│       ├── icon.png      # App icon
│       └── barcode.gif   # Scannable image
```

## Configuration Notes

- No database required - all data stored in JSON files
- `.gitignore` configured to exclude all code folders except the example
- Responsive design works on mobile devices
- Apple PWA support included for mobile bookmarking