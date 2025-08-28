# EM Client WordPress Theme

A modern, developer-friendly WordPress theme boilerplate designed for rapid website creation. EM Client includes WooCommerce support, custom templates, extensible features for agencies and clients, custom navigation walkers, flexible widgets, and modular Sass.

**Project:** [GitHub Repository](https://github.com/Esmond-M/em-client)  
**Author:** [esmondmccain.com](https://esmondmccain.com/)

---

## Table of Contents

- [Overview](#overview)
- [Installation](#installation)
- [Features](#features)
- [Theme Structure](#theme-structure)
- [Flexible Page Templates](#flexible-page-templates)
- [Custom Widgets](#custom-widgets)
- [Development](#development)
- [Build & Download](#build--download)
- [Support](#support)

---

## Overview

EM Client is a starter WordPress theme with a clean structure, WooCommerce compatibility, custom navigation walkers, flexible page templates, and enhanced header. It’s ideal for building bespoke websites, integrating with page builders, and customizing for client projects.

---

## Installation

1. Download the latest release from the `/build` folder (`em-client.zip`).
2. Upload the `em-client.zip` file to your `/wp-content/themes/` directory.
3. Extract the zip file.
4. Activate the theme via the WordPress admin under **Appearance > Themes**.

---

## Features

- **Custom Frontpage Template:** Easily set up a unique homepage.
- **Flexible Page Templates:** Includes templates for landing pages, fullwidth, shop, and more.
- **Custom Widgets:** Add recent posts, call-to-action, and more to widget areas.
- **Straightforward Template Structure:** Clean, readable PHP templates for rapid customization.
- **WooCommerce Compatibility:** Ready for online shops with custom WooCommerce templates.
- **Sass Files:** Modular SCSS for maintainable styles.
- **NPM Scripts:** Streamlined asset compilation and development workflow.
- **Theme Helper Functions:** Utility functions and a main theme class for organization.
- **Widgetized Footers & Landing Pages:** Multiple widget areas for flexible layouts.
- **Extensible:** Easily add new features or integrate with plugins.
- **Build Folder:** Final theme zip is generated in the `/build` directory for easy download and deployment.
- **Custom Navigation Walkers:** Enhanced menu rendering and mobile submenu toggling.
- **Accessible Menus:** ARIA attributes and keyboard navigation support.

---

## Theme Structure

- `/build/` — Contains the final theme zip (`em-client.zip`) for deployment.
- `/inc/class-nav-walker-desktop.php` — Desktop navigation walker for advanced menu features.
- `/inc/class-nav-walker-mobile.php` — Mobile navigation walker with accessible submenu toggling.
- `/inc/class-widget-recent-posts.php` — Recent posts widget.
- `/inc/class-widget-landing-cta.php` — Landing page call-to-action widget.
- `/page-templates/` — Custom page templates (e.g., landing, fullwidth, shop)
- `/woocommerce/` — WooCommerce template overrides
- `/assets/` — Sass, JS, and images
- `/sass/` — Modular SCSS files
- `functions.php` — Main theme setup and helper functions
- `README.md` — This documentation

---

## Flexible Page Templates

- Assign templates like **Landing Page**, **Fullwidth**, or **Shop** from the WordPress editor.
- Templates support custom widget areas for dynamic content.
- Easily extend with new layouts in `/page-templates/`.

---

## Custom Widgets

- **Recent Posts Widget:** Display latest posts with thumbnails, dates, and category filter.
- **Landing Page CTA Widget:** Add a customizable call-to-action to landing pages.
- Register and manage widgets in `functions.php` and `/inc/`.

---

## Development

- **Styles:** Edit SCSS files in `/sass/` and run `npm run build` to compile.
- **JS:** Place custom scripts in `/assets/js/`.
- **Templates:** Modify or add PHP templates in `/page-templates/` or the theme root.
- **Extend:** Add new helper functions to the main theme class in `functions.php`.
- **Navigation:** Customize menu output and mobile behavior in `/inc/class-nav-walker-desktop.php` and `/inc/class-nav-walker-mobile.php`.
- **Widgets:** Add new widgets in `/inc/` and register in `functions.php`.
- **Build:** Run `npm run plugin-zip-move` to generate and move the theme zip to `/build`.

---

## Build & Download

- The final theme zip (`em-client.zip`) is automatically moved to the `/build` folder after running the build script.
- Download the theme for deployment from `/build/em-client.zip`.

---

## Support

For issues, suggestions, or contributions, please use the [GitHub Issues](https://github.com/Esmond-M/em-client/issues) page.

---

*This theme is maintained by [Esmond McCain](https://esmondmccain.com/). Feel free to fork, extend, and use for your own projects.*