<?php get_header(); ?>

    <div class="container mb-5">
        <h1 class="mt-4"><?php the_title(); ?></h1>
    </div>


<?php
$rooms = [
    'post_type' => 'realestate_object',
    'posts_per_page' => -1,
    'order' => 'ASC'
];

$query = new WP_Query($rooms);
if ($query->have_posts()) { ?>
    <div class="album pt-5 bg-light pb-5">
        <div class="container">
            <div class="mb-5">
                <select id="floor-count-filter">
                    <option value="">Оберіть кількість поверхів</option>
                    <?php for ($i = 1; $i <= 20; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
                <select id="building-type-filter">
                    <option value="">Оберіть тип будівлі</option>
                    <option value="панель">панель</option>
                    <option value="цегла">цегла</option>
                    <option value="піноблок">піноблок</option>
                </select>
                <button id="filter-button">Фільтрувати</button>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php while ($query->have_posts()) {
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
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>