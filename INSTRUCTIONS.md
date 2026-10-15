HOW TO TEST THE PROJECT: STEP-BY-STEP TESTING GUIDE
===================================================

This guide gives simple, step-by-step instructions for anyone reviewing the project.
Follow each step below to test all features.

---------------------------------------------------
PREREQUISITES: INITIAL SETUP
---------------------------------------------------

1. Theme and Plugin Activation:
   - In WordPress admin, go to Appearance > Themes and activate Aberdeen University Theme.
   - Go to Plugins and activate Aberdeen Programs Module.

2. Permalinks:
   - Go to Settings > Permalinks and click Save Changes once.

3. Sample Data:
   - Go to Programmes > All Programmes in the admin. You will see 10 pre-loaded programmes (5 Undergraduate and 5 Postgraduate).

---------------------------------------------------
STEP 1: TEST HOMEPAGE AND ENQUIRY MODAL
---------------------------------------------------

Page URL: http://localhost/Aberdeen/

How to test:
1. Header and Navigation:
   - Check the top header for the university logo, navigation menu links, and the yellow "Apply Now" button.
   - Click the "University of Aberdeen UK" link on the sub-bar to confirm it works.

2. Hero Section:
   - Check the hero slider with background images and text.
   - Click the left and right navigation arrows to cycle through slides.

3. Careers Section:
   - Scroll down to the Careers and Employability section with image and description.
   - Click "See More" button to test interaction.

4. Programmes Tracks:
   - Check the Undergraduate and Postgraduate track cards.
   - Click "See More" on either track to navigate to its programmes list.

5. Footer:
   - Check the footer for university contact details, social media links, and bottom policy links.

6. Lead Form Popup Modal:
   - Click any "Apply Now" or "Enquire Now" button on the page.
   - The enquiry modal will open smoothly without reloading the page.
   - Fill in the form fields (name, email, phone, country, programme of interest).
   - Click "Submit Enquiry".
   - Verify that the green "Thank You" message appears on screen.

---------------------------------------------------
STEP 2: TEST ALL PROGRAMMES AND INSTANT FILTER
---------------------------------------------------

Page URL: http://localhost/Aberdeen/programmes/

How to test:
1. Category Filter Tabs:
   - Notice the three filter tabs at the top: All Programmes, Undergraduate, and Postgraduate.
   - Click "Undergraduate": The page updates immediately to show only Undergraduate courses without reloading the browser. Notice the address bar changes to /programmes/undergraduate.
   - Click "Postgraduate": The list immediately switches to Postgraduate courses.
   - Click "All Programmes": The full list reappears, grouped into sections.

2. Reusable Programme Cards:
   - Check each card: it displays the featured image, academic year badge (e.g. 2025-26), duration badge (e.g. 3 Years Full Time), and the programme title.
   - Hover over the title and click it to open the single programme detail page.

3. No-JavaScript Fallback:
   - The filter tabs are regular HTML links. If JavaScript is turned off in browser settings, clicking tabs still navigates cleanly to that category page.

---------------------------------------------------
STEP 3: TEST CATEGORY ARCHIVE PAGE (DESKTOP P2 LAYOUT)
---------------------------------------------------

Page URL: http://localhost/Aberdeen/programmes/undergraduate/

How to test:
1. Open the Undergraduate archive URL directly.
2. Verify the blue banner title: Undergraduate Programmes.
3. Check the 2-column programme cards:
   - Each card dynamically pulls data from the database with image, title, and overview text.
4. Click on any programme card image or title: it opens the individual programme page.

---------------------------------------------------
STEP 4: TEST SINGLE PROGRAMME DETAIL PAGE
---------------------------------------------------

Page URL: http://localhost/Aberdeen/programmes/bachelor-of-computer-applications/

How to test:
1. Breadcrumb Navigation:
   - Check the breadcrumb bar at the top: Home / Programmes / Undergraduate / [Programme Title].
   - Click the links to test navigating back.

