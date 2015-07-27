<?php
    $dir = plugin_dir_path(__DIR__);
    $class_file = $dir . 'admin_class.php';
    if (file_exists($class_file)) {
        include_once($class_file);

        $sys_slider_list = new singsys_slider;
        $lists = $sys_slider_list->get_slider_list();
    }
    ?>

    <div class="wrap">
        <h2>
            All Slider
            <a class="add-new-h2" href="?page=singsys_new_slider">Add New</a>
        </h2>
        <ul class="subsubsub">
            <li class="all"><a class="current" href="admin.php?page=singsys_slider">All <span class="count">(<?php echo count($lists); ?>)</span></a></li>
        </ul>
        <?php 
            $columns = '<tr>
                <th class="manage-column column-cb check-column"><input type="checkbox" id="cb-select-all-1"></th>
                <th>Name</th>
                <th>Shortcode</th>
                <th>No. of Slides</th>
            </tr>';
        ?>
        <table class="wp-list-table widefat fixed striped sliders">
            <thead><?php _e($columns); ?></thead>
            <tbody>
                <?php foreach ($lists as $list): ?>
                    <tr>
                        <td></td>
                        <td class="slider-title slider-title column-title">
                            <strong><a title="Edit “<?php echo $list->title; ?>”" href="?page=singsys_new_slider&id=<?php echo $list->id; ?>" class="row-title"><?php echo $list->title; ?></a></strong>
                            <div class="locked-info">
                                <span class="locked-avatar"></span> 
                                <span class="locked-text"></span>
                            </div>
                            <div class="row-actions">
                                <span class="edit">
                                    <a title="Edit this item" href="?page=singsys_new_slider&id=<?php echo $list->id; ?>">Edit</a> | 
                                </span>
                                <span class="trash">
                                    <a href="?page=singsys_slider&dltId=<?php echo $list->id; ?>" title="Move this item to the Trash" class="submitdelete">Trash</a>
                                </span>
                            </div>
                        </td>
                        <th>[singsys_slider id="<?php echo $list->id; ?>"]</th>
                        <td>(<?php echo $sys_slider_list->count_items($list->id); ?>) <i>slides</i></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot><?php _e($columns); ?></tfoot>
        </table>

    </div>

