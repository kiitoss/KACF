<?php
if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_62ab4bdba7918',
        'title' => 'Shortcode',
        'fields' => array(
            array(
                'key' => 'field_62ab4bef6145b',
                'label' => 'Code Court',
                'name' => '',
                'type' => 'message',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => 'Le Code Court (aussi appelé "shortcode") vous permet d\'intégrer un contenu important grâce à un simple texte.',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
            array(
                'key' => 'field_62ab4be26145a',
                'label' => 'Shortcode',
                'name' => 'shortcode',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/shortcode',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'acfe_display_title' => '',
        'acfe_autosync' => '',
        'acfe_form' => 0,
        'acfe_meta' => '',
        'acfe_note' => '',
    ));

endif;
