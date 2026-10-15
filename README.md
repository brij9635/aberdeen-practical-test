# Aberdeen University - Programs Module

Practical test implementation of a WordPress Programs module and theme based on the provided Figma designs. Built completely with custom code without third-party plugins (no ACF, CMB2, or Elementor).

> **Quick Evaluation Guide**: For a step-by-step reviewer testing checklist with URLs and file paths, see [INSTRUCTIONS.md](INSTRUCTIONS.md).

---

## Overview & URLs

The project consists of a custom theme (`aberdeen-theme`) and a custom functionality plugin (`programs-module`).

Key routes:
- `/` - Homepage (Hero slider, Careers section, Programme tracks, Modal lead form, Footer)
- `/programmes` - All programmes archive with dynamic Interactivity API category filtering
- `/programmes/undergraduate` - Undergraduate programmes archive
- `/programmes/postgraduate` - Postgraduate programmes archive
- `/programmes/{slug}` - Single programme detail page with dynamic curriculum repeater sections

---

## Architecture: Theme vs Plugin

Per WordPress best practices:

- **Plugin (`wp-content/plugins/programs-module`)**: Handles data persistence, custom post types, taxonomies, admin editing interfaces, and API endpoints. If the theme is switched, all programme data and tracking remain intact.
  - `includes/cpt-program.php`: Registers `program` CPT and `program-type` taxonomy, rewrite rules, and REST filter endpoint.
  - `includes/custom-fields.php`: Registers post meta (`academic_year`, `duration`, `content_sections`) with REST API schemas.
  - `includes/click-tracking.php`: REST endpoint `POST /wp-json/programs/v1/track`, JSON Lines logging, and `.htaccess` protection.
  - `includes/seed-data.php`: Seed data and `wp program seed` WP-CLI command.
  - `assets/`: React-powered repeater admin metabox and styles.

- **Theme (`wp-content/themes/aberdeen-theme`)**: Handles presentation, responsive layouts, typography, and frontend templates.
  - `header.php`, `footer.php`, `front-page.php`, `single-program.php`, `archive-program.php`, `taxonomy-program-type.php`.
  - `template-parts/program-card.php`: Reusable card component (Task 5).
  - `template-parts/modal-lead-form.php`: Lead enquiry popup modal & success screen.
  - `assets/css/main.css`: Theme styling using custom properties, Lexend Deca font, and FontAwesome icons.
  - `assets/js/interactivity-filter.js`: Frontend filter using the WordPress Interactivity API.
  - `assets/js/theme.js`: Vanilla JS event delegation for click tracking and modal handling.

---

## Installation & Setup

1. **Activate Theme & Plugin**:
   - Activate **Aberdeen University Theme** in Appearance > Themes.
   - Activate **Aberdeen Programs Module** in Plugins.

2. **Permalinks**:
   - Go to Settings > Permalinks and click **Save Changes** once to flush rewrite rules.

3. **Sample Data**:
   - Sample programs are automatically seeded on plugin activation, or can be run via WP-CLI:
     ```bash
     wp program seed
     ```

---

## Features Implemented

### 1. Custom Post Type & Hierarchical Taxonomy
- CPT: `program` (slug: `programmes`)
- Taxonomy: `program-type` (terms: `Undergraduate`, `Postgraduate`)
- Supports: Title, editor, thumbnail, excerpt, custom fields.

### 2. Custom Fields & React Admin Metabox
- Fields registered via `register_post_meta()` with `show_in_rest => true`:
  - `academic_year` (string)
  - `duration` (string)
  - `content_sections` (array of objects: `title`, `description`, `image_url`, `image_id`)
- Built with `@wordpress/element` (React) featuring row addition, removal, Up/Down reordering, accordion collapse/expand, and native WordPress media library picker.

### 3. Frontend Routing & Collision Avoidance
- `/programmes/(undergraduate|postgraduate)` routes to the taxonomy archive.
- `/programmes/{slug}` routes to the single programme post.
- Single post slugs are checked against taxonomy terms to prevent route collisions.

### 4. Reusable Program Card (`template-parts/program-card.php`)
- Follows Task 5 specification strictly: displays only Image, Title, Academic year badge, and Duration badge.
- Usable anywhere via helper:
  ```php
  aberdeen_render_program_card( $post_id );
  ```
  or standard template part:
  ```php
  get_template_part( 'template-parts/program-card', null, array( 'post_id' => $id ) );
  ```
- Responsive grid (3 columns desktop, 2 columns tablet, 1 column mobile) with accessible markup and keyboard focus states.

### 5. Frontend Interactivity API Filter
- Client-side category filtering on `/programmes` using `@wordpress/interactivity` (`store('programsFilter', ...)`).
- Synchronizes browser URL via `history.pushState()`.
- No-JS fallback: filter tabs are valid HTML links.
- Includes loading spinner and empty-state handling.

### 6. Click Tracking System
- Central helper function: `program_track_attr( $event, $label, $section, $component )`.
- Vanilla JS event delegation captures clicks on elements with `[data-track]`.
- Asynchronous transport via `navigator.sendBeacon()` or `fetch({ keepalive: true })`.
- REST route `POST /wp-json/programs/v1/track` validates payload against schema and drops invalid/oversized requests.
- Appends events to `wp-content/uploads/logs/data-track.log` in JSON Lines format:
  ```json
  {"timestamp":"2026-10-15T02:00:00Z","page_url":"http://localhost/Aberdeen/programmes/","payload":{"type":"click","event":"link","link":{"label":"bachelor-of-computer-applications"},"content_data":{"sectionName":"programme-card","uiComponent":"componentCard"}}}
  ```
- Security: `.htaccess` (`Deny from all`) and `index.php` prevent direct browser access to the log directory. Zero PII is stored.

---

## Git Workflow

Following the compulsory test guidelines:
```text
main ◄─── uat ◄─── dev ◄─── feature/*
```

Branches used:
- `feature/cpt-setup`: Initial post type, taxonomy, and meta registration.
- `feature/theme-setup`: Theme templates, styling, Interactivity API, card component, and tracking integration.
- `dev`: Primary development integration branch.
- `uat`: User acceptance staging branch.
- `main`: Production release branch.

---

## Technical Decisions & Assumptions

1. **Classic Theme vs Block Theme**: A classic PHP theme was chosen to maintain precise control over the exact Figma layouts, CSS custom properties, and semantic template hierarchy required by the test.
2. **REST Tracking Route**: The tracking route is public so unauthenticated site visitors can generate interaction logs without requiring a login session. It is protected by strict payload validation, length limits, and whitelisted event types.
3. **Transient Caching**: Query results are cached in transients for 12 hours and automatically flushed when programmes or taxonomy terms are updated in the admin.
