<?php
if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_62b9632708ab2',
        'title' => 'KACF Gallerie',
        'fields' => array(
            array(
                'key' => 'field_62b96337057e9',
                'label' => 'KACF Galerie',
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
                'message' => 'La galerie de blocks KACF récupère et affiche automatiquement tous les blocs des autres pages du site internet.
    Un champ de recherche permet ensuite de chercher parmi ces blocs.',
                'new_lines' => 'br',
                'esc_html' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/kacf-gallery',
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
