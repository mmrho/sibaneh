<?php if ((int)SANJESH_OPTIONS['home-top-person-status'] === 0) {
    $tenthGrade = SANJESH_OPTIONS['home-tenth-grade-top-person'];
    $eleventhGrade = SANJESH_OPTIONS['home-eleventh-grade-top-person'];
    $twelfthGrade = SANJESH_OPTIONS['home-twelfth-grade-top-person'];
    ?>
    <div class="container-lg top-person-panel">
        <div class="row panel-title">
            <header class="col-12">
                <h2>نفرات برتر سنجشگران علوم</h2>
            </header>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-11 col-lg-7 top-person-tabs">
                <ul>
                    <?php if (!empty($tenthGrade['title'])) { ?>
                        <li data-target="tenthTopPerson" class="active">پایه دهم</li>
                    <?php }
                    if (!empty($eleventhGrade['title'])) { ?>
                        <li data-target="eleventhTopPerson">پایه یازدهم</li>
                    <?php }
                    if (!empty($twelfthGrade['title'])) { ?>
                        <li data-target="twelfthTopPerson">پایه دوازدهم</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-11">
                <?php if (!empty($tenthGrade['title'])) { ?>
                    <div class="top-person-box align-items-center flex-wrap" id="tenthTopPerson">
                        <?php
                        foreach ($tenthGrade['title'] as $key => $title) {
                            ?>
                            <div class="item flex-column d-flex justify-content-center align-items-center">
                                <?php echo wp_get_attachment_image($tenthGrade['image'][$key]['id'], 'full'); ?>
                                <p class="flex-column d-flex">
                                    <strong>رتبه <?php echo $tenthGrade['grade'][$key]; ?></strong>
                                    <small><?php echo $title; ?></small>
                                </p>
                            </div>
                            <div class="item flex-column d-flex justify-content-center align-items-center">
                                <?php echo wp_get_attachment_image($tenthGrade['image'][$key]['id'], 'full'); ?>
                                <p class="flex-column d-flex">
                                    <strong>رتبه <?php echo $tenthGrade['grade'][$key]; ?></strong>
                                    <small><?php echo $title; ?></small>
                                </p>
                            </div>
                            <div class="item flex-column d-flex justify-content-center align-items-center">
                                <?php echo wp_get_attachment_image($tenthGrade['image'][$key]['id'], 'full'); ?>
                                <p class="flex-column d-flex">
                                    <strong>رتبه <?php echo $tenthGrade['grade'][$key]; ?></strong>
                                    <small><?php echo $title; ?></small>
                                </p>
                            </div>
                            <div class="item flex-column d-flex justify-content-center align-items-center">
                                <?php echo wp_get_attachment_image($tenthGrade['image'][$key]['id'], 'full'); ?>
                                <p class="flex-column d-flex">
                                    <strong>رتبه <?php echo $tenthGrade['grade'][$key]; ?></strong>
                                    <small><?php echo $title; ?></small>
                                </p>
                            </div>
                            <div class="item flex-column d-flex justify-content-center align-items-center">
                                <?php echo wp_get_attachment_image($tenthGrade['image'][$key]['id'], 'full'); ?>
                                <p class="flex-column d-flex">
                                    <strong>رتبه <?php echo $tenthGrade['grade'][$key]; ?></strong>
                                    <small><?php echo $title; ?></small>
                                </p>
                            </div>
                            <?php
                        }

                        ?>
                    </div>
                <?php }
                if (!empty($eleventhGrade['title'])) { ?>
                    <div class="top-person-box align-items-center flex-wrap" id="eleventhTopPerson">
                        <?php
                        foreach ($eleventhGrade['title'] as $key => $title) {
                            ?>
                            <div class="item flex-column d-flex justify-content-center align-items-center">
                                <?php echo wp_get_attachment_image($eleventhGrade['image'][$key]['id'], 'full'); ?>
                                <p class="flex-column d-flex">
                                    <strong>رتبه <?php echo $eleventhGrade['grade'][$key]; ?></strong>
                                    <small><?php echo $title; ?></small>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                <?php }
                if (!empty($twelfthGrade['title'])) { ?>
                    <div class="top-person-box align-items-center flex-wrap" id="twelfthTopPerson">
                        <?php
                        foreach ($twelfthGrade['title'] as $key => $title) {
                            ?>
                            <div class="item flex-column d-flex justify-content-center align-items-center">
                                <?php echo wp_get_attachment_image($twelfthGrade['image'][$key]['id'], 'full'); ?>
                                <p class="flex-column d-flex">
                                    <strong>رتبه <?php echo $twelfthGrade['grade'][$key]; ?></strong>
                                    <small><?php echo $title; ?></small>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
}