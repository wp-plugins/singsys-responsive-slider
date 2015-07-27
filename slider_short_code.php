<?php

    $class_file = __DIR__.'/admin_class.php';
    
    if(file_exists($class_file)){
        include_once($class_file);
    }
    
    class singsys_slider_code extends singsys_slider{
        
        public function __construct(){
            
            add_shortcode('singsys_slider',array($this,'do_action'));
            add_action('wp_enqueue_scripts', array($this, 'script'));
			//add_action('wp_footer',array($this,'action_in_footer'),10000);
            
        }
        
        function do_action($arg=null){
            global $wpdb,$singsys_run_slider,$singsys_slider_script;
            $singsys_run_slider++;
            ob_start();
            $prefix = $wpdb->prefix;
            if(isset($arg['id'])){
                // Check Slider Is exists
                $id = $arg['id'];
              // $sql = "select";
              
             
            
            
               
              $this->slider_id = $id;
               
               $my_slider = $this->get_slider();
               //echo $my_slider->title;
                 $items = $this->get_items();
                 $option = unserialize($my_slider->option);
               
                 if(isset($option['slider_status']) && $option['slider_status']=='y' ){
                 if(count($items)){
					 if(!$singsys_slider_script){
						 $this->script_in_footer();
						 }
					 
                    echo '<div id="singsys_slider-'.$singsys_run_slider.'" class="owl-carousel singsys_slide-'.$id.'">';
                    
                 
                  foreach($items as $item){
                    ?>
                    <?php if(filter_var($item->link, FILTER_VALIDATE_URL)): ?>
                    <div class="item"><a href="<?php echo $item->link; ?>"><?php echo  wp_get_attachment_image($item->media_id,'full') ;  ?></a>
                                      </div> 
                    <?php else: ?>
                    <div class="item"><?php echo  wp_get_attachment_image($item->media_id,'full') ;  ?></div>
                    <?php endif; ?>
                    <?php
                   }
                  echo '</div>';
                  }
            }
            
            
            ?>
            <!-- Script code -->
            
             
            <script type="text/javascript">
                //<![CDATA[  
                    jQuery(document).ready(function($) {
                        //alert('ok');
                        $("#singsys_slider-<?php echo $singsys_run_slider; ?>").owlCarousel({
                            items:<?php echo (isset($option['items']))?$option['items']:4; ?>,
                            singleItem:<?php echo (isset($option['singleItem']))?($option['singleItem']=='yes')?'true':'false':'false'; ?>,
                            itemsDesktop : [1000,<?php echo (isset($option['itemsDesktop']))?$option['itemsDesktop']:5; ?>], //5 items between 1000px and 901px
                            itemsDesktopSmall : [900,<?php echo (isset($option['itemsDesktopSmall']))?$option['itemsDesktopSmall']:3; ?>], // betweem 900px and 601px
                            itemsTablet: [600,<?php echo (isset($option['itemsTablet']))?$option['itemsTablet']:3; ?>], //2 items between 600 and 0
                            itemsMobile : [480,<?php echo (isset($option['itemsMobile']))?$option['itemsMobile']:1; ?>],// itemsMobile disabled - inherit from itemsTablet option
                            navigation:true,
                            slideSpeed:<?php echo (isset($option['slideSpeed']))?$option['slideSpeed']:200; ?>,
                            paginationSpeed:<?php echo (isset($option['paginationSpeed']))?$option['paginationSpeed']:800; ?>,
                            rewindSpeed:<?php echo (isset($option['rewindSpeed']))?$option['rewindSpeed']:1000; ?>,
                            autoPlay:<?php echo (isset($option['autoPlay']))?$option['autoPlay']:'false'; ?>,
                            stopOnHover:<?php echo (isset($option['stopOnHover']))?($option['stopOnHover']=='yes')?'true':'false':'false'; ?>,
                            navigation:<?php echo (isset($option['navigation']))?($option['navigation']=='yes')?'true':'false':'false'; ?>,
                            pagination:<?php echo (isset($option['pagination']))?($option['pagination']=='yes')?'true':'false':'false'; ?>,
                            paginationNumbers:<?php echo (isset($option['paginationNumbers']))?($option['paginationNumbers']=='yes')?'true':'false':'false'; ?>,
                            responsive:<?php echo (isset($option['responsive']))?($option['responsive']=='yes')?'true':'false':'false'; ?>,
                            responsiveBaseWidth:'<?php echo (isset($option['responsiveBaseWidth']))?$option['responsiveBaseWidth']:'window'; ?>',
                            baseClass:'<?php echo (isset($option['baseClass']))?$option['baseClass']:'owl-carousel'; ?>,'
                        });
                    });
                //]]>
                </script>
            <?php
                $html = ob_get_contents();
                ob_clean();
                ob_end_flush();
                return $html;
            }
        }
        
        function script(){
            global $post,$singsys_slider_script;
            wp_enqueue_script('jquery');
            if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'singsys_slider') ) {
                $singsys_slider_script++;        
                wp_enqueue_style( 'singsys-slider-style', plugins_url('/owl/owl.carousel.css',__FILE__), false );
                wp_enqueue_style( 'singsys-slider-theme-style', plugins_url('/owl/owl.theme.css',__FILE__), false );
                wp_enqueue_style( 'singsys-slider-animation-style', plugins_url('/owl/owl.transitions.css',__FILE__), false );
                wp_enqueue_script('singsys-slider-script',plugins_url('/owl/owl.carousel.min.js',__FILE__), false,null,true);
				
            }
        }
        
        function script_in_footer(){
            wp_enqueue_style( 'singsys-slider-style', plugins_url('/owl/owl.carousel.css',__FILE__), false,null,'all',true );
            wp_enqueue_style( 'singsys-slider-theme-style', plugins_url('/owl/owl.theme.css',__FILE__), false ,null,'all',true);
            wp_enqueue_style( 'singsys-slider-animation-style', plugins_url('/owl/owl.transitions.css',__FILE__), false ,null,'all',true);
            wp_enqueue_script('singsys-slider-script',plugins_url('/owl/owl.carousel.min.js',__FILE__), false,null,true);
        }
    }