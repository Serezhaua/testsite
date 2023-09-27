<?php 
    $realestate_object = ([
        'labels' => ([
            'name' => "Об'єкт нерухомості",
            'menu_name' => "Об'єкт нерухомості",
            'singular_name' => "Об'єкт нерухомості",
        ]),
        'public' => true,
        'menu_icon' => 'dashicons-thumbs-up',
        'supports' => array(
            'title',
            'custom-fields',
            'thumbnail',
            'editor'
        ),
        'has_archive' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
    
    ]);
    register_post_type('realestate_object', $realestate_object);
