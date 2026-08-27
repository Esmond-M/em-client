# All-in-One WP Migration Folder Exclusions

## Purpose

The `em-client` theme excludes local development folders from All-in-One WP Migration exports. These folders belong in source control or local development and are not required for the deployed WordPress site.

## Current exclusions

The logic is in the theme's `functions.php` file and currently excludes these folders from the active theme directory:

- `.git`
- `.vscode`
- `build`
- `docs`
- `node_modules`

The callback builds an exact path for each folder with `get_stylesheet_directory()`. All-in-One WP Migration expects exact relative or absolute paths; the values are not regular expressions.

## Filters used

All-in-One WP Migration exposes content and theme files through separate export filters, so the callback is registered with both:

```php
add_filter( 'ai1wm_exclude_content_from_export', 'emclient_ai1wm_exclude_development_files' );
add_filter( 'ai1wm_exclude_themes_from_export', 'emclient_ai1wm_exclude_development_files' );
```

This affects exports only. It does not delete files from the server or from the local theme checkout.

## Adding another folder

Add only local-only folders to the `$development_directories` array in `functions.php`:

```php
$development_directories = array(
    '.git',
    '.vscode',
    'build',
    'docs',
    'node_modules',
    'new-local-folder',
);
```

Do not exclude WordPress templates, runtime assets, uploads, configuration, or any other files required by the production site. Keep the folder name relative to the active theme directory and do not add a trailing slash.

## Verification

1. Confirm `em-client` is the active theme.
2. Confirm All-in-One WP Migration is active.
3. Create a test export from **All-in-One WP Migration > Export**.
4. Inspect the export archive or its size to confirm the development folders are absent.
5. Confirm the deployed theme still contains all required PHP, CSS, JavaScript, and image files.
6. Run this syntax check after editing `functions.php`:

```bash
php -l functions.php
```
