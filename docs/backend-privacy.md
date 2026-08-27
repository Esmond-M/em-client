# Backend Privacy

The `em-client` theme is used as the WordPress backend for the Content Operations dashboard. It is hosted at:

```text
https://ops.esmondmccain.com
```

This is not the public portfolio website. The theme should not present its boilerplate homepage as a public-facing site.

## Homepage behavior

The theme redirects visitors from the front page before the normal template is rendered:

- Anonymous visitors are sent to the WordPress login page.
- Authenticated visitors are sent to `/wp-admin/`.
- WordPress admin requests, AJAX, cron, and REST requests are not redirected.

This keeps the backend homepage from exposing the boilerplate theme while preserving normal WordPress administration and API access.

## Search indexing

The theme adds `noindex` and `nofollow` directives to normal WordPress HTML responses. This is a secondary privacy measure and is not authentication. Anyone who knows a URL may still request it unless the host or WordPress permissions restrict access.

## REST API availability

The dashboard currently reads these public REST endpoints:

```text
https://ops.esmondmccain.com/wp-json/wp/v2/posts
https://ops.esmondmccain.com/wp-json/wp/v2/project_item
```

Do not block the entire REST API without updating the dashboard authentication model. The `project_item` post type, `project_type` taxonomy, `project_stack` taxonomy, and case-study metadata must remain exposed through REST for the dashboard to work.

Write operations and administrative screens should continue to rely on WordPress authentication and capabilities.

## Verification

After deploying the theme:

1. Open `https://ops.esmondmccain.com/` in a private browser window. It should redirect to WordPress login rather than show the boilerplate homepage.
2. Sign in and confirm the root URL redirects to `/wp-admin/`.
3. Request the posts endpoint and confirm it returns a successful response.
4. Request the case-study endpoint and confirm it returns a successful response.
5. Check a normal HTML page source for `noindex` and `nofollow` when the page is rendered through `wp_head()`.
6. Run PHP syntax validation on `functions.php` after future changes:

```bash
php -l functions.php
```

For stronger protection, add host-level access control or place the backend behind a private network/VPN. Theme redirects and search directives are useful safeguards, but they are not a replacement for server authentication.
