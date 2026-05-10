# Coaster Site — Claude Instructions

## Project overview

A PHP-based roller coaster/theme park info site. Built with plain PHP, no framework. Runs in Docker with Apache + MariaDB.

## Stack

- **PHP** — plain, no framework
- **MariaDB** — via PDO
- **Tailwind CSS v4** — compiled via CLI (`npm run dev` to watch, `npm run build` for one-off)
- **mixhtml.js** — lightweight HTMX-like library for AJAX interactions (`mix-get`, `mix-post`, `mix-update`, etc.)
- **Leaflet.js** + leaflet.markercluster — interactive map

## Project structure

```
routes.php          # Entry point — all requests go through here
router.php          # Routing logic
config/
  db.php            # PDO database connection ($db)
  _.php             # Global helpers: _(), uuidv4_nodash(), validators
views/
  page-*.php        # Page views
  components/
    _header.php     # HTML head + nav (always included first in views)
    _footer.php     # Footer
    __park-card.php     # Park card component (uses $park variable)
    __coaster-card.php  # Coaster card component (uses $coaster variable)
    __breadcrumb.php
apis/
  api-*.php         # API endpoints called directly by the browser via mix-get/mix-post
  admin/
    api-add-coaster.php
static/
  css/
    input.css       # Tailwind entry point (@import "tailwindcss")
    output.css      # Compiled Tailwind output — do not edit manually
    globals.css     # CSS variables and resets
    styles.css      # Custom component styles
  js/
    mixhtml.js      # mix-html library
```

## Key conventions

- Use double quotes `""` instead of single quotes `''`.

### PHP

- Use `ROOT` constant (defined in `routes.php`) for all file includes: `require_once ROOT . "/config/db.php"`
- `ROOT` is only available when a request goes through `routes.php`. API files called directly by the browser must require dependencies themselves.
- Use `require` (not `require_once`) when including components inside loops, otherwise only the first iteration renders.
- Components like `__park-card.php` and `__coaster-card.php` receive their variable (`$park`, `$coaster`) from the scope of the `foreach` loop that includes them — no explicit passing needed.
- Add `/** @var array $varname */` at the top of components to suppress Intelephense undefined variable warnings.
- Use `_($value)` to safely echo values (runs `htmlspecialchars`). Do NOT use `_()` in conditions — it echoes and returns void.
- Use `uuidv4_nodash()` for primary keys.
- DB values from PDO come back as strings — use `==` not `===` when comparing to integers (e.g. `$row['is_operational'] == 0`).
- Prefer double quotes `"` over single quotes `'` in PHP strings.

### SQL / PDO

- Use named placeholders (`:param`) for `INSERT`/`WHERE` — safe against SQL injection.
- `LIMIT`/`OFFSET` do NOT support bound parameters in MariaDB via PDO — interpolate directly after casting to int: `"... LIMIT 6 OFFSET $offset"` where `$offset = (int)($_GET['offset'] ?? 0)`.
- For multiple `ORDER BY` columns, use a single clause with commas: `ORDER BY park_is_operational DESC, park_title ASC`.

### CSS / Tailwind

- After adding new Tailwind classes, run `npm run build` (or keep `npm run dev` watch running).
- CSS variables are defined in `globals.css` and referenced in Tailwind as `bg-(--variable-name)`.
- `overflow: clip` is used on `main` (not `overflow: hidden`) to avoid breaking `position: sticky`.
- For `sticky` to work on a grid child, add `self-start` (`align-self: start`) to prevent the element stretching to row height.

### mixhtml.js

- `mix-get="url"` on any element triggers a GET fetch on click. On `<form>` elements it triggers on submit.
- `mix-update="#selector"` in the API response replaces the innerHTML of the matched element. Requires a valid CSS selector (e.g. `#parks_container`, not `parks_container`).
- `mix_convert()` runs on page load and attaches event handlers — newly injected HTML is also processed after each fetch.

### Leaflet map

- Marker click events must use `marker.on("click", fn)` — inline `onclick` on elements inside `divIcon` does not fire reliably.
- `L.marker` expects `[lat, lng]` order.
- Use `markers.addTo(map)` after the loop to add the cluster group — don't use `.addTo(map)` on individual markers when using a cluster group.

## Routing

Routes are registered in `routes.php`. Any new API endpoint that needs to be accessible via URL must be added there:

```php
post("/api-add-coaster", "apis/admin/api-add-coaster.php");
```

## Common pitfalls

- API files called directly by fetch need their own `require_once` for `db.php` and `_.php` — these are not auto-loaded.
- `require_once` in a loop only includes the file once — use `require` instead.
- `_()` echoes and returns void — never use its return value in a condition.
- `exit` inside a component terminates the entire page render.
