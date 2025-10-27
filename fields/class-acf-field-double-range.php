<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('acf_field_double_range')) :

class acf_field_double_range extends acf_field {

    public $settings = [];

    public function __construct($settings = []) {
        $this->name     = 'double_range';
        $this->label    = __('Double Range', 'acf-double-range');
        $this->category = 'jquery';
        $this->defaults = [
            'min_limit'   => 0,
            'max_limit'   => 100,
            'step'        => 1,
            'default_min' => '',
            'default_max' => '',
        ];
        $this->settings = $settings;
        parent::__construct();
    }

    public function render_field_settings($field) {
        acf_render_field_setting($field, [
            'label' => __('Min limit', 'acf-double-range'),
            'name'  => 'min_limit',
            'type'  => 'number',
            'default_value' => $this->defaults['min_limit'],
        ]);

        acf_render_field_setting($field, [
            'label' => __('Max limit', 'acf-double-range'),
            'name'  => 'max_limit',
            'type'  => 'number',
            'default_value' => $this->defaults['max_limit'],
        ]);

        acf_render_field_setting($field, [
            'label' => __('Step', 'acf-double-range'),
            'name'  => 'step',
            'type'  => 'number',
            'default_value' => $this->defaults['step'],
        ]);

        acf_render_field_setting($field, [
            'label' => __('Default min', 'acf-double-range'),
            'name'  => 'default_min',
            'type'  => 'number',
        ]);

        acf_render_field_setting($field, [
            'label' => __('Default max', 'acf-double-range'),
            'name'  => 'default_max',
            'type'  => 'number',
        ]);
    }

    public function render_field($field) {
        $value = is_array($field['value']) ? $field['value'] : [];
        $minLimit = isset($field['min_limit']) ? $field['min_limit'] : 0;
        $maxLimit = isset($field['max_limit']) ? $field['max_limit'] : 100;
        $step     = isset($field['step']) ? $field['step'] : 1;

        $minV = isset($value['min']) ? $value['min'] :
                (($field['default_min'] !== '') ? $field['default_min'] : $minLimit);
        $maxV = isset($value['max']) ? $value['max'] :
                (($field['default_max'] !== '') ? $field['default_max'] : $maxLimit);

        $nameMin = esc_attr($field['name'] . '[min]');
        $nameMax = esc_attr($field['name'] . '[max]');
        ?>
        <div class="acf-double-range" data-min="<?php echo esc_attr($minLimit); ?>"
             data-max="<?php echo esc_attr($maxLimit); ?>" data-step="<?php echo esc_attr($step); ?>">

            <input type="number" class="double-range-min"
                   name="<?php echo $nameMin; ?>"
                   value="<?php echo esc_attr($minV); ?>"
                   min="<?php echo esc_attr($minLimit); ?>"
                   max="<?php echo esc_attr($maxLimit); ?>"
                   step="<?php echo esc_attr($step); ?>" />

            <div class="double-slider"></div>

            <input type="number" class="double-range-max"
                   name="<?php echo $nameMax; ?>"
                   value="<?php echo esc_attr($maxV); ?>"
                   min="<?php echo esc_attr($minLimit); ?>"
                   max="<?php echo esc_attr($maxLimit); ?>"
                   step="<?php echo esc_attr($step); ?>" />
        </div>
        <?php
    }

    public function update_value($value, $post_id, $field) {
        return [
            'min' => isset($value['min']) ? (0 + $value['min']) : null,
            'max' => isset($value['max']) ? (0 + $value['max']) : null,
        ];
    }

    /**
     * ACF-Documented place to enqueue field assets for Classic editor.
     */
    public function input_admin_enqueue_scripts() {
        $base_url = trailingslashit($this->settings['url']);

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-mouse');
        wp_enqueue_script('jquery-ui-slider');

        wp_enqueue_style('acf-dr-field-css', $base_url . 'assets/css/field.css', [], $this->settings['version']);
        wp_enqueue_script(
            'acf-dr-field-js',
            $base_url . 'assets/js/field.js',
            ['jquery', 'jquery-ui-slider', 'acf-input'],
            $this->settings['version'],
            true
        );
    }
}

endif;
