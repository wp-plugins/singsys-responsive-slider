<link href="<?php echo $url = plugins_url('../css/admin_style.css',__FILE__); ?>" rel="stylesheet" media="all">
<script type="text/javascript">var $close_img = '<?php echo plugins_url('../img/close.png',__FILE__); ?>';</script>
<?php
    if (isset($_REQUEST[id])) {
        $slider_id = $_REQUEST[id];
        $class_file = __DIR__.'/../admin_class.php';
        if (file_exists($class_file)) {
            include_once($class_file);
            $sys_slider = new singsys_slider($_REQUEST[id]);

            $slider = $sys_slider->get_slider();
            $slider_option = unserialize($slider->option);
        }
        $status = 'Update';
    } else {
        $status = 'Add';
        $slider_id = false;
    }
?>

<div class="wrap">
    <h2>
        <?php echo $status; ?> Slider
        <?php 
            if($status == 'Update'){
                echo '<a class="add-new-h2" href="?page=singsys_new_slider">Add New</a>';
            }
        ?>
    </h2>
    <br>
    <form method="post" action="admin-post.php">
        <input type="hidden" name="action" value="singsys_save_slider" id="" />
        <div class="singsys_slider_container">
            <div class="singsys_wrap">
                <input type="hidden" name="singsys_slider_id" value="<?php echo ($slider_id) ? $slider_id : -1 ?>" />
                <div class="singsys_content">
                    <div class="sys_head" style="margin-bottom: 15px;">
                        <div>
                            <input type="button" value="Add Slides" class="button-primary pull-right" id="upload_button" style="margin-bottom: 5px;"/>
                            <div class="clr"></div>
                        </div>
                        <div id="titlediv">
                            <div id="titlewrap">
                                <label for="title" id="title-prompt-text" class="screen-reader-text">Enter title here</label>
                                <input name="sys_slider_name" value="<?php echo ($slider_id) ? $slider->title : ''; ?>" id="title" spellcheck="true" autocomplete="off" placeholder="Slider Name" type="text" size="30" />
                            </div>
                            <div class="inside">
                                <div>
                                    <strong>Slider Name: </strong><i>The name is how it appears on your site.</i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="sys_content">
                        <input type="hidden" name="sys_media_id[]" id="sys_sys_media_id" />
                          <div class="img_wrap">
                              <img src="<?php echo plugins_url('/img/test.jpg'); ?>" alt=""/>
                          </div>
                          <div class="img_field">
                                <ul>
                                    <li><label class="sys-cl-30">Title: </label> <input type="text" value=""  name="sys_slider_title[]" id="sys_slider_title"/></li>
                                    <li><label class="sys-cl-30">Links: </label> <input type="text" value=""  name="sys_slider_links[]" id="sys_slider_links"/></li>
                                    <li><label class="sys-cl-30">Discription:</label><textarea name="sys_slider_desc[]" id="sys_slider_desc"></textarea></li>
                                </ul>
                              
                          </div>
                        <div class="clr"></div>
                    </div>-->


                    <div class="" id="slider_items_cover">
                        <?php
                            if ($slider_id) {
                                $items = $sys_slider->get_items();
                                foreach ($items as $item) { ?>

                                    <div class="sys_content">
                                        <img src="<?php echo plugins_url('../img/close.png',__FILE__); ?>" alt="close" class="sys_close" id="remove_slider_item"/>
                                        <input type="hidden" value="<?php echo $item->id; ?>" name="sys_slider_items_id[]" id="sys_slider_items_id">
                                        <input type="hidden" name="sys_media_id[]" value="<?php echo $item->media_id; ?>" id="sys_media_id" />
                                        <div class="img_wrap">
                                            <?php echo wp_get_attachment_image($item->media_id) ?>
                                        </div>
                                        <div class="img_field">
                                            <ul>
                                                <li><label class="sys-cl-30">Title: </label> <input type="text" value="<?php echo $item->title; ?>"  name="sys_slider_title[]" id="sys_slider_title"/></li>
                                                <li><label class="sys-cl-30">Links: </label> <input type="text" value="<?php echo $item->link; ?>"  name="sys_slider_links[]" id="sys_slider_links"/></li>
                                                <li><label class="sys-cl-30">Discription:</label><textarea name="sys_slider_desc[]" id="sys_slider_desc"><?php echo $item->description; ?></textarea></li>
                                            </ul>

                                        </div>
                                        <div class="clr"></div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="singsys_settings">
                    <!-- Option widgets -->
                    <div class="option_wrap">
                        <div class="sys_head">
                            <h3>Save Slider</h3>
                        </div>
                        <div class="sys_content">
                            <input type="submit" value="Save" class="button-primary pull-right"/>
                            <div class="clr"></div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <!-- End Option -->
                    <!-- Option widgets -->
                    <div class="option_wrap">
                        <div class="sys_head"><h3>Slider Options</h3> </div>
                        <div class="sys_content">
                            <ul class="option_list">
                                <li><label>Status</label>
                                    <p>Actice/ de-active</p>
                                    <select name="sys_slider[slider_status]" id="slider_status">
                                        <option value="y" <?php echo ($slider_option) ? ($slider_option['slider_status'] == 'y') ? '  selected="selected"' : '' : ''; ?> >Yes</option>
                                        <option value="n" <?php echo ($slider_option) ? ($slider_option['slider_status'] == 'n') ? '  selected="selected"' : '' : ''; ?>>No</option>
                                    </select>      
                                </li>
                                <li><label>Items</label>
                                    <p>This variable allows you to set the maximum amount of items displayed at a time with the widest browser width</p>
                                    <input type="number" id="items" value="<?php echo ($slider_option) ? $slider_option['items'] : 5; ?>" name="sys_slider[items]"/>

                                </li>
                                <li><label>Items Desktop</label>
                                    <p>between 1000px and 901px</p>
                                    <input type="number" id="itemsDesktop" value="<?php echo ($slider_option) ? $slider_option['itemsDesktop'] : 5; ?>" name="sys_slider[itemsDesktop]"/>
                                </li>
                                <li><label>Items Small Desktop</label>
                                    <p>betweem 900px and 601px</p>
                                    <input type="number" id="itemsDesktopSmall" value="<?php echo ($slider_option) ? $slider_option['itemsDesktopSmall'] : 3; ?>" name="sys_slider[itemsDesktopSmall]"/>

                                </li>
                                <li><label>Items Tablet</label>
                                    <p>between 600 and 479</p>
                                    <input type="number" id="itemsTablet" value="<?php echo ($slider_option) ? $slider_option['itemsTablet'] : 3; ?>" name="sys_slider[itemsTablet]"/>
                                </li>
                                <li>
                                    <label>Items Mobile</label>
                                    <p>between 480 and 0</p>
                                    <input type="number" id="items" value="<?php echo ($slider_option) ? $slider_option['itemsMobile'] : 1; ?>" name="sys_slider[itemsMobile]"/>
                                </li>
                                <li>
                                    <label>Single Item</label>
                                    <p>Display only one item</p>
                                    <select name="sys_slider[singleItem]" id="singleItem">
                                        <option value="yes" <?php echo ($slider_option) ? ($slider_option['singleItem'] == 'yes') ? '  selected="selected"' : '' : ''; ?> >Yes</option>
                                        <option value="no" <?php echo ($slider_option) ? ($slider_option['singleItem'] == 'no') ? '  selected="selected"' : '' : ''; ?>>No</option>
                                    </select>      
                                </li>
                                <li>
                                    <label>Slide Speed</label>
                                    <p>Slide speed in milliseconds</p>
                                    <input type="number" id="slideSpeed" value="<?php echo ($slider_option) ? $slider_option['slideSpeed'] : 200; ?>" name="sys_slider[slideSpeed]"/>
                                </li>
                                <li>
                                    <label>Pagination Speed</label>
                                    <p>Pagination speed in milliseconds</p>
                                    <input type="number" id="paginationSpeed" value="<?php echo ($slider_option) ? $slider_option['paginationSpeed'] : 800; ?>" name="sys_slider[paginationSpeed]"/>
                                </li>
                                <li>
                                    <label>Rewind Speed</label>
                                    <p>Rewind speed in milliseconds</p>
                                    <input type="number" id="rewindSpeed" value="<?php echo ($slider_option) ? $slider_option['rewindSpeed'] : 1000; ?>" name="sys_slider[rewindSpeed]"/>
                                </li>
                                <li>
                                    <label>Auto Play</label>
                                    <p>Change to any integrer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds.</p>
                                    <input type="text" id="autoPlay" value="<?php echo ($slider_option) ? $slider_option['autoPlay'] : 'false'; ?>" name="sys_slider[autoPlay]"/>
                                </li>
                                <li>
                                    <label>Stop On Hover</label>
                                    <p>Stop autoplay on mouse hover</p>
                                    <select name="sys_slider[stopOnHover]" id="stopOnHover">                                    
                                        <option value="no" <?php echo ($slider_option) ? ($slider_option['stopOnHover'] == 'no') ? '  selected="selected"' : '' : ''; ?>>No</option>
                                        <option value="yes" <?php echo ($slider_option) ? ($slider_option['stopOnHover'] == 'yes') ? '  selected="selected"' : '' : ''; ?>>Yes</option>
                                    </select>      
                                </li>
                                <li>
                                    <label>Navigation</label>
                                    <p>Display "next" and "prev" buttons.</p>
                                    <select name="sys_slider[navigation]" id="navigation">                                    
                                        <option value="no" <?php echo ($slider_option) ? ($slider_option['navigation'] == 'no') ? '  selected="selected"' : '' : ''; ?>>No</option>
                                        <option value="yes" <?php echo ($slider_option) ? ($slider_option['navigation'] == 'yes') ? '  selected="selected"' : '' : ''; ?>>Yes</option>
                                    </select>      
                                </li>
                                <li>
                                    <label>Pagination</label>
                                    <p>Show pagination.</p>
                                    <select name="sys_slider[pagination]" id="pagination">
                                        <option value="yes" <?php echo ($slider_option) ? ($slider_option['pagination'] == 'yes') ? '  selected="selected"' : '' : ''; ?>>Yes</option>
                                        <option value="no" <?php echo ($slider_option) ? ($slider_option['pagination'] == 'no') ? '  selected="selected"' : '' : ''; ?>>No</option>
                                    </select>      
                                </li>
                                <li>
                                    <label>Pagination Numbers</label>
                                    <p>Show numbers inside pagination buttons</p>
                                    <select name="sys_slider[paginationNumbers]" id="paginationNumbers">
                                        <option value="yes" <?php echo ($slider_option) ? ($slider_option['paginationNumbers'] == 'yes') ? '  selected="selected"' : '' : ''; ?>>Yes</option>
                                        <option value="no" <?php echo ($slider_option) ? ($slider_option['paginationNumbers'] == 'no') ? '  selected="selected"' : '' : ''; ?>>No</option>
                                    </select>      
                                </li>
                                <li>
                                    <label>Responsive</label>
                                    <p>You can use Owl Carousel on desktop-only websites too! Just change that to "false" to disable resposive capabilities</p>
                                    <select name="sys_slider[responsive]" id="responsive">
                                        <option value="yes" <?php echo ($slider_option) ? ($slider_option['responsive'] == 'yes') ? '  selected="selected"' : '' : ''; ?>>Yes</option>
                                        <option value="no" <?php echo ($slider_option) ? ($slider_option['responsive'] == 'no') ? '  selected="selected"' : '' : ''; ?>>No</option>
                                    </select>      
                                </li>
                                <li>
                                    <label>Responsive Base Width</label>
                                    <p>Owl Carousel check window for browser width changes. You can use any other jQuery element to check width changes for example ".owl-demo". Owl will change only if ".owl-demo" get new width.</p>
                                    <input type="text" id="responsiveBaseWidth" value="<?php echo ($slider_option) ? $slider_option['responsiveBaseWidth'] : 'window'; ?>" name="sys_slider[responsiveBaseWidth]"/>
                                </li>
                                <li>
                                    <label>Base Class</label>
                                    <p>Automaticly added class for base CSS styles. Best not to change it if you don't need to.</p>
                                    <input type="text" id="baseClass" value="<?php echo ($slider_option) ? $slider_option['baseClass'] : 'owl-carousel'; ?>" name="sys_slider[baseClass]"/>
                                </li>
                            </ul>
                            <div class="clr"></div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <!-- End Option -->
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">jQuery(function(){jQuery(".sortable").sortable({ handle: '.handle' });});</script>
<script type="text/javascript" src="<?php echo plugins_url('../script/media.js',__FILE__); ?>"></script>