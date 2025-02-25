<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Hero_One extends Widget_Base {
	
	public function get_name() {
		return 'hero-one';
	}
	
	public function get_title() {
		return __( 'Hero Section 1', 'exertio-elementor' );
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

		$keyword = array();
		foreach($location_taxonomies as $location_taxonomie)
		{
			$keyword[$location_taxonomie->term_id] = $location_taxonomie->name;
		}

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Hero Section one Content', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'post_type_select',
			[
				'label' => __( 'Used For', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => exertio_cpt_array_hero_section(),
				'label_block' => true
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
		$this->add_control(
			'select_placeholder_text',
			[
				'label' => __( 'Select Field placeholder text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Select Field placeholder text', 'exertio-elementor' ),
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
				'label' => __( 'Select Keywords', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $keyword,
				'label_block' => true
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
		);
		
		$this->add_control(
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
			'images_block',
			[
				'label' => __( 'Brand Images and Links', 'exertio-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'left_image_1',
			[
				'label' => __( 'Left part Image 1', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'left_image_1_url',
			[
				'label' => __( 'Left part Image 1 URL', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'provide link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'left_image_2',
			[
				'label' => __( 'Left part Image 2', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'left_image_2_url',
			[
				'label' => __( 'Left part Image 2 URL', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'provide link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'left_image_3',
			[
				'label' => __( 'Left part Image 3', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'left_image_3_url',
			[
				'label' => __( 'Left part Image 3 URL', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'provide link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'right_image_1',
			[
				'label' => __( 'Right part Image 1', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'right_image_1_url',
			[
				'label' => __( 'Right part Image 1 URL', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'provide link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'right_image_2',
			[
				'label' => __( 'Right part Image 2', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'right_image_2_url',
			[
				'label' => __( 'Right part Image 2 URL', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'provide link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'right_image_3',
			[
				'label' => __( 'Right part Image 3', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'right_image_3_url',
			[
				'label' => __( 'Right part Image 3 URL', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'provide link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->end_controls_section();
		
			
	}
	
		protected function render() {
		$settings = $this->get_settings_for_display();
		
		$params['post_type_select'] = $settings['post_type_select'];
		$params['heading_text'] = $settings['heading_text'];
		
		$params['item_description'] = $settings['item_description'];
		$params['search_field_placeholder_text'] = $settings['search_field_placeholder_text'];
		$params['select_placeholder_text'] = $settings['select_placeholder_text'];
		$params['search_btn_title'] = $settings['search_btn_title'];
		$params['keyword_titles'] = $settings['keyword_titles'];
		$params['keyword_selection'] = $settings['keyword_selection'];
		$params['search_field_switch'] = $settings['search_field_switch'];
		$params['video_heading_title'] = $settings['video_heading_title'];
		$params['video_desc'] = $settings['video_desc'];
		$params['video_link'] = $settings['video_link'];
		$params['video_link']['is_external'] = $settings['video_link']['is_external'];
		$params['video_link']['nofollow'] = $settings['video_link']['nofollow'];
		
		
		
		$params['left_image_1'] = $settings['left_image_1'];
		$params['left_image_1_url'] = $settings['left_image_1_url'];
		$params['left_image_1_url']['is_external'] = $settings['left_image_1_url']['is_external'];
		$params['left_image_1_url']['nofollow'] = $settings['left_image_1_url']['nofollow'];
		
		
		$params['left_image_2'] = $settings['left_image_2'];
		$params['left_image_2_url'] = $settings['left_image_2_url'];
		$params['left_image_2_url']['is_external'] = $settings['left_image_2_url']['is_external'];
		$params['left_image_2_url']['nofollow'] = $settings['left_image_2_url']['nofollow'];
		
		
		$params['left_image_3'] = $settings['left_image_3'];
		$params['left_image_3_url'] = $settings['left_image_3_url'];
		$params['left_image_3_url']['is_external'] = $settings['left_image_3_url']['is_external'];
		$params['left_image_3_url']['nofollow'] = $settings['left_image_3_url']['nofollow'];
		
		
		$params['right_image_1'] = $settings['right_image_1'];
		$params['right_image_1_url'] = $settings['right_image_1_url'];
		$params['right_image_1_url']['is_external'] = $settings['right_image_1_url']['is_external'];
		$params['right_image_1_url']['nofollow'] = $settings['right_image_1_url']['nofollow'];
		
		
		$params['right_image_2'] = $settings['right_image_2'];
		$params['right_image_2_url'] = $settings['right_image_2_url'];
		$params['right_image_2_url']['is_external'] = $settings['right_image_2_url']['is_external'];
		$params['right_image_2_url']['nofollow'] = $settings['right_image_2_url']['nofollow'];
		
		
		$params['right_image_3'] = $settings['right_image_3'];
		$params['right_image_3_url'] = $settings['right_image_2_url'];
		$params['right_image_3_url']['is_external'] = $settings['right_image_3_url']['is_external'];
		$params['right_image_3_url']['nofollow'] = $settings['right_image_3_url']['nofollow'];
		
			echo exertio_element_hero_one($params);
			
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