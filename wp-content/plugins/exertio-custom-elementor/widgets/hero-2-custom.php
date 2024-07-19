<?php
namespace ElementorExertioCustom\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Hero_Two_Custom extends Widget_Base {
	
	public function get_name() {
		return 'hero-two-custom';
	}
	
	public function get_title() {
		return __( 'Hero Section 2 Custom', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-inner-section';
	}

	public function get_categories() {
		return [ 'exertio' ];
	}
	
	public function get_script_depends() {
		return [ '' ];
	}
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	 
	 
	protected function register_controls() {
		
		$location_taxonomies = exertio_get_terms('project-categories'); 

			foreach($location_taxonomies as $location_taxonomie)
			{
				$keyword[$location_taxonomie->term_id] = $location_taxonomie->name;
			}
		
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Hero Section two Content', 'exertio-elementor' ),
			]
		);
		// $this->add_control(
		// 	'post_type_select',
		// 	[
		// 		'label' => __( 'Used For', 'exertio-elementor' ),
		// 		'type' => \Elementor\Controls_Manager::SELECT2,
		// 		'multiple' => true,
		// 		'options' => exertio_cpt_array_hero_section(),
		// 		'label_block' => true
		// 	]
		// );
		$this->add_control(
			'sub_heading_text',
			[
				'label' => __( 'Sub Heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide the sub heading text', 'exertio-elementor' ),
				'rows' => 3,
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Main Heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide the main title', 'exertio-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'Provide the main title', 'exertio-elementor' ),
			]
		);

		$this->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'placeholder' => __( 'Type your description here', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'search_field_switch',
			[
				'label' => __( 'Want to show search field?', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'0'  => __( 'No', 'exertio-elementor' ),
						'1'  => __( 'Yes', 'exertio-elementor' ),

				],
				'label_block' => true
			]
		);
		$this->add_control(
			'search_field_placeholder_text',
			[
				'label' => __( 'Search Field placeholder text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Search Field placeholder text', 'exertio-elementor' ),
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'search_field_switch',
                            'operator' => 'in',
                            'value' => [
                                '1',
                            ],
                        ],
                    ],
                ]
			]
		);
		// $this->add_control(
		// 	'select_placeholder_text',
		// 	[
		// 		'label' => __( 'Select Field placeholder text', 'exertio-elementor' ),
		// 		'type' => \Elementor\Controls_Manager::TEXT,
		// 		'placeholder' => __( 'Select Field placeholder text', 'exertio-elementor' ),
		// 		'label_block' => true,
		// 		'conditions' => [
        //             'terms' => [
        //                 [
        //                     'name' => 'search_field_switch',
        //                     'operator' => 'in',
        //                     'value' => [
        //                         '1',
        //                     ],
        //                 ],
        //             ],
        //         ]
		// 	]
		// );
		$this->add_control(
			'search_btn_title',
			[
				'label' => __( 'Search Button Title', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'exertio-elementor' ),
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'search_field_switch',
                            'operator' => 'in',
                            'value' => [
                                '1',
                            ],
                        ],
                    ],
                ]
			]
		);
	
		$this->add_control(
			'video_heading_title',
			[
				'label' => __( 'Video button heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Video button heading here', 'exertio-elementor' ),
				'label_block' => true
			]
		);		$this->add_control(
			'video_desc',
			[
				'label' => __( 'Video Description area', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Provide Video description text', 'exertio-elementor' ),
				'label_block' => true
			]
		);
		
		$this->add_control(
			'video_link',
			[
				'label' => __( 'Video Link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'provide video link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'keyword_section',
			[
				'label' => esc_html__( 'Keyword section', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'keyword_titles',
			[
				'label' => __( 'Keyword area title', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'This will be only title', 'exertio-elementor' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'keyword_selection',
			[
				'label' => __( 'Select Keywords (separated by | Sign)', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'You can give multiple keywords separated by | Sign', 'exertio-elementor' ),
				'label_block' => true
			]
		);
		// $this->add_control(
		// 	'keyword_post_type',
		// 	[
		// 		'label' => __( 'Used For', 'exertio-elementor' ),
		// 		'type' => \Elementor\Controls_Manager::SELECT2,
		// 		'options' => exertio_cpt_array_hero_section(),
		// 		'label_block' => true
		// 	]
		// );
		$this->end_controls_section();
			
	}
	
		protected function render() {
		$settings = $this->get_settings_for_display();
		
		$params['post_type_select'] = $settings['post_type_select'];
		$params['sub_heading_text'] = $settings['sub_heading_text'];
		$params['heading_text'] = $settings['heading_text'];
		
		$params['item_description'] = $settings['item_description'];
		$params['search_field_placeholder_text'] = $settings['search_field_placeholder_text'];
		//$params['select_placeholder_text'] = $settings['select_placeholder_text'];
		$params['search_btn_title'] = $settings['search_btn_title'];
		$params['search_field_switch'] = $settings['search_field_switch'];
		
		$params['video_heading_title'] = $settings['video_heading_title'];
		$params['video_desc'] = $settings['video_desc'];
		$params['video_link'] = $settings['video_link'];
		$params['video_link']['is_external'] = $settings['video_link']['is_external'];
		$params['video_link']['nofollow'] = $settings['video_link']['nofollow'];
			
		$params['keyword_titles'] = $settings['keyword_titles'];
		$params['keyword_selection'] = $settings['keyword_selection'];
		//ssssssssssss$params['keyword_post_type'] = $settings['keyword_post_type'];
     



        	$sec_btn = $main_btn = $desc = $main_heading = $post_type_links = $placehoder_text = $select_placeholder_text = $search_btn_title = $keyword_titles = $video_heading_title = $video_desc = $video_link = $keyword_selection = $keywords = $sub_heading = $keyword_link = $action = '';

		if ( !empty( $params[ 'heading_text' ] ) ) {
		  $main_heading = '<h1>' . $params[ 'heading_text' ] . '</h1>';
		}
		if ( !empty( $params[ 'sub_heading_text' ] ) ) {
		  $sub_heading = '<span>' . $params[ 'sub_heading_text' ] . '</span>';
		}
		if ( !empty( $params[ 'item_description' ] ) ) {
		  $desc = '<p> ' . $params[ 'item_description' ] . ' </p>';
		}
		if ( !empty( $params[ 'search_field_placeholder_text' ] ) ) {
		  $placehoder_text = $params[ 'search_field_placeholder_text' ];
		}
		if ( !empty( $params[ 'select_placeholder_text' ] ) ) {
		  $select_placeholder_text = $params[ 'select_placeholder_text' ];
		}
		if ( !empty( $params[ 'search_btn_title' ] ) ) {
		  $search_btn_title = $params[ 'search_btn_title' ];
		}
		if ( !empty( $params[ 'keyword_titles' ] ) ) {
		  $keyword_titles = $params[ 'keyword_titles' ];
		}
		if ( !empty( $params[ 'video_heading_title' ] ) ) {
		  $video_heading_title = $params[ 'video_heading_title' ];
		}
		if ( !empty( $params[ 'video_desc' ] ) ) {
		  $video_desc = $params[ 'video_desc' ];
		}
		if ( !empty( $params[ 'video_link' ] ) ) {
		  $video_link = $params[ 'video_link' ];
		}

		$action = $action = get_the_permalink(fl_framework_get_options('services_search_page'));
		


		if ( !empty( $params[ 'video_link' ] ) && is_array( $params[ 'video_link' ] ) ) {
		  $target = $params[ 'video_link' ][ 'is_external' ] ? ' target="_blank"' : '';
		  $nofollow = $params[ 'video_link' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
		  $video_link = '<a href="' . esc_url( $params[ 'video_link' ][ 'url' ] ) . '" ' . $target . $nofollow . ' class="popup-video"><i class="fa fa-play" aria-hidden="true"></i></a>';
		}


		/*KEYWORD POST TYPE*/
		//$keyword_post_type = $params[ 'keyword_post_type' ];
		 $keyword_link = get_the_permalink( fl_framework_get_options( 'services_search_page' ) );
		
		
		$keyword_selection = $params[ 'keyword_selection' ];
		if ( !empty( $keyword_selection ) ) {
		  $keyword_parts = explode( "|", $keyword_selection );

		  foreach ( $keyword_parts as $keyword_part ) {
			$keywords .= "<a href='" . $keyword_link . "?title=" . $keyword_part . "'>" . $keyword_part . "</a>";
		  }
		}
		$search_field_toggle = $params['search_field_switch'];
		if(isset($search_field_toggle) && $search_field_toggle == 1)
		{
			$search_form = '<div class="fr-hero3-srch">
									<form class="hero-one-form" action="'.esc_url($action).'">
									 
										  <div class="form-group" style="margin-bottom: 0; background-color: white;">
											<input type="text" placeholder="' . $placehoder_text . '" class="form-control" style="background-color: white; height: 60px;
											border-radius: 0;
											color: #777;
											border-left: 2px solid #fe696a !important;
											border: none;
											padding: 25px;
											" name="title">
										  </div>
										
										  <div class="form-group" style="margin-bottom: 0; background-color: white;">
										
											<div class="fr-hero3-submit  fr-custom-submit" style="top: -54px;"> <button class="btn btn-theme"><i class="fa fa-search-plus"></i>' . $search_btn_title . '</button> </div>
										  </div>
									
									</form>
								  </div>';
		}
		else
		{
			$search_form = '';
		}
		echo '<section class="fr-hero3 herosection-2">
				  <div class="container">
					<div class="row">
						<div class="col-xl-7 col-12 col-sm-12 col-lg-7 col-md-8">
							<div class="fr-hero3-main">
							  <div class="fr-hero3-content">
								' . $sub_heading . '
								' . $main_heading . '
								' . $desc . '
							  </div>
							  '.$search_form.'
								<div class="fr-her3-elemnt">
									<p>' . $keyword_titles . '</p>
									' . $keywords . '	
								</div>
							</div>
							<div class="fr-hero3-video">
							  <div class="fr-hero3-text"> <span>' . $video_heading_title . '</span>
								<p>' . $video_desc . '</p>
							  </div>
							  ' . $video_link . '
							</div>
						</div>
					</div>
				  </div>
				</section>';


				echo '<style>
				.fr-hero3-srch input {
					height: 60px;
					border-radius: 0;
					color: #777;
					border-left: 2px solid #fe696a !important;
					border: none;
					  border-left-color: currentcolor;
					  border-left-style: none;
					  border-left-width: medium;
					padding: 25px;
					background-color: #FFF;
				  }


				@media (max-width: 578px) {
					.hero-one-form .fr-custom-submit {	
						top: 0px !important;
					}
					.hero-one-form .form-control {
						background-color: #f4f6f9 !important; 
					}
					.fr-hero3-srch input {
						background-color: #f4f6f9;
						border-radius: 4px !important;
					  }

					  .fr-hero3-srch input {
						height: 60px;
						border-radius: 0;	
						color: #777;
						border-left: 2px solid #fe696a !important;
						border: none;
						  border-left-color: currentcolor;
						  border-left-style: none;
						  border-left-width: medium;
						padding: 25px;
						background-color: #FFF;
					  }
				  }
                </style>';

			
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() )
			{
				?>
				<script>
					jQuery('.default-select').select2();
				</script>

				<?php
			}
		}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function content_template() {
			
	}
}