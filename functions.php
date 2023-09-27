<?php
add_action('wp_enqueue_scripts', function (){

    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/custom.js', array('jquery'), time(), true);

    wp_localize_script('custom-script', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));

});

require 'inc/cpt.php';


add_action('wp_ajax_filter_realestate', 'filter_realestate');
add_action('wp_ajax_nopriv_filter_realestate', 'filter_realestate');

function filter_realestate() {
    $floorCount = sanitize_text_field($_POST['floorCount']);
    $buildingType = sanitize_text_field($_POST['buildingType']);

    $args = [
        'post_type' => 'realestate_object',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'meta_query' => []
    ];


    if (!empty($floorCount)) {
        $args['meta_query'][] = [
            'key' => 'count_left',
            'value' => $floorCount,
            'compare' => '='
        ];
    }

    if (!empty($buildingType)) {
        $args['meta_query'][] = [
            'key' => 'type_rooms',
            'value' => $buildingType,
            'compare' => '='
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            $name_room = get_field('name_room');
            $photo = get_the_post_thumbnail_url(null, 'full');
            $coordinate_maps = get_field('coordinate_maps');
            $type_rooms = get_field('type_rooms');
            $count_left = get_field('count_left');
            ?>
            <div class="col ">
                <div class="card shadow-sm">
                    <?php if ($photo) { ?>
                        <img class="img-fluid" src="<?php echo $photo; ?>" alt="<?php echo $name_room; ?>"
                             style="max-height: 200px;min-height: 200px;height: 100%">
                    <?php } ?>
                    <div class="card-body">

                        <?php if ($name_room) { ?>
                            <h3 class="center">
                                <?php echo $name_room; ?>
                            </h3>
                        <?php } ?>
                        <div class="card-text">
                            <?php echo wp_trim_words(get_the_content(), 15); ?>
                        </div>

                        <?php if ($coordinate_maps) { ?>
                            <div class="card-text mb-2">
                                <b>Координати місцезнаходження:</b>
                                <?php echo $coordinate_maps; ?>
                            </div>
                        <?php } ?>

                        <?php if ($type_rooms) { ?>
                            <div class="card-text mb-2">
                                <b>Тип будівлі:</b>
                                <?php echo $type_rooms; ?></div>
                        <?php } ?>

                        <?php if ($count_left) { ?>
                            <div class="card-text">
                                <b>Кількість поверхів:</b>
                                <?php echo $count_left; ?>
                            </div>
                        <?php } ?>

                        <div class="d-flex justify-content-between align-items-center pt-3">
                            <div class="btn-group">
                                <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-secondary">Переглянути</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

       <?php
        }
        wp_reset_postdata();
        $response = ob_get_clean();
        echo $response;
    } else {
        echo 'За вашими параметрами нічого не знайдено.';
    }

    wp_die();
}
