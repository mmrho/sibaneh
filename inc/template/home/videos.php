<div class="container-lg video-panel">
    <div class="row">
        <?php
        $videos = SANJESH_OPTIONS['home-videos-slider-items'];
        if (!empty($videos['title'])) {
            foreach ($videos['title'] as $key => $val) {
                ?>
                <div class="col-12 video-box-panel">
                    <div class="video-box">
                        <div class="video">
                            <video controls>
                                <source src="<?php echo $videos['video'][$key]['url']; ?>" type="video/mp4">
                            </video>
                        </div>
                        <div class="description">
                            <?php echo $videos['description'][$key]; ?>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
</div>