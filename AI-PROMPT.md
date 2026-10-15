DEVELOPMENT GUIDE AND AI PROMPTS
===================================================

This document provides structured answers and prompts for planning, building, and delivering a production-ready custom WordPress solution.

---------------------------------------------------
1. HOW SHOULD I START THE TASK AND PLAN THE DEVELOPMENT PROCESS?
---------------------------------------------------

Step-by-step planning process:
- Review Requirements and Figma Designs:
  Identify core templates (Homepage, Taxonomy archive, Single detail page, Header, Footer) and interactive components (lead form modal, category filter, tracking).
- Separate Presentation from Data Persistence:
  Apply WordPress architecture rule:
  - Custom Post Types, custom fields, data schemas, and API endpoints belong in a custom plugin.
  - Page templates, typography, stylesheets, and UI components belong in a custom theme.
- Establish Git Branching Strategy:
  Follow the required branch hierarchy from the start:
  main <--- uat <--- dev <--- feature branches (feature/cpt-setup, feature/theme-setup).
- Set Up Milestones:
  - Phase 1: Custom Post Type, taxonomy, and meta fields in custom plugin.
  - Phase 2: Theme templates, custom properties, and Figma layout matching.
  - Phase 3: Frontend Interactivity API filter and modal lead form.
  - Phase 4: Click tracking system, REST endpoint, and secure log file.
  - Phase 5: Verification, cross-browser testing, code cleanup, and Git merging.

---------------------------------------------------
2. HOW SHOULD I STRUCTURE MY WORDPRESS THEME AND ORGANIZE ITS FILES?
---------------------------------------------------

A clean, maintainable classic WordPress theme structure:

wp-content/themes/aberdeen-theme/
- style.css: Theme metadata and declarations.
- functions.php: Enqueue styles, scripts, theme supports, and card helper function.
- header.php: University logo, navigation menu, and Apply Now CTA button.
- footer.php: University address, social media links, and copyright sub-bar.
- front-page.php: Hero slider, Careers section, and Programme tracks.
- archive-program.php: All Programmes archive with dynamic Interactivity filter.
- taxonomy-program-type.php: Category archive matching Figma Desktop P2 layout.
- single-program.php: Single programme detail page with dynamic curriculum blocks.
- template-parts/
  - program-card.php: Reusable card component (Task 5).
  - modal-lead-form.php: Enquiry lead capture popup modal and thank-you screen.
- assets/
  - css/main.css: CSS custom properties, responsive grid, Lexend Deca font.
  - js/interactivity-filter.js: Frontend category filtering logic.
  - js/theme.js: Modal triggers and event handlers.
  - images/: Theme visual assets and icons.

---------------------------------------------------
3. HOW SHOULD I STRUCTURE MY CUSTOM PLUGIN PROFESSIONALLY?
---------------------------------------------------

Professional, modular plugin architecture:

wp-content/plugins/programs-module/
- programs-module.php: Main plugin entry point with activation/deactivation hooks.
- includes/
  - cpt-program.php: CPT (program) and taxonomy (program-type) registration, rewrite rules, and REST filter endpoint.
  - custom-fields.php: Post meta registration (academic_year, duration, content_sections) with REST schemas.
  - click-tracking.php: REST tracking endpoint, payload validation, and JSON Lines file logging.
  - seed-data.php: Sample programme data and WP-CLI command (wp program seed).
- assets/
  - js/admin-repeater.js: React admin UI for curriculum sections using @wordpress/element.
  - css/admin.css: Admin styling for custom meta boxes and repeater rows.

---------------------------------------------------
4. WHAT BEST PRACTICES SHOULD I FOLLOW FOR CLEAN, SECURE, AND MAINTAINABLE CUSTOM CODING?
---------------------------------------------------

Core principles:
- Zero Third-Party Plugin Dependency:
  Build custom post meta and repeater UI natively using WordPress core React packages (@wordpress/element, @wordpress/components) instead of ACF or CMB2.
- Data Sanitization and Validation:
  - Sanitize input on save using sanitize_text_field(), esc_url_raw(), and custom array sanitization callbacks.
  - Escape all output in templates using esc_html(), esc_attr(), esc_url(), and wp_kses_post().
