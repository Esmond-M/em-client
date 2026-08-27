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
- Logged-in administrators with the `manage_options` capability can browse frontend routes without being redirected.
- WordPress admin requests, AJAX, cron, and REST requests are not redirected.

This keeps the backend homepage from exposing the boilerplate theme while preserving normal WordPress administration and API access.

## WPS Hide Login compatibility

The redirect uses WordPress's `wp_login_url()` function rather than a hardcoded `wp-login.php` path. When WPS Hide Login is installed and configured, WordPress can provide the plugin's custom login URL to the redirect automatically.

After enabling WPS Hide Login:

1. Set and record the custom login slug in the plugin settings.
2. Test the custom login URL in a private browser window.
3. Confirm an anonymous request to the backend homepage redirects to that custom login URL.
4. Confirm `/wp-login.php` is no longer treated as the public login entry point.
5. Do not hardcode the hidden slug in theme code; it belongs in the plugin configuration.

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
