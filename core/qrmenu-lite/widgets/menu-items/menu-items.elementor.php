<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class QRlite_Menu_Items extends \Elementor\Widget_Base { 
   /**
	 * Get widget name.
	 *
	 * Retrieve Card widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */

	public function get_name() {
		return 'menu items';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Card widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'QRlite - Menu Items', 'qrlite' );
	}

    /**
	 * Get widget icon.
	 *
	 * Retrieve Card widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-table-of-contents';
	}

    /**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://www.modeltheme.com/';
	}

    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Card widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Card widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'qrlite', 'menu', 'items' ];
	}

	public function get_link() {
		return 'link';
	}
    /**
	 * Register Card widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */

	protected function register_controls() { 
		// our control function code goes here.
		$this->start_controls_section(
			'version_section',
			[
				'label' => esc_html__( 'Menu Settings', 'qrlite' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'version',
			[
				'label' => esc_html__( 'Version', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'v1',
				'options' => [
					'v1' => esc_html__( 'v1', 'qrlite' ),
					'v2'  => esc_html__( 'v2', 'qrlite' ),
					'v3'  => esc_html__( 'v3', 'qrlite' ),
				],
			]
		);
		$this->add_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'1' => esc_html__( '1', 'qrlite' ),
					'2'  => esc_html__( '2', 'qrlite' ),
					'3'  => esc_html__( '3', 'qrlite' ),
				],
			]
		);
		$this->add_control(
			'layout_display',
			[
				'label' => esc_html__( 'Layout', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex',
				'options' => [
					'flex' => esc_html__( 'List', 'qrlite' ),
					'block'  => esc_html__( 'Grid', 'qrlite' ),
				],
			]
		);
		$this->add_control(
			'alignment',
			[
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label' => esc_html__( 'Content Alignment', 'qrlite' ),
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'qrlite' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'qrlite' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'qrlite' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Menu Items', 'qrlite' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'item_type',
			[
				'label' => esc_html__( 'Item Type', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'product',
               'options' => [
                 'product' => esc_html__( 'Custom Item', 'qrlite' ),
                 'heading' => esc_html__( 'Heading', 'qrlite' ),
				],
			]
		);
		$repeater->add_control(
			'dish_heading',
			[
				'label' => esc_html__( 'Dish Heading', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Your heading goes here.', 'qrlite' ),
				'condition' => [
					'item_type' => 'heading',
				],
			],
		);
		$repeater->add_control(
			'dish_image',
			[
				'label' => esc_html__( 'Image', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'item_type' => 'product',
				],
			]
		);
		$repeater->add_control(
			'dish_title',
			[
				'label' => esc_html__( 'Dish Title', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Your description goes here.', 'qrlite' ),
				'default' => 'Greek Salad',
				'condition' => [
					'item_type' => 'product',
				],
			],
		);
		$repeater->add_control(
			'dish_price',
			[
				'label' => esc_html__( 'Dish Price', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Dish Price goes here.', 'qrlite' ),
				'default' => '25.50',
				'condition' => [
					'item_type' => 'product',
				],
			],
		);
		$repeater->add_control(
			'dish_sale_price',
			[
				'label' => esc_html__( 'Dish Sale Price', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Dish Sale Price goes here.', 'qrlite' ),
				'default' => '25.50',
				'condition' => [
					'item_type' => 'product',
				],
			],
		);
		$repeater->add_control(
			'dish_description',
			[
				'label' => esc_html__( 'Dish Description', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Dish Description goes here.', 'qrlite' ),
				'default' => esc_html__( 'Tomatoes, green bell pepper, sliced cucumber onion, olives and feta cheese.', 'qrlite' ),
				'condition' => [
					'item_type' => 'product',
				],
			],
		);
		$repeater->add_control(
			'preparation_time',
			[
				'label' => esc_html__( 'Dish Preparation Time', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Your description goes here.', 'qrlite' ),
				'condition' => [
					'item_type' => 'product',
				],
			],
		);
		$repeater->add_control(
			'out_of_stock',
			[
				'label' => esc_html__( 'Out of Stock', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'qrlite' ),
				'label_off' => esc_html__( 'Hide', 'qrlite' ),
				'return_value' => 'yes',
				'default' => 'no'
			]
		);
		$repeater->add_control(
			'hide_menu',
			[
				'label' => esc_html__( 'Hide menu', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'qrlite' ),
				'label_off' => esc_html__( 'No', 'qrlite' ),
				'return_value' => 'yes',
				'default' => 'no'
			]
		);
		$repeater->add_control(
			'cart_toggle',
			[
				'label' => esc_html__( '"Add to cart" button', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'qrlite' ),
				'label_off' => esc_html__( 'Hide', 'qrlite' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'item_type' => 'product',
				],
			]
		);
		$repeater->add_control(
			'dish_promotion',
			[
				'label' => esc_html__( 'Dish Promotion', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Recommended', 'qrlite' ),
				'condition' => [
					'dish_toggle' => 'yes',
					'item_type' => 'product'
				],
			]
		);
		$repeater->add_control(
			'default_heading_badge',
			[
				'label' => esc_html__( 'Badges', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'item_type' => 'product',
				],
			]
		);
		
		$repeater->add_control(
			'default_heading_nutritional',
			[
				'label' => esc_html__( 'Nutritional Info', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'item_type' => 'product',
				],
			]
		);
		$repeater->add_control(
			'grams',
			[
				'label' => esc_html__( 'Total Grams (Gr.)', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Grams go here.', 'qrlite' ),
				'default' => '600',
			],
		);
		$repeater->add_control(
			'calories',
			[
				'label' => esc_html__( 'Total Calories (Cal.)', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Calories go here.', 'qrlite' ),
				'default' => '300',
			],
		);
		$repeater->add_control(
			'fat',
			[
				'label' => esc_html__( 'Total Fat (g)', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Fat go here.', 'qrlite' ),
				'default' => '9',
			],
		);
		$repeater->add_control(
			'carbs',
			[
				'label' => esc_html__( 'Total Carbs (g)', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Carbs go here.', 'qrlite' ),
				'default' => '12',
			],
		);
		$repeater->add_control(
			'proteins',
			[
				'label' => esc_html__( 'Total Protein (g)', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Proteins go here.', 'qrlite' ),
				'default' => '15',
			],
		);
		$this->add_control( 
	        'tab1',
	        [
	            'label' => esc_html__('Menu Items', 'qrlite'),
	            'type' => \Elementor\Controls_Manager::REPEATER,
	            'fields' => $repeater->get_controls(),
	            'default' => [
					[
						'dish_heading' => esc_html__( 'APPETIZERS', 'qrlite' ),
						'dish_title' => esc_html__( 'Greek Salad', 'qrlite' ),
						'dish_price' => esc_html__( '$25.50', 'qrlite' ),
						'dish_description' => esc_html__( 'Tomatoes, green bell pepper, sliced cucumber onion, olives, and feta cheese.', 'qrlite' ),
					],
					[
						'dish_heading' => esc_html__( 'MAINS', 'qrlite' ),
						'dish_title' => esc_html__( 'Lasagne', 'qrlite' ),
						'dish_price' => esc_html__( '$40.00', 'qrlite' ),
						'dish_description' => esc_html__( 'Vegetables, cheeses, ground meats, tomato sauce, seasonings and spices.', 'qrlite' ),
					],
					[
						'dish_heading' => esc_html__( 'EXTRAS', 'qrlite' ),
						'dish_title' => esc_html__( 'Butternut Pumpkin', 'qrlite' ),
						'dish_price' => esc_html__( '$30.55', 'qrlite' ),
						'dish_description' => esc_html__( 'Typesetting industry simply dummy Ipsum is simply dummy text of the priands.', 'qrlite' ),
					],
					[
						'dish_heading' => esc_html__( 'SODAS', 'qrlite' ),
						'dish_title' => esc_html__( 'Tokusen Wagyu', 'qrlite' ),
						'dish_price' => esc_html__( '$39.00', 'qrlite' ),
						'dish_description' => esc_html__( 'Vegetables, cheeses, ground meats, tomato sauce, seasonings and spices.', 'qrlite' ),
					],
					[
						'dish_heading' => esc_html__( 'WINES', 'qrlite' ),
						'dish_title' => esc_html__( 'Opu Fish', 'qrlite' ),
						'dish_price' => esc_html__( '$40.00', 'qrlite' ),
						'dish_description' => esc_html__( 'Avocados with crab meat, red onion, crab salad stuffed red bell pepper and green bell pepper.', 'qrlite' ),
					],
					[
						'dish_heading' => esc_html__( 'COCKTAILS', 'qrlite' ),
						'dish_title' => esc_html__( 'Olivas Rellenas', 'qrlite' ),
						'dish_price' => esc_html__( '$30.55', 'qrlite' ),
						'dish_description' => esc_html__( 'Vegetables, cheeses, ground meats, tomato sauce, seasonings and spices.', 'qrlite' ),
					],
				],
	        ]
	    );
		$this->end_controls_section();
		$this->start_controls_section(
			'content_style',
			[
				'label' => esc_html__( 'Menu Styling', 'qrlite' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .qrlite-menu-items-container',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Heading Tipography', 'qrlite' ),
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .qrlite-menu-items-inner-heading',
			]
		);
		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .qrlite-menu-items-inner-heading' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[	'label' => esc_html__( 'Title Tipography', 'qrlite' ),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .qrlite-menu-items-title',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .qrlite-menu-items-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Price Tipography', 'qrlite' ),
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .qrlite-menu-items-price',
			]
		);
		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Price Color', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .qrlite-menu-items-price' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Description Tipography', 'qrlite' ),
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .qrlite-menu-items-description',
			]
		);
		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Description Color', 'qrlite' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .qrlite-menu-items-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

    /**
	 * Render Card widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() { 
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		// get the individual values of the input
		$tab1 = $settings['tab1'];
		$version = $settings['version'];
		$columns = $settings['columns'];
		$alignment = $settings['alignment'];
		$layout_display = $settings['layout_display'];

		echo esc_html(do_shortcode('[qrlite-menu-items tab1="'.base64_encode(serialize($tab1)).'" version="'.esc_attr($version).'" columns="'.esc_attr($columns).'" alignment="'.esc_attr($alignment).'" layout_display="'.esc_attr($layout_display).'" ]'));
	}						
}