2. Hero Information:
   - Notice the metadata badges: Programme Type, Academic Year, and Duration.
   - Click "Apply Now" to verify the modal popup opens.

3. Dynamic Curriculum Sections:
   - Scroll down to review the content highlights and curriculum blocks.
   - These sections are generated dynamically from the admin repeater.

4. Schema.org SEO Check:
   - Right-click anywhere on the page and select "View Page Source".
   - Press Ctrl + F and search for "application/ld+json".
   - Confirm that the Course Schema structured data is present with course name, duration, and university details.

---------------------------------------------------
STEP 5: TEST REACT ADMIN REPEATER IN WORDPRESS
---------------------------------------------------

Admin URL: http://localhost/Aberdeen/wp-admin/edit.php?post_type=program

How to test:
1. Log in to WordPress Admin and click "Programmes" in the sidebar.
2. Click "Edit" on any programme (for example: Bachelor of Computer Applications).
3. Scroll down below the main content area to find the "Programme Details" box:
   - Edit the Academic Year (e.g. 2025-26).
   - Edit the Duration (e.g. 3 Years Full Time).
4. Find the "Curriculum Sections (Repeater)" box:
   - Click "+ Add New Section" to add a new curriculum block.
   - Click "Upload Image" to select an image from the WordPress Media Library.
   - Type a title and description.
   - Click the Up or Down arrow buttons to change the order of sections.
   - Click a section header to expand or collapse it.
   - Click "Remove" to delete a section.
5. Click the blue "Update" button on the top right.
6. Refresh the frontend programme page to verify your new curriculum blocks appear immediately.

---------------------------------------------------
STEP 6: TEST CLICK TRACKING AND SECURITY
---------------------------------------------------

How to test:
1. Trigger Tracking:
   - Open any frontend page (e.g. http://localhost/Aberdeen/programmes/).
   - Click a programme card, a filter tab, or the "Apply Now" button.
2. Check the Log File:
   - Open this file in your editor:
     wp-content/uploads/logs/data-track.log
   - Scroll to the bottom of the file. You will see a new line added with the timestamp, page URL, and clicked element details.
3. Verify Security Rule:
   - Try visiting the log file directly in your browser:
     http://localhost/Aberdeen/wp-content/uploads/logs/data-track.log
   - You will see a 403 Forbidden page. The .htaccess file prevents direct public downloads of the log.

---------------------------------------------------
STEP 7: VERIFY GIT BRANCHES
---------------------------------------------------

To review the git history and branches in your terminal:
  git branch -a
  git log --oneline -5

Branch structure:
- feature/cpt-setup: Custom Post Type, taxonomy, and meta fields.
- feature/theme-setup: Theme templates, frontend filter, modal, and tracking.
- dev: Development branch where features were merged.
- uat: User acceptance testing branch.
- main: Final production release branch.

---------------------------------------------------
KEY FILES REFERENCE
---------------------------------------------------

If you want to inspect the code files:
- Reusable Card Component: wp-content/themes/aberdeen-theme/template-parts/program-card.php
- Card Helper Function: wp-content/themes/aberdeen-theme/functions.php
- Instant Category Filter: wp-content/themes/aberdeen-theme/assets/js/interactivity-filter.js
- Homepage Template: wp-content/themes/aberdeen-theme/front-page.php
- All Programmes Archive: wp-content/themes/aberdeen-theme/archive-program.php
- Category Archive Template (P2): wp-content/themes/aberdeen-theme/taxonomy-program-type.php
- Single Programme Page: wp-content/themes/aberdeen-theme/single-program.php
- Enquiry Modal: wp-content/themes/aberdeen-theme/template-parts/modal-lead-form.php
- React Admin Repeater: wp-content/plugins/programs-module/assets/js/admin-repeater.js
- Click Tracking and Security: wp-content/plugins/programs-module/includes/click-tracking.php
- Log File: wp-content/uploads/logs/data-track.log
