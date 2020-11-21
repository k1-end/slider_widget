
<script type="text/javascript">

    (function($) {
        $(document).ready(function(){
        $("#<?php echo "lightSlider_list_" . $args["widget_id"] ?>").lightSlider({
            loop:<?php echo ($instance["is_loop"] == "yes") ? "true" : "false" ?>,
            keyPress:true,
            controls: true,
            rtl:true , 
            pager: false,
            item: 4,
                    responsive : [
            {
                breakpoint:800,
                settings: {
                    item:3,
                    slideMove:1,
                    slideMargin:6,
                  }
            },
            {
                breakpoint:480,
                settings: {
                    item:1,
                    slideMove:1
                  }
            }
        ]

            });
    });
    })(jQuery);
    
    

</script>