- Security and Direct Access Prevention:
  - Add defined('ABSPATH') || exit; at the top of every PHP file.
  - Check nonces on all form submissions and admin requests.
  - Check user capabilities using current_user_can('edit_post', $post_id).
- Avoid N+1 Query Issues:
  - Query programmes efficiently using WP_Query with specific fields.
  - Cache query results in WordPress transients for fast page load times.
- Semantic HTML and Accessibility:
  - Use proper semantic elements (header, nav, main, section, footer).
  - Include ARIA attributes (aria-expanded, aria-haspopup, aria-modal) for interactive elements.

---------------------------------------------------
5. HOW CAN I IMPLEMENT APIS EFFICIENTLY USING WORDPRESS REST API AND AJAX?
---------------------------------------------------

Best approach:
- Use WordPress REST API:
  Prefer REST API over admin-ajax.php for modern architecture, built-in schema validation, and clean JSON responses.
- Register Custom Routes:
  Use register_rest_route() in rest_api_init hook with:
  - Namespace: programs/v1
  - Endpoint: /track for event tracking (POST)
  - Endpoint: /filter for category programme queries (GET)
- Strict Permission Callbacks:
  Always provide a permission_callback function. Public endpoints should return __return_true with strict payload validation.
- Fast Response Handling:
  Validate payloads early, reject malformed JSON, and return lightweight JSON responses immediately.

---------------------------------------------------
6. WHAT IS THE BEST APPROACH FOR IMPLEMENTING CLICK TRACKING USING JAVASCRIPT, DATA LAYER, AND LOG FILE?
---------------------------------------------------

Complete tracking architecture:
- Data Layer HTML Attributes:
  Add clean data attributes to clickable elements:
  data-track="true"
  data-track-event="click"
  data-track-label="bachelor-of-computer-applications"
  data-track-section="programme-card"
  data-track-component="componentCard"
- Central Helper Function:
  In PHP, provide program_track_attr(...) to output standard data attributes consistently.
- Frontend JavaScript Event Delegation:
  Listen for clicks globally on document.body. When an element or its ancestor has [data-track], capture the payload.
- Asynchronous Transport:
  Use navigator.sendBeacon() when available, with fetch() keepalive: true as fallback. This guarantees event delivery even if the user navigates away.
- Server-Side Logging:
  - Append events to a dedicated log file: wp-content/uploads/logs/data-track.log.
  - Use JSON Lines format (one JSON object per line) for easy parsing and ingestion.
- File Security and Privacy:
  - Protect the log directory using .htaccess (Deny from all) and index.php.
  - Do not record sensitive personal data (no IP addresses, no cookies, no passwords).

---------------------------------------------------
7. HOW SHOULD I TEST, OPTIMIZE, REVIEW, AND PREPARE THE COMPLETE PROJECT FOR GITHUB SUBMISSION?
---------------------------------------------------

Checklist before submission:
- Step-by-Step Functional Verification:
  - Test homepage, slider chevrons, and enquiry form popup.
  - Test category filter tabs on /programmes without page reload.
  - Test category archive page (/programmes/undergraduate/) matching Figma Desktop P2.
  - Test single programme page, breadcrumbs, and Schema.org Course markup.
  - Test React admin repeater: add, edit, reorder, delete, and save curriculum sections.
  - Test click tracking: verify new entries appear in data-track.log and direct browser access gives 403 Forbidden.
- Remove Temporary and Debug Files:
  Delete scratch test scripts, debug log dumps, and temporary files. Keep only required theme and plugin code.
- Prepare Clean Documentation:
  - README.md: Architecture overview, routes, setup steps, and technical decisions.
  - INSTRUCTIONS.md: Step-by-step reviewer testing guide with direct URLs.
  - AI-PROMPT.md: Development planning and prompts reference.
- Enforce Git Branching Workflow:
  - Commit all changes cleanly to feature branches.
  - Merge feature branches into dev, dev into uat, and uat into main using --no-ff.
  - Push all branches to GitHub.
