<?php
declare(strict_types=1);
namespace inc\plugins\elementor\EMCLIENT_class_elementor_function;
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package em-client
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */



    class EMCLIENT_theme_elementor_function_Class extends \Elementor\Widget_Base
    {

        public function get_name(): string {
            return 'hello_world_widget_2';
        }
    
        public function get_title(): string {
            return esc_html__( 'Hello World 2', 'elementor-addon' );
        }
    
        public function get_icon(): string {
            return 'eicon-code';
        }
    
        public function get_categories(): array {
            return [ 'basic' ];
        }
    
        public function get_keywords(): array {
            return [ 'hello', 'world' ];
        }
    
        protected function register_controls(): void {
    
            // Content Tab Start
    
            $this->start_controls_section(
                'section_title',
                [
                    'label' => esc_html__( 'Title', 'elementor-addon' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
    
            $this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'Hello world', 'elementor-addon' ),
                ]
            );
    
            $this->end_controls_section();
    
            // Content Tab End
    
    
            // Style Tab Start
    
            $this->start_controls_section(
                'section_title_style',
                [
                    'label' => esc_html__( 'Title', 'elementor-addon' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );
    
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Text Color', 'elementor-addon' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hello-world' => 'color: {{VALUE}};',
                    ],
                ]
            );
    
            $this->end_controls_section();
    
            // Style Tab End
    
        }
    
        protected function render(): void {
            $settings = $this->get_settings_for_display();
    
            if ( empty( $settings['title'] ) ) {
                return;
            }
            ?>
            <p class="hello-world">
                <?php echo $settings['title']; ?>
            </p>
            <?php
        }
    
        protected function content_template(): void {
            ?>
            <#
            if ( '' === settings.title ) {
                return;
            }
            #>
            <p class="hello-world">
                {{ settings.title }}
            </p>
            <?php
        }
	

	} // Closing bracket for classes
    use inc\plugins\elementor\EMCLIENT_class_elementor_function;