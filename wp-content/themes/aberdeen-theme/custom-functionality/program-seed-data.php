<?php
/**
 * Program Seed Data (Task 2 & 3 Data Seeder)
 *
 * Seeds 10 realistic programmes (5 Undergraduate & 5 Postgraduate)
 * with featured images, taxonomy terms, academic year, duration,
 * and repeater content sections.
 *
 * @package Aberdeen_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper to sideload a local theme image into WordPress Media Library
 *
 * @param string $filename Filename located in assets/images/
 * @param string $title Attachment title
 * @return int Attachment ID
 */
function aberdeen_import_theme_image_to_media( $filename, $title = '' ) {
	$file_path = get_template_directory() . '/assets/images/' . $filename;
	if ( ! file_exists( $file_path ) ) {
		return 0;
	}

	// Check if this attachment already exists in the media library
	$existing = get_posts( array(
		'post_type'      => 'attachment',
		'posts_per_page' => 1,
		'meta_query'     => array(
			array(
				'key'   => '_aberdeen_source_file',
				'value' => $filename,
			),
		),
	) );

	if ( ! empty( $existing ) ) {
		return $existing[0]->ID;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$wp_upload_dir = wp_upload_dir();
	$unique_filename = wp_unique_filename( $wp_upload_dir['path'], $filename );
	$new_file = $wp_upload_dir['path'] . '/' . $unique_filename;

	if ( ! copy( $file_path, $new_file ) ) {
		return 0;
	}

	$wp_filetype = wp_check_filetype( $unique_filename, null );
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title'     => ! empty( $title ) ? $title : sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	$attach_id = wp_insert_attachment( $attachment, $new_file );
	if ( ! is_wp_error( $attach_id ) && $attach_id > 0 ) {
		$attach_data = wp_generate_attachment_metadata( $attach_id, $new_file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		update_post_meta( $attach_id, '_aberdeen_source_file', $filename );
		return $attach_id;
	}

	return 0;
}

/**
 * Main function to seed 10 programs
 *
 * @return array Summary of created programs
 */
function aberdeen_seed_program_data() {
	// 1. Ensure Taxonomy Terms exist
	$ug_term = get_term_by( 'slug', 'undergraduate', 'program-type' );
	if ( ! $ug_term ) {
		$ug_res  = wp_insert_term( 'Undergraduate', 'program-type', array( 'slug' => 'undergraduate' ) );
		$ug_id   = ! is_wp_error( $ug_res ) ? $ug_res['term_id'] : 0;
	} else {
		$ug_id = $ug_term->term_id;
	}

	$pg_term = get_term_by( 'slug', 'postgraduate', 'program-type' );
	if ( ! $pg_term ) {
		$pg_res  = wp_insert_term( 'Postgraduate', 'program-type', array( 'slug' => 'postgraduate' ) );
		$pg_id   = ! is_wp_error( $pg_res ) ? $pg_res['term_id'] : 0;
	} else {
		$pg_id = $pg_term->term_id;
	}

	// 2. Prepare Media Attachments
	$img1_id = aberdeen_import_theme_image_to_media( 'home_cours1.jpg', 'Aberdeen Campus Computing' );
	$img2_id = aberdeen_import_theme_image_to_media( 'home_cours2.png', 'Aberdeen Engineering & Science' );
	$img3_id = aberdeen_import_theme_image_to_media( 'program_img.jpg', 'Aberdeen Modern Lecture Theatre' );
	$img4_id = aberdeen_import_theme_image_to_media( 'program_img2.jpg', 'Aberdeen Innovation Laboratory' );

	$img1_url = $img1_id ? wp_get_attachment_url( $img1_id ) : get_template_directory_uri() . '/assets/images/home_cours1.jpg';
	$img2_url = $img2_id ? wp_get_attachment_url( $img2_id ) : get_template_directory_uri() . '/assets/images/home_cours2.png';
	$img3_url = $img3_id ? wp_get_attachment_url( $img3_id ) : get_template_directory_uri() . '/assets/images/program_img.jpg';
	$img4_url = $img4_id ? wp_get_attachment_url( $img4_id ) : get_template_directory_uri() . '/assets/images/program_img2.jpg';

	// 3. Programmes Data Definition
	$programs = array(
		// ==========================================
		// UNDERGRADUATE (5 Programs)
		// ==========================================
		array(
			'title'         => 'Bachelor of Computer Applications (BCA)',
			'slug'          => 'bachelor-of-computer-applications',
			'term_id'       => $ug_id,
			'term_slug'     => 'undergraduate',
			'thumbnail_id'  => $img1_id,
			'academic_year' => '2025-26',
			'duration'      => '3 Years Full Time',
			'excerpt'       => 'A modern computing degree covering software engineering, cloud computing, artificial intelligence, and database architectures.',
			'content'       => '<p>The Bachelor of Computer Applications (BCA) at the University of Aberdeen is tailored to prepare future developers, software engineers, and IT leaders. Students engage in practical software design, modern web applications, distributed databases, and emerging cloud technologies.</p><p>With direct industry connections and dedicated programming labs, graduates leave equipped for immediate high-impact roles in modern tech environments.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_bca_overview',
					'title'       => 'Programme Overview & Objectives',
					'description' => 'Equips students with foundational and advanced principles of modern computing, algorithmic problem solving, and full-stack software development.',
					'image_id'    => $img1_id,
					'image_url'   => $img1_url,
				),
				array(
					'id'          => 'sec_bca_curriculum',
					'title'       => 'Core Curriculum & Practical Labs',
					'description' => 'Key modules include Object-Oriented Programming, Cloud Architecture, Database Systems, Web Engineering, and Software Testing.',
					'image_id'    => $img3_id,
					'image_url'   => $img3_url,
				),
				array(
					'id'          => 'sec_bca_careers',
					'title'       => 'Career Opportunities & Industry Placement',
					'description' => 'Graduates step into roles including Full-Stack Developer, Cloud Systems Analyst, Quality Assurance Engineer, and Data Analyst.',
					'image_id'    => $img4_id,
					'image_url'   => $img4_url,
				),
			),
		),
		array(
			'title'         => 'Bachelor of Engineering (B.E. in Software & Systems)',
			'slug'          => 'bachelor-of-engineering',
			'term_id'       => $ug_id,
			'term_slug'     => 'undergraduate',
			'thumbnail_id'  => $img2_id,
			'academic_year' => '2025-26',
			'duration'      => '4 Years Full Time',
			'excerpt'       => 'Accredited engineering program focused on scalable systems, robotics, high-performance computing, and cybersecurity.',
			'content'       => '<p>Our Bachelor of Engineering curriculum merges rigorous theoretical engineering principles with hands-on hardware and software integration. Students work on embedded architectures, real-time operating systems, distributed computing, and autonomous machine intelligence.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_be_excellence',
					'title'       => 'Engineering Excellence & Accreditation',
					'description' => 'Accredited by international engineering bodies, focusing on real-world engineering problem solving, sustainability, and scalable architectures.',
					'image_id'    => $img2_id,
					'image_url'   => $img2_url,
				),
				array(
					'id'          => 'sec_be_labs',
					'title'       => 'Hardware & Embedded Robotics Facilities',
					'description' => 'Access dedicated IoT prototyping suites, robotics test tracks, and advanced microprocessing simulation laboratories.',
					'image_id'    => $img4_id,
					'image_url'   => $img4_url,
				),
			),
		),
		array(
			'title'         => 'Bachelor of Business Administration (BBA)',
			'slug'          => 'bachelor-of-business-administration',
			'term_id'       => $ug_id,
			'term_slug'     => 'undergraduate',
			'thumbnail_id'  => $img3_id,
			'academic_year' => '2025-26',
			'duration'      => '3 Years Full Time',
			'excerpt'       => 'Develop executive leadership, strategic marketing, financial analysis, and entrepreneurial ventures in a global economy.',
			'content'       => '<p>The BBA program at Aberdeen provides a holistic understanding of how modern enterprises thrive in competitive global markets. From digital business models to corporate ethics and venture financing, students acquire crucial management acumen.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_bba_leadership',
					'title'       => 'Strategic Leadership & Case Studies',
					'description' => 'Engage in live corporate case studies examining business turnarounds, brand equity management, and organizational leadership.',
					'image_id'    => $img3_id,
					'image_url'   => $img3_url,
				),
				array(
					'id'          => 'sec_bba_internships',
					'title'       => 'Corporate Internships & Global Mentorship',
					'description' => 'Guaranteed summer internship placements with leading international firms, financial institutions, and innovative startups.',
					'image_id'    => $img1_id,
					'image_url'   => $img1_url,
				),
			),
		),
		array(
			'title'         => 'Bachelor of Science in Data Science (B.Sc. Data Science)',
			'slug'          => 'bsc-data-science',
			'term_id'       => $ug_id,
			'term_slug'     => 'undergraduate',
			'thumbnail_id'  => $img4_id,
			'academic_year' => '2025-26',
			'duration'      => '3 Years Full Time',
			'excerpt'       => 'Combines mathematics, statistical modeling, machine learning, and big data visualization to solve real-world problems.',
			'content'       => '<p>Data Science bridges computational power with mathematical insights. Students learn how to harvest, clean, analyze, and present complex datasets to drive evidence-based decisions across medicine, finance, and climate research.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_ds_analytics',
					'title'       => 'Predictive Analytics & Machine Intelligence',
					'description' => 'Master statistical packages (Python, R, SQL) and state-of-the-art predictive modeling frameworks.',
					'image_id'    => $img4_id,
					'image_url'   => $img4_url,
				),
				array(
					'id'          => 'sec_ds_ethics',
					'title'       => 'Data Governance & AI Ethics',
					'description' => 'Explore the social and legal ramifications of algorithmic fairness, privacy regulations, and responsible artificial intelligence.',
					'image_id'    => $img2_id,
					'image_url'   => $img2_url,
				),
			),
		),
		array(
			'title'         => 'Bachelor of Arts in Economics & Finance (B.A. Economics)',
			'slug'          => 'ba-economics-finance',
			'term_id'       => $ug_id,
			'term_slug'     => 'undergraduate',
			'thumbnail_id'  => $img1_id,
			'academic_year' => '2025-26',
			'duration'      => '3 Years Full Time',
			'excerpt'       => 'Rigorous training in microeconomics, econometrics, macroeconomic policy, and international financial markets.',
			'content'       => '<p>Examine how resources are allocated, how market dynamics unfold, and how government monetary and fiscal policies influence domestic and international prosperity.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_econ_quant',
					'title'       => 'Econometric Modeling & Quantitative Tools',
					'description' => 'Gain deep proficiency in econometric forecasting, macro-financial stability indicators, and economic theory.',
					'image_id'    => $img1_id,
					'image_url'   => $img1_url,
				),
			),
		),

		// ==========================================
		// POSTGRADUATE (5 Programs)
		// ==========================================
		array(
			'title'         => 'Master of Computer Applications (MCA)',
			'slug'          => 'master-of-computer-applications',
			'term_id'       => $pg_id,
			'term_slug'     => 'postgraduate',
			'thumbnail_id'  => $img2_id,
			'academic_year' => '2025-26',
			'duration'      => '2 Years Full Time',
			'excerpt'       => 'Advanced postgraduate degree in enterprise computing, distributed cloud systems, and applied machine learning.',
			'content'       => '<p>Designed for computing graduates and technical professionals, the MCA program focuses on scalable cloud architecture, microservices, enterprise cybersecurity, and deep predictive analytics.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_mca_advanced',
					'title'       => 'Advanced Cloud Architecture & DevOps',
					'description' => 'Design, deploy, and maintain resilient containerized distributed services using modern DevOps workflows.',
					'image_id'    => $img2_id,
					'image_url'   => $img2_url,
				),
				array(
					'id'          => 'sec_mca_thesis',
					'title'       => 'Master Research Thesis & Capstone',
					'description' => 'Work closely with academic researchers and industry partners on an innovative semester-long software capstone thesis.',
					'image_id'    => $img4_id,
					'image_url'   => $img4_url,
				),
			),
		),
		array(
			'title'         => 'Master of Engineering (M.E. in AI & Robotics)',
			'slug'          => 'master-of-engineering',
			'term_id'       => $pg_id,
			'term_slug'     => 'postgraduate',
			'thumbnail_id'  => $img1_id,
			'academic_year' => '2025-26',
			'duration'      => '2 Years Full Time',
			'excerpt'       => 'Cutting-edge research and hands-on systems engineering in autonomous vehicles, neural networks, and embedded robotics.',
			'content'       => '<p>The Master of Engineering in AI & Robotics provides postgraduate researchers with access to world-class robotics facilities, computer vision test beds, and neural network computing clusters.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_me_autonomous',
					'title'       => 'Autonomous Navigation & Computer Vision',
					'description' => 'Develop real-time perception algorithms and control pipelines for autonomous drones and mobile robotics.',
					'image_id'    => $img1_id,
					'image_url'   => $img1_url,
				),
				array(
					'id'          => 'sec_me_deeplearning',
					'title'       => 'Deep Reinforcement Learning & Simulation',
					'description' => 'Train robotic control policies using physics simulators and multi-agent reinforcement learning algorithms.',
					'image_id'    => $img3_id,
					'image_url'   => $img3_url,
				),
			),
		),
		array(
			'title'         => 'Master of Business Administration (MBA - Global Executive)',
			'slug'          => 'master-of-business-administration',
			'term_id'       => $pg_id,
			'term_slug'     => 'postgraduate',
			'thumbnail_id'  => $img3_id,
			'academic_year' => '2025-26',
			'duration'      => '2 Years Full Time',
			'excerpt'       => 'Transformative executive business education emphasizing sustainable leadership, corporate finance, and disruptive innovation.',
			'content'       => '<p>The Aberdeen Global Executive MBA empowers experienced leaders to navigate digital transformation, corporate finance, global supply chains, and board-level governance.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_mba_csuite',
					'title'       => 'C-Suite Strategy & Corporate Governance',
					'description' => 'Develop strategic foresight, shareholder value optimization frameworks, and high-performance team culture.',
					'image_id'    => $img3_id,
					'image_url'   => $img3_url,
				),
				array(
					'id'          => 'sec_mba_global',
					'title'       => 'International Immersion & Networking',
					'description' => 'Participate in international study tours visiting top innovation hubs across Europe, Asia, and North America.',
					'image_id'    => $img4_id,
					'image_url'   => $img4_url,
				),
			),
		),
		array(
			'title'         => 'Master of Science in Cybersecurity & Digital Forensics',
			'slug'          => 'msc-cybersecurity-digital-forensics',
			'term_id'       => $pg_id,
			'term_slug'     => 'postgraduate',
			'thumbnail_id'  => $img4_id,
			'academic_year' => '2025-26',
			'duration'      => '1 Year Full Time',
			'excerpt'       => 'Master ethical hacking, threat intelligence, cryptographic protocols, and incident response with government-grade standards.',
			'content'       => '<p>With cyber attacks growing in sophistication, this program delivers intensive training in penetration testing, malware reverse engineering, network forensics, and regulatory compliance.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_cyber_threats',
					'title'       => 'Threat Hunting & Ethical Hacking',
					'description' => 'Execute red team/blue team war games within isolated cyber range environments to test defensive postures.',
					'image_id'    => $img4_id,
					'image_url'   => $img4_url,
				),
				array(
					'id'          => 'sec_cyber_forensics',
					'title'       => 'Digital Evidence & Chain of Custody',
					'description' => 'Learn courtroom-admissible digital investigation methods, memory dump analysis, and forensic filesystem reconstruction.',
					'image_id'    => $img1_id,
					'image_url'   => $img1_url,
				),
			),
		),
		array(
			'title'         => 'Master of Science in International Business Management',
			'slug'          => 'msc-international-business-management',
			'term_id'       => $pg_id,
			'term_slug'     => 'postgraduate',
			'thumbnail_id'  => $img2_id,
			'academic_year' => '2025-26',
			'duration'      => '1 Year Full Time',
			'excerpt'       => 'Cross-border commercial strategy, geopolitical risk management, foreign market entry, and cross-cultural negotiations.',
			'content'       => '<p>Gain specialized knowledge in international trade law, transnational marketing, supply chain resilience, and global human resource management.</p>',
			'sections'      => array(
				array(
					'id'          => 'sec_ib_trade',
					'title'       => 'Cross-Border Operations & Trade Compliance',
					'description' => 'Analyze global trade pacts, tariff structures, currency exchange risk, and international logistics.',
					'image_id'    => $img2_id,
					'image_url'   => $img2_url,
				),
			),
		),
	);

	$results = array();

	foreach ( $programs as $prog ) {
		// Check if post already exists by slug
		$existing = get_page_by_path( $prog['slug'], OBJECT, 'program' );

		$post_data = array(
			'post_title'   => $prog['title'],
			'post_name'    => $prog['slug'],
			'post_content' => $prog['content'],
			'post_excerpt' => $prog['excerpt'],
			'post_status'  => 'publish',
			'post_type'    => 'program',
		);

		if ( $existing ) {
			$post_data['ID'] = $existing->ID;
			$post_id         = wp_update_post( $post_data );
			$action          = 'updated';
		} else {
			$post_id = wp_insert_post( $post_data );
			$action  = 'created';
		}

		if ( ! is_wp_error( $post_id ) && $post_id > 0 ) {
			// Set Taxonomy Term
			if ( ! empty( $prog['term_id'] ) ) {
				wp_set_object_terms( $post_id, array( (int) $prog['term_id'] ), 'program-type' );
			}

			// Set Featured Image
			if ( ! empty( $prog['thumbnail_id'] ) ) {
				set_post_thumbnail( $post_id, (int) $prog['thumbnail_id'] );
			}

			// Save Custom Meta
			update_post_meta( $post_id, '_program_academic_year', $prog['academic_year'] );
			update_post_meta( $post_id, 'academic_year', $prog['academic_year'] );

			update_post_meta( $post_id, '_program_duration', $prog['duration'] );
			update_post_meta( $post_id, 'duration', $prog['duration'] );

			update_post_meta( $post_id, '_program_content_sections', $prog['sections'] );
			update_post_meta( $post_id, 'content_sections', $prog['sections'] );

			$results[] = array(
				'id'       => $post_id,
				'title'    => $prog['title'],
				'slug'     => $prog['slug'],
				'category' => $prog['term_slug'],
				'action'   => $action,
			);
		}
	}

	return $results;
}
