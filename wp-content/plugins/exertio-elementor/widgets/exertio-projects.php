<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Exertio_Projects extends Widget_Base {
	
	public function get_name() {
		return 'exertio-projects';
	}
	
	public function get_title() {
		return __( 'Exertio Projects', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-library-open';
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

    public function get_customparant_terms($taxonomy)
    {
        $type = array();
        $terms = get_terms( array( 'taxonomy' => $taxonomy, 'parent' => 0, 'hide_empty' => 0 ));
        $type = ['all' => 'All'];
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) )
        {
            foreach ( $terms as $term ) {
                $type[$term->term_id] = $term->name . ' (' . $term->count . ')';
            }
        }
        return $type;
    }

	protected function register_controls() {
        $project_cats = $project_sk = $project_dur = $fl_type = $english_lev = $project_lev  = array();
        $project_categories = exertio_get_terms('project-categories');
        foreach($project_categories as $project_categorie)
        {
            $project_cats[$project_categorie->term_id] = $project_categorie->name;
        }

        $project_skills = exertio_get_terms('skills');
        foreach($project_skills as $project_skill)
        {
            $project_sk[$project_skill->term_id] = $project_skill->name;
        }

        $project_durations = exertio_get_terms('project-duration');
        foreach($project_durations as $project_duration)
        {
            $project_dur[$project_duration->term_id] = $project_duration->name;
        }

        $freelancer_types = exertio_get_terms('freelancer-type');
        foreach($freelancer_types as $freelancer_type)
        {
            $fl_type[$freelancer_type->term_id] = $freelancer_type->name;
        }

        $english_levels = exertio_get_terms('english-level');
        foreach($english_levels as $english_level)
        {
            $english_lev[$english_level->term_id] = $english_level->name;
        }

        $project_levels = exertio_get_terms('project-level');
        foreach($project_levels as $project_level)
        {
            $project_lev[$project_level->term_id] = $project_level->name;
        }
		
		$this->start_controls_section(
			'heading_section',
			[
				'label' => esc_html__( 'Section Heading', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Heading Text', 'exertio-elementor' ),
				'label_block' =>true,
				'placeholder' => __( 'Main Heading text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'heading_description',
			[
				'label' => __( 'Subtitle Here', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 4,
				'placeholder' => __( 'Type your description here', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'heading_style',
			[
				'label' => __( 'Heading Style', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'label_block' =>true,
				'options' => [
					'center'  => __( 'Center', 'exertio-elementor' ),
					'left' => __( 'Left', 'exertio-elementor' ),
				],
			]
		);
		$this->add_control(
			'heading_side_btn',
			[
				'label' => __( 'Want to show heading side button', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'label_block' =>true,
				'options' => [
					'yes'  => __( 'Yes', 'exertio-elementor' ),
					'no' => __( 'NO', 'exertio-elementor' ),
				],
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'heading_style',
                            'operator' => 'in',
                            'value' => [
                                'left',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'heading_side_btn_text',
			[
				'label' => __( 'Provide button text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
				'conditions' => [
                    'terms' => [
                        	[
                            'name' => 'heading_side_btn',
                            'operator' => 'in',
                            'value' => [
                                'yes',
                            ],
                        ],
						[
                            'name' => 'heading_style',
                            'operator' => 'in',
                            'value' => [
                                'left',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'heading_side_btn_link',
			[
				'label' => __( 'Provide button link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' =>true,
				'conditions' => [
					'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'heading_side_btn',
                            'operator' => 'in',
                            'value' => [
                                'yes',
                            ],
                        ],
						[
                            'name' => 'heading_style',
                            'operator' => 'in',
                            'value' => [
                                'left',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Exertio Projects', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'project_list_style',
			[
				'label' => __( 'Selecte Project List Style', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'list_1'  => __( 'List 1', 'exertio-elementor' ),
						'list_2'  => __( 'List 2', 'exertio-elementor' ),
						'list_3'  => __( 'List 3', 'exertio-elementor' ),
						'list_4'  => __( 'List 4', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
		$this->add_control(
			'projects_type',
			[
				'label' => __( 'Select Project Type', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'featured'  => __( 'Featured', 'exertio-elementor' ),
						'simple'  => __( 'Simple', 'exertio-elementor' ),
						'both'  => __( 'Both', 'exertio-elementor' ),
				],
				'label_block' => true
			]
        );
		$this->add_control(
			'projects_list_cols',
			[
				'label' => __( 'Lists in a Row', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'1'  => __( '1 in a row', 'exertio-elementor' ),
						'2'  => __( '2 in a row', 'exertio-elementor' ),
				],
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'project_list_style',
                            'operator' => 'in',
                            'value' => [
                                'list_1',
								'list_2',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'projects_count',
			[
				'label' => __( 'Number of Projects to show', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'2'  => __( '2', 'exertio-elementor' ),
						'4'  => __( '4', 'exertio-elementor' ),
						'6'  => __( '6', 'exertio-elementor' ),
						'8'  => __( '8', 'exertio-elementor' ),
						'10'  => __( '10', 'exertio-elementor' ),
						'12'  => __( '12', 'exertio-elementor' ),
						'14'  => __( '14', 'exertio-elementor' ),
						'16'  => __( '16', 'exertio-elementor' ),
						'18'  => __( '18', 'exertio-elementor' ),
						'20'  => __( '20', 'exertio-elementor' ),
						'22'  => __( '22', 'exertio-elementor' ),
						'24'  => __( '24', 'exertio-elementor' ),
						'26'  => __( '26', 'exertio-elementor' ),
						'28'  => __( '28', 'exertio-elementor' ),
						'30'  => __( '30', 'exertio-elementor' ),
						'32'  => __( '32', 'exertio-elementor' ),
						'34'  => __( '34', 'exertio-elementor' ),
						'36'  => __( '36', 'exertio-elementor' ),
						'38'  => __( '38', 'exertio-elementor' ),
						'40'  => __( '40', 'exertio-elementor' ),
						'45'  => __( '40', 'exertio-elementor' ),
						'50'  => __( '40', 'exertio-elementor' ),
						'-1'  => __( 'All', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
        $this->add_control(
            'list_one_select_tax',
            [
                'label' => __( 'Select Project Taxonomy', 'exertio-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'all',
                'options' => [
                    'pro_cat'  => __( 'Project category', 'exertio-elementor' ),
                    'pro_skills'  => __( 'Project skills', 'exertio-elementor' ),
                    'pro_dur'  => __( 'Project Duration', 'exertio-elementor' ),
                    'pro_fl_ty'  => __( 'Freelancer type', 'exertio-elementor' ),
                    'pro_eng'  => __( 'English level', 'exertio-elementor' ),
                    'pro_lev'  => __( 'Project level', 'exertio-elementor' ),
                ],
                'label_block' => true,
            ]
        );
        $this->add_control(
            'project_category',
            [
                'label' => __( 'Select Project Categories', 'exertio-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'all',
                'options' => $project_cats,
                'multiple' => true,
                'label_block' => true,
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_tax',
                            'operator' => 'in',
                            'value' => [ 'pro_cat', ],
                        ],
                    ],
                ]
            ]
        );
        $this->add_control(
            'freelancer_type',
            [
                'label' => __( 'Select Freelancer Type', 'exertio-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'all',
                'options' => $fl_type,
                'multiple' => true,
                'label_block' => true,
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_tax',
                            'operator' => 'in',
                            'value' => [ 'pro_fl_ty', ],
                        ],
                    ],
                ]
            ]
        );
        $this->add_control(
            'project_skills',
            [
                'label' => __( 'Select project Skills', 'exertio-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'all',
                'options' => $project_sk,
                'multiple' => true,
                'label_block' => true,
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_tax',
                            'operator' => 'in',
                            'value' => [ 'pro_skills', ],
                        ],
                    ],
                ]
            ]
        );
        $this->add_control(
            'project_duration',
            [
                'label' => __( 'Select Project duration', 'exertio-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'all',
                'options' => $project_dur,
                'label_block' => true,
                'multiple' => true,
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_tax',
                            'operator' => 'in',
                            'value' => [ 'pro_dur', ],
                        ],
                    ],
                ]
            ]
        );
        $this->add_control(
            'english_level',
            [
                'label' => __( 'Select English Level', 'exertio-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'all',
                'options' => $english_lev,
                'label_block' => true,
                'multiple' => true,
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_tax',
                            'operator' => 'in',
                            'value' => [ 'pro_eng', ],
                        ],
                    ],
                ]
            ]
        );
        $this->add_control(
            'project_level',
            [
                'label' => __( 'Select Project level', 'exertio-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'all',
                'options' => $project_lev,
                'label_block' => true,
                'multiple' => true,
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_tax',
                            'operator' => 'in',
                            'value' => [ 'pro_lev', ],
                        ],
                    ],
                ]
            ]
        );

		$this->end_controls_section();
		
			
	}
	
		protected function render() {
		$settings = $this->get_settings_for_display();
		
		$params['heading_text'] = $settings['heading_text'];
		$params['heading_description'] = $settings['heading_description'];
		$params['heading_style'] = $settings['heading_style'];
		$params['heading_side_btn'] = $settings['heading_side_btn'];
		$params['heading_side_btn_text'] = $settings['heading_side_btn_text'];
		$params['heading_side_btn_link'] = $settings['heading_side_btn_link'];
		$params['project_list_style'] = $settings['project_list_style'];
		$params['projects_type'] = $settings['projects_type'];
		$params['projects_count'] = $settings['projects_count'];
		$params['projects_list_cols'] = $settings['projects_list_cols'];
		$params['project_level'] = $settings['project_level'] ? $settings['project_level']:'all';
        $params['project_skills'] = $settings['project_skills']? $settings['project_skills']:'all';
        $params['english_level'] = $settings['english_level'] ? $settings['english_level']:'all';
        $params['freelancer_type'] = $settings['freelancer_type'] ? $settings['freelancer_type']:'all';
        $params['project_duration'] = $settings['project_duration'] ? $settings['project_duration']:'all';
        $params['project_category'] = $settings['project_category'] ? $settings['project_category']:'all';
			echo exertio_element_projects($params);
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
//	protected function content_template() {
//
//	}
}