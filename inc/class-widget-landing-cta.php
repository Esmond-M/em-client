<?php
class EMClient_Landing_CTA_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'emclient_landing_cta',
            __('Landing Page CTA', 'emclient'),
            array('description' => __('Call to Action for the landing page.', 'emclient'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        ?>
        <div class="em-landing-cta-widget">
            <p><?php echo !empty($instance['cta_text']) ? esc_html($instance['cta_text']) : __('Ready to get started?', 'emclient'); ?></p>
            <?php if (!empty($instance['cta_url'])): ?>
                <a href="<?php echo esc_url($instance['cta_url']); ?>" class="em-cta-btn">
                    <?php echo !empty($instance['cta_btn']) ? esc_html($instance['cta_btn']) : __('Contact Us', 'emclient'); ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('CTA Title', 'emclient');
        $cta_text = !empty($instance['cta_text']) ? $instance['cta_text'] : '';
        $cta_btn = !empty($instance['cta_btn']) ? $instance['cta_btn'] : '';
        $cta_url = !empty($instance['cta_url']) ? $instance['cta_url'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'emclient'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cta_text')); ?>"><?php _e('CTA Text:', 'emclient'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('cta_text')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('cta_text')); ?>" type="text"
                   value="<?php echo esc_attr($cta_text); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cta_btn')); ?>"><?php _e('Button Text:', 'emclient'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('cta_btn')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('cta_btn')); ?>" type="text"
                   value="<?php echo esc_attr($cta_btn); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cta_url')); ?>"><?php _e('Button URL:', 'emclient'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('cta_url')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('cta_url')); ?>" type="text"
                   value="<?php echo esc_attr($cta_url); ?>">
        </p>
        <?php
    }
}