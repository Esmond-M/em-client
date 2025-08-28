<?php
class EMClient_Recent_Posts_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'emclient_recent_posts',
            __('EMClient Recent Posts', 'emclient'),
            array('description' => __('Displays recent posts with options.', 'emclient'))
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Posts', 'emclient');
        $num_posts = !empty($instance['num_posts']) ? absint($instance['num_posts']) : 5;
        $show_date = !empty($instance['show_date']);
        $show_thumb = !empty($instance['show_thumb']);
        $cat_id = !empty($instance['cat_id']) ? absint($instance['cat_id']) : 0;

        echo $args['before_widget'];
        if ($title) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }

        $query_args = array(
            'numberposts' => $num_posts,
            'post_status' => 'publish',
        );
        if ($cat_id) {
            $query_args['category'] = $cat_id;
        }
        $recent_posts = wp_get_recent_posts($query_args);

        echo '<ul class="emclient-recent-posts">';
        foreach ($recent_posts as $post) {
            echo '<li>';
            if ($show_thumb && has_post_thumbnail($post['ID'])) {
                echo '<a href="' . get_permalink($post['ID']) . '" class="emclient-post-thumb">' . get_the_post_thumbnail($post['ID'], 'thumbnail') . '</a> ';
            }
            echo '<a href="' . get_permalink($post['ID']) . '">' . esc_html($post['post_title']) . '</a>';
            if ($show_date) {
                echo '<span class="emclient-post-date">' . get_the_date('', $post['ID']) . '</span>';
            }
            echo '</li>';
        }
        echo '</ul>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Posts', 'emclient');
        $num_posts = !empty($instance['num_posts']) ? absint($instance['num_posts']) : 5;
        $show_date = !empty($instance['show_date']) ? 'checked' : '';
        $show_thumb = !empty($instance['show_thumb']) ? 'checked' : '';
        $cat_id = !empty($instance['cat_id']) ? absint($instance['cat_id']) : 0;

        // Get categories for dropdown
        $categories = get_categories(array('hide_empty' => false));
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'emclient'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('num_posts')); ?>"><?php _e('Number of posts:', 'emclient'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('num_posts')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('num_posts')); ?>" type="number" step="1" min="1"
                   value="<?php echo esc_attr($num_posts); ?>" style="width: 50px;">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php echo $show_date; ?> id="<?php echo esc_attr($this->get_field_id('show_date')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php _e('Display post date?', 'emclient'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php echo $show_thumb; ?> id="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_thumb')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>"><?php _e('Display featured image?', 'emclient'); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cat_id')); ?>"><?php _e('Category:', 'emclient'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('cat_id')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('cat_id')); ?>">
                <option value="0"><?php _e('All Categories', 'emclient'); ?></option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo esc_attr($cat->term_id); ?>" <?php selected($cat_id, $cat->term_id); ?>>
                        <?php echo esc_html($cat->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['num_posts'] = absint($new_instance['num_posts']);
        $instance['show_date'] = !empty($new_instance['show_date']) ? 1 : 0;
        $instance['show_thumb'] = !empty($new_instance['show_thumb']) ? 1 : 0;
        $instance['cat_id'] = absint($new_instance['cat_id']);
        return $instance;
    }
}