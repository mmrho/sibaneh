<?php $args = [
    'post_type' => 'notifications',
    'posts_per_page' => 10,
];
$query = new WP_Query($args);
if ($query->have_posts()) {
    ?>
    <div class="container-lg">
        <div class="row panel-title">
            <header class="col-12">
                <h2>اطلاعیه های سنجشگران علوم</h2>
            </header>
        </div>
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="notification-box">
                    <ul>
                        <?php while ($query->have_posts()) {
                            $query->the_post();
                            $postClass = get_post_meta(get_the_ID(), 'class_id', true);
                            $postFOS = get_post_meta(get_the_ID(), 'fos_id', true);
                            $postgGrade = get_post_meta(get_the_ID(), 'grade_id', true);
                            $title = 'تمامی مقاطع تحصیلی';
                            if (!empty($postClass)) {
                                $classRoom = new ClassRoom();
                                $getClass = $classRoom->get($postClass);
                                $title = $getClass->title;
                            }
                            if (empty($postClass) && !empty($postFOS)) {
                                $FOS = new AcademicFOS();
                                $getFOS = $FOS->get($postFOS);
                                $title = $getFOS->title;
                            }
                            if (empty($postClass) && empty($postFOS)) {
                                $grade = new AcademicGrade();
                                $getGrade = $grade->get($postgGrade);
                                $title = $getGrade->title;
                            }
                            ?>
                            <li>
                                <a href="<?php the_permalink(); ?>" target="_blank">
                                    <div class="info">
                                        <span><?php echo get_the_date('Y/m/d'); ?> - </span>
                                        <strong><?php the_title(); ?></strong>
                                        <small>
                                            <?php !empty($classTitle) ? '(' . $title . ')' : ''; ?>
                                        </small>
                                    </div>
                                </a>
                            </li>
                        <?php }
                        wp_reset_postdata(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
}