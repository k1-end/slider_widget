<?php

$the_tag = $instance['tag_name'];

$the_query = new WP_Query("tag=" . $the_tag);



if($the_query->have_posts()){

    $list_id = "lightSlider_list_" . $args["widget_id"];
    ?>
    <div class="light_slider_container" style="background:<?php echo $instance["background_color"];?>">
        <ul id="<?php echo $list_id?>" class="slider_widget_light_slider_list">
        <?php
        while ($the_query->have_posts()){
            $the_query->the_post();
            global $product;
            ?>
            <li class="slider_widget_full_height">
                <?php the_post_thumbnail([200 , 300]); ?>
                <p class="slider_widget_post_title">
                    <?php single_post_title();?>
                </p>
            </li>
            <?php
        }
        ?>
        </ul>

        <?php require WP_PLUGIN_DIR . "/slider_widget/includes/banner.php"; ?>
    </div>
    <?php  
} 
wp_reset_postdata();
