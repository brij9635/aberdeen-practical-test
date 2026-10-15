# WordPress Practical Test: Programs Module

A bespoke, production-ready WordPress Programs module featuring a custom post type, hierarchical taxonomy, modern React admin UI with repeater fields, custom frontend routing, Interactivity API dynamic filtering, and a secure server-side JSON Lines click tracking system. Built strictly according to the WordPress Practical Test specification without third-party plugins.

---

## 📋 Table of Contents
1. [Overview](#overview)
2. [Architecture & Folder Structure](#architecture--folder-structure)
3. [Features Implemented](#features-implemented)
4. [Git Workflow](#git-workflow)
5. [Setup & Build Steps](#setup--build-steps)
6. [Tracking System & Security](#tracking-system--security)
7. [Bonus Features](#bonus-features)
8. [Deliverables Checklist](#deliverables-checklist)

---

## 1. Overview
This project converts the provided Figma designs into a pixel-perfect, accessible, and responsive WordPress website for the University of Aberdeen, accompanied by a custom Programs module.

- **URL Base:** `/programmes` (All Programmes), `/programmes/undergraduate`, `/programmes/postgraduate`, `/programmes/{slug}` (Single Programme).
- **Theme:** Custom classic theme (`aberdeen-theme`) with custom CSS, modern typography (Lexend Deca), and FontAwesome icons.
- **Plugin:** Custom plugin (`programs-module`) providing CPT registration, React Admin Repeater UI, REST filter/tracking endpoints, and JSONL logging.

---

## 2. Architecture & Folder Structure
Sensible separation between Theme (Presentation/Views) and Plugin (Data/Admin/APIs):

```text
├── brijesh/                           # Task 1 Documentation & Video Scripts
│   ├── TASK-CHECKLIST.md              # Detailed implementation checklist
│   ├── TASK-UNDERSTANDING.md          # Technical architecture & decisions
│   └── VIDEO-SCRIPT.md                # 2-3 minute walkthrough scripts
├── wp-content/
│   ├── plugins/
│   │   └── programs-module/           # Custom Plugin (Data, Admin, API, Tracking)
│   │       ├── assets/css/            # Admin styling (clean card layout)
│   │       ├── build/                 # Compiled React bundle (wp-scripts)
│   │       ├── includes/
│   │       │   ├── cpt-program.php    # CPT & Taxonomy registration, rewrites, REST filter
│   │       │   ├── meta-fields.php    # register_post_meta & React admin metabox
│   │       │   ├── click-tracking.php # Click tracking REST route, JSONL logging, cron
│   │       │   └── seed-data.php      # WP-CLI command (wp program seed) & sample data
│   │       ├── src/                   # React source code (@wordpress/element)
│   │       └── programs-module.php    # Main plugin loader
│   └── themes/
│       └── aberdeen-theme/            # Custom Theme (Views, Layout, Assets)
│           ├── assets/
│           │   ├── css/main.css       # Complete Figma stylesheet
│           │   ├── js/theme.js        # Vanilla JS tracking listener & modal controller
│           │   ├── js/interactivity-filter.js # WP Interactivity API filter module
│           │   └── images/            # Local optimized assets & brand logo
│           ├── template-parts/
│           │   ├── program-card.php   # Reusable Program Card Component (Task 5)
│           │   └── modal-lead-form.php# Exact Figma Lead Form & Thank You modal
│           ├── archive-program.php    # Task 4.2 & Task 7 All Programmes archive
│           ├── taxonomy-program-type.php # Task 4.1 & Desktop P2 taxonomy template
│           ├── single-program.php     # Task 6 Single Program Detail page
│           ├── front-page.php         # Homepage (Hero slider, Careers, Tracks, Footer)
│           ├── header.php             # Semantic header, navigation, and preconnect
│           ├── footer.php             # 40px FontAwesome social icons, contact, policies
│           └── functions.php          # Asset enqueue, helpers, breadcrumbs, cache clear
└── README.md                          # Project documentation
```

---

## 3. Features Implemented

### Task 1: Task Understanding & Documentation
- Comprehensive documentation in `brijesh/` directory: technical decisions, assumptions, and video walkthrough script.

### Task 2: Content Structure (Backend)
- `program` CPT registered with public rewrite slug `programmes`.
- Hierarchical taxonomy `program-type` with `Undergraduate` and `Postgraduate` terms.
- 10 complete seeded programs with high-resolution featured images and academic metadata.

### Task 3: Custom Fields & React Admin UI
- `academic_year`, `duration`, and `content_sections` registered with `register_post_meta()` and `show_in_rest => true`.
- React-powered metabox with row addition, removal, Up/Down reordering, accordion collapse/expand, and native `wp.media` integration.

### Task 4: Frontend Routing
- `/programmes/undergraduate` and `/programmes/postgraduate` custom rewrite rules with top priority.
- Collision avoidance logic between taxonomy terms and single program post slugs under `/programmes/{slug}`.
- Dynamic breadcrumb trail.

### Task 5: Reusable Program Card
- Component template part: `template-parts/program-card.php`.
- Displays strictly: Image, Title, Academic year badge, Duration badge.
- Usable anywhere via helper: `aberdeen_render_program_card($post_id)` or `get_template_part()`.
- Responsive CSS grid (3 cols desktop / 2 cols tablet / 1 col mobile) and accessible.

### Task 6: Program Detail Page (`single-program.php`)
- Featured image, title, term link, academic year, duration, main content.
- Dynamic repeater content sections rendered cleanly.
- "Back to programmes" link, "Apply now" button (modal trigger), and "Enquire now" button.

### Task 7: WordPress Interactivity API (Frontend Filter)
- Native `@wordpress/interactivity` store (`programsFilter`).
- Real-time client-side category filtering with browser URL synchronization (`history.pushState`).
- Full progressive enhancement / No-JS fallback.
- Loading indicator and empty state UI.
- REST filter route: `GET /wp-json/programs/v1/filter?type={term}`.

### Task 8: Click Tracking (Data Layer + Secure Log File)
- Global event delegation in vanilla JS (zero jQuery).
- Safe helper: `program_track_attr( $event, $label, $section, $component )`.
- Transmission via `navigator.sendBeacon()` or `fetch({ keepalive: true })`.
- REST route `POST /wp-json/programs/v1/track` with strict schema validation.
- Writes one JSON line per click to `wp-content/uploads/logs/data-track.log`.
- Zero PII logged (no IP addresses, no cookies, no user agents).

---

## 4. Git Workflow
The repository strictly adheres to the compulsory branching model:
```text
main ◄─── uat ◄─── dev ◄─── feature/*
```

1. `feature/*` branches created from `dev`.
2. Work committed using Conventional Commits (`feat:`, `style:`, `fix:`).
3. Merged via Pull Requests: `feature/* -> dev`, then `dev -> uat`, then `uat -> main`.

---

## 5. Setup & Build Steps

1. **Activate Theme & Plugin:**
   - Activate `Aberdeen University Theme` under **Appearance > Themes**.
   - Activate `Aberdeen Programs Module` under **Plugins**.
2. **Flush Permalinks:**
   - Navigate to **Settings > Permalinks** and click **Save Changes** to activate custom rewrite rules.
3. **Compile React Admin UI (if making changes):**
   ```bash
   cd wp-content/plugins/programs-module
   npm install
   npm run build
   ```

---

## 6. Tracking System & Security
- **Log Location:** `wp-content/uploads/logs/data-track.log`
- **Security:**
  - Directory protected by `.htaccess` (`Deny from all`) and `index.php` silence file.
  - Path is filterable via `apply_filters( 'programs_track_log_path', ... )`.
- **Payload Format:** Strict JSON Lines format adhering to the specification:
  ```json
  {"timestamp":"2026-10-14T21:05:40Z","page_url":"http://localhost/Aberdeen/programmes/","payload":{"type":"click","event":"link","link":{"label":"bachelor-of-computer-applications"},"content_data":{"sectionName":"programme-card","uiComponent":"componentCard"}}}
  ```

---

## 7. Bonus Features
- **Bonus 1:** Transient query caching (12 hours) with automatic cache invalidation on post save/delete.
- **Bonus 2:** Schema.org `Course` JSON-LD structured data on single program detail pages.
- **Bonus 3:** Strict REST schema verification and automated regression safety.
- **Bonus 4:** WP-CLI command `wp program seed` for one-command seeding.
- **Bonus 5:** Automated daily WP-Cron log rotation (>5MB) and 30-day log cleanup.
