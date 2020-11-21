<?php

/**
 *
 * @author keyvan
 */
class slider_widget_input {
    
    protected $type , $label , $placeholder , 
            $value , $field_name ,$id , $name_attr;
    
    
            
    function __construct($type, $field_name , $id , $name_attr , $label , $placehoder) {
        $this->type = $type;
        $this->field_name = $field_name;
        $this->placeholder = $placehoder;
        $this->id = $id;
        $this->name_attr = $name_attr;
        $this->label = $label;
    }
    
//    public static function hidden_input($type, $field_name , $id , $name_attr , $label , $placehoder) {
//        $instance = new self($type, $field_name , $id , $name_attr , $label , $placehoder);
//        $instance->setHidden(true);
//        return $instance;
//    }
    function getType() {
        return $this->type;
    }

    function getLabel() {
        return $this->label;
    }

    function getPlaceholder() {
        return $this->placeholder;
    }

    function getValue() {
        return $this->value;
    }

    function getField_name() {
        return $this->field_name;
    }

    function getId() {
        return $this->id;
    }

    function getName_attr() {
        return $this->name_attr;
    }

    function getHidden() {
        return $this->hidden;
    }

    function setType($type): void {
        $this->type = $type;
    }

    function setLabel($label): void {
        $this->label = $label;
    }

    function setPlaceholder($placeholder): void {
        $this->placeholder = $placeholder;
    }

    function setValue($value): void {
        $this->value = $value;
    }

    function setField_name($field_name): void {
        $this->field_name = $field_name;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setName_attr($name_attr): void {
        $this->name_attr = $name_attr;
    }

    function setHidden($hidden): void {
        $this->hidden = $hidden;
    }

        
    public function display($instance) {
        switch ($this->type) {
            case "text":
                $this->display_text($instance);
                break;
            
            case "select":
                $this->display_select($instance);
                break;
            
            case "color":
                $this->display_color($instance);
                break;
            
            case "hidden":
                $this->display_hidden($instance);
                break;
            case "upload_image":
                $this->display_upload_image($instance);
                break;
        }
    }
    
    public static function get_default_inputs($widget_instance)
    {
        $inputs = [];
        
        
        foreach (slider_widget_input::slider_widget_default_inputs() as $key => $value) {
            $inputs[] = new slider_widget_input($value['type'],
                    $key,
                    $widget_instance->get_field_id($key),
                    $widget_instance->get_field_name($key),
                    $value['label'],
                    $value['placeholder']
                    );
        }
        return $inputs;
    }
    
    public static function save_inputs($new_instance)
    {
        $instance =[];
        
        
        foreach (slider_widget_input::slider_widget_default_inputs() as $key => $value) {
            if(isset($new_instance[$key]) && !empty($new_instance [$key])){
                $instance[$key] = sanitize_text_field($new_instance[$key]);
            }
        }
        
        return $instance;
    }


    protected function display_text($instance) 
    {
        
        $value = (isset($instance[$this->field_name])) ? $instance[$this->field_name] : "";
        
        ?>
            <!-- Label for <?php echo $this->name_attr ?> input -->
<label for="<?php echo $this->id ?>"><?php echo $this->label;  ?></label>
            <br>
<!-- <?php echo $this->name_attr ?> input -->
        
            <input type="text" id="<?php echo $this->id ?>" name="<?php echo $this->name_attr ?>" value="<?php echo $value; ?>" placeholder="<?php echo $this->placeholder ?>">
            <br>
            <?php
    }
    
    protected function display_select($instance) 
    {
        $value = (isset($instance[$this->field_name])) ? $instance[$this->field_name] : "";
        ?>
            <!-- Label for <?php echo $this->name_attr ?> input -->
            <label for="<?php echo $this->id ?>"><?php echo $this->label;  ?></label>
            <br>
            <!-- <?php echo $this->name_attr ?> input -->
        
            <select name="<?php echo $this->name_attr ?>" id="<?php echo $this->id ?>" value="<?php echo esc_html($value); ?>" >
                <option value="yes" <?php 
                echo ($value == "yes") ? "selected" : ""; 
                ?>>Yes</option>
                <option value="no" <?php 
                echo ($value == "no") ? "selected" : ""; 
                ?>>No</option>
            </select>
            <br>
            <?php
    }
    
    protected function display_color($instance) {
        $value = (isset($instance[$this->field_name])) ? $instance[$this->field_name] : "";
        ?>
            <!-- Label for <?php echo $this->name_attr ?> input -->
            <label for="<?php echo $this->id ?>"><?php echo $this->label;  ?></label>
            <br>
            <!-- <?php echo $this->name_attr ?> input -->
        <input type="color" id="<?php echo $this->id ?>" name="<?php echo $this->name_attr ?>" value="<?php echo esc_html($value); ?>">
            <br>
            
            <?php
    }
    
    protected function display_hidden($instance) {
        $value = (isset($instance[$this->field_name])) ? $instance[$this->field_name] : "";
        ?>
            
            <!-- <?php echo $this->name_attr ?> input -->
        <input type="hidden" id="<?php echo $this->id ?>" name="<?php echo $this->name_attr ?>" value="<?php echo esc_html($value); ?>">
        
            <br>
            
            <?php 
            if($this->field_name == "banner_attach_id" && !empty($value)){
                echo wp_get_attachment_image($value , [200 , 300]);
            }
    }
    
    protected function display_upload_image($instance) {
        $value = (isset($instance[$this->field_name])) ? $instance[$this->field_name] : "";
        $upload_link = esc_url( get_upload_iframe_src( 'image' ) );
        printf('<a class="slider_widget_upload_banner_img_%s" href="%s"> Choose Banner Image link</a>', $this->id, $upload_link );
        
        
        echo '<div class="slider_widget_wp_media_image_'. $this->id .'">';
        if($value){
            echo wp_get_attachment_image($value , [200 , 300]);
        }
        echo '</div>';
        
        
        ?>
            
            <!-- <?php echo $this->name_attr ?> input -->
        <input type="hidden" id="<?php echo $this->id ?>" name="<?php echo $this->name_attr ?>" value="<?php echo esc_html($value); ?>">
        
            <br>
            
            <?php 
            
    }
    
    public static function slider_widget_default_inputs() {
        return [
            'slider_widget_title' =>[
                'type' => 'text',
                'label' => 'Title' , 
                'placeholder' => 'Title' , 
            ],
            'tag_name' => [
                'type' => 'text',
                'label' => 'Tag' , 
                'placeholder' => 'Tag' ,
            ],
            'banner_text' =>[
                'type' => 'text',
                'label' => 'Text for Banner' , 
                'placeholder' => 'Banner' , 
            ],
//            'banner_image' =>[
//                'type' => 'text',
//                'label' => 'Image for Banner' , 
//                'placeholder' => 'Attachment ID' , 
//            ],
            'background_color' =>[
                'type' => 'color',
                'label' => 'Pick Background Color' , 
                'placeholder' => '' , 
            ],
            'background_color' =>[
                'type' => 'color',
                'label' => 'Pick Background Color' , 
                'placeholder' => '' , 
            ],
            'is_wooCommerce' =>[
                'type' => 'select',
                'label' => 'Are slides WooCommerce Products?' , 
                'placeholder' => '' , 
            ],
            'is_loop' =>[
                'type' => 'select',
                'label' => 'Should slides be in a loop?' , 
                'placeholder' => '' , 
            ],
            'banner_attach_id' =>[
                'type' => 'upload_image',
                'label' => '' , 
                'placeholder' => '' , 
            ],
        ];
    }
    
}
