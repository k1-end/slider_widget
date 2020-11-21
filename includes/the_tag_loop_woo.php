<?php

$the_tag = $instance['tag_name'];

$the_query = new WP_Query([
    'post_type' => 'product' ,
    'product_tag' => $the_tag]);

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
                    <?php //single_post_title();
                    echo $product->get_name()?>
                </p>
                <p class="slider_widget_regular_price">
                <?php 
                if($product->get_sale_price()){
                    $discount = ($product->get_regular_price()- $product->get_sale_price())/$product->get_regular_price() * 100;
                    printf("<span class=\"slider_widget_discount\"> %.0f %%</span>" , $discount);

                } ?>
                <span>
                    <?php 
                    echo $product->get_regular_price().' '. get_woocommerce_currency_symbol(); 

                    ?> 
                </span>
                </p>
                <p class="slider_widget_sale_price"><?php 
                if($product->get_sale_price()){
                        echo  $product->get_sale_price() . ' ' . get_woocommerce_currency_symbol();
                    }  ?></p>

            </li>
            <?php
        }
        ?>
        </ul>

        <?php require WP_PLUGIN_DIR . "/slider_widget/includes/banner.php"; ?>
    </div>
    <?php


} else {
    //TODO echo nothing
}
wp_reset_postdata();
//}