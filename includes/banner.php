<div class="slider_widget_banner_container">
                    <p class="slider_widget_banner_text">
                        <?php echo (isset($instance["banner_text"])) ? $instance["banner_text"] : ""; ?>
                    </p>
                    <?php echo wp_get_attachment_image($instance["banner_attach_id"] , [200 , 300])?>
                    <a class="slider_widget_banner_button" href="<?php echo get_tag_link(get_term_by('name', $the_tag, 'post_tag'));?>">See all</a>
                </div>