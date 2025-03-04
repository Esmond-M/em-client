<?php
declare(strict_types=1);
namespace inc\plugins\elementor\classes\elementor_card_widget;

if (!class_exists('EMCLIENT_elementor_card_widget')) {
    class EMCLIENT_elementor_card_widget extends \Elementor\Widget_Base
    {
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
            return 'card';
        }
	
        public function get_title() {
            return esc_html__( 'EM Client Card', 'emclient-card-elementor-widget' );
        }

        public function get_icon() {
            return 'eicon-header';
        }

        public function get_custom_help_url() {
            return 'https://github.com/Esmond-M/em-client';
        }

        public function get_categories() {
            return [ 'general' ];
        }

        public function get_keywords() {
            return [ 'card', 'service', 'highlight', 'emclient' ];
        }

        protected function register_controls() { 
            $this->start_controls_section(
                'content_section',
                [
                'label' => esc_html__( 'Content', 'emclient-card-elementor-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'card_title',
                [
                'label' => esc_html__( 'Card title', 'emclient-card-elementor-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'Your card title here', 'emclient-card-elementor-widget' ),
                ]
            );
            $this->add_control(
                'card_description',
                [
                'label' => esc_html__( 'Card Description', 'emclient-card-elementor-widget' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'label_block'   => true,
                'placeholder' => esc_html__( 'Your card description here', 'emclient-card-elementor-widget' ),
                ]
            );
            $this->end_controls_section();
        }

        protected function render() {

            // get our input from the widget settings.
            $settings = $this->get_settings_for_display();
        
        // get the individual values of the input
        $card_title = $settings['card_title'];
        $card_description = $settings['card_description'];
    
        ?>
    
            <!-- Start rendering the output -->
            <div class="card">
                <h3 class="card_title"><?php echo $card_title;  ?></h3>
                <p class= "card__description"><?php echo $card_description;  ?></p>
            </div>
            <!-- End rendering the output -->
    
            <?php
    
       }

	} // Closing bracket for classes
}
    use inc\plugins\elementor\classes\elementor_card_widget;