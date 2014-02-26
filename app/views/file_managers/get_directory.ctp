<?php

    $filename = str_replace('__', '/', $_GET['path']);
    $filename = str_replace('----', ' ', $filename);
    $filename_path = explode('/', $filename);

    // check for protected folders...
    if (in_array($filename, $protected_folders) || in_array($filename . '/', $protected_folders)) {

?>
<img src="<?php echo $site_base_url ?>img/protected_folder_16.gif" /><a href="<?php echo str_replace('/get_directory', '', $this->params['url']['url']) ?>?path=<?php echo $_GET['path'] ?>" class="directory_open"><?php echo end($filename_path); ?></a>
<?php

    } else {

?>
<img src="<?php echo $site_base_url ?>img/folder_16.gif" /><a href="<?php echo str_replace('/get_directory', '', $this->params['url']['url']) ?>?path=<?php echo $_GET['path'] ?>" class="directory_open"><?php echo end($filename_path); ?></a>
<div class="category_options"><a href="file_managers#rename" class="rename_item">Rename</a> | <a href="<?php echo $site_base_url ?>file_managers/delete_item/<?php echo str_replace('/', '__', $dir_root . end($filename_path)) ?>" class="delete_item">Delete</a></div>
<?php
    }
?>
<div class="throbber"></div>
<?php

    echo '<ul class="file_manager connectedSortable">';
    echo '<li class="folder_place_holder"></li>';

    $path = str_replace('__', '/', $path);
    //$path = str_replace('_', ' ', $path);   // for items with spaces in the name...

    if ($handle = opendir($path)) {
    
        while (false !== ($file = readdir($handle))) {
            
            // skip some unnecessary files
            if ($file != '.' && $file != '..' && $file != '.DS_Store' && !in_array($users_base_dir . $file, $all_users_dirs)) {
            
                    $converted_path = str_replace('__', '/', $path);
                    $full_converted_path = str_replace('/', '__', $path . '__' . $file);
                    $full_converted_path = str_replace(' ', '-----', $full_converted_path);
                    $full_unconverted_path = str_replace('/', '__', $full_converted_path);
                    //$full_unconverted_path = str_replace('-----', ' ', $full_unconverted_path);


                    $regular_path = str_replace('__', '/', $path . '__' . $file);
                    $regular_path_converted = str_replace('/', '__', $regular_path);
                    $regular_path_converted = preg_replace("/\s+/", '----', $regular_path_converted);


                // check if file or dir
                if (is_dir(str_replace('__', '/', $path . '__' . $file))) {

                    // check for protected folders...
                    if (in_array($converted_path . '/' . $file, $protected_folders) || in_array($converted_path . '/' . $file . '/', $protected_folders)) {

                        echo '<li id="' . $regular_path_converted . '"><img src="' . $site_base_url . 'img/folder_16.gif" /><a href="' . $this->params['url']['url'] . '?path=' . $regular_path_converted . '" class="directory">' . $file . '</a>';
                        echo '<div class="throbber"></div>
                        <ul class="file_manager connectedSortable">
                            <li class="folder_place_holder"></li>
                        </ul>
                        </li>';

                    } else {


                        echo '<li id="' . $regular_path_converted . '"><img src="' . $site_base_url . 'img/folder_16.gif" /><a href="' . $this->params['url']['url'] . '?path=' . $regular_path_converted . '" class="directory">' . $file . '</a>';
                        echo '<div class="category_options"><a href="file_managers#rename" class="rename_item">Rename</a> | <a href="' . $site_base_url . 'file_managers/delete_item/' . $full_converted_path . '" class="delete_item">Delete</a></div>';
                        echo '<div class="throbber"></div>
                        <ul class="file_manager connectedSortable">
                            <li class="folder_place_holder"></li>
                        </ul>
                        </li>';

                    }

                } else {

                    echo '<li id="' . $regular_path_converted . '"><img src="' . $site_base_url . 'img/file_16.gif" />' . $file;
                    echo '<div class="category_options"><a href="file_managers#rename" class="file_details">Details</a> | <a href="file_managers#rename" class="rename_item">Rename</a> | <a href="' . $site_base_url . 'file_managers/delete_item/' . $full_converted_path . '" class="delete_item">Delete</a></div>';
                    echo '</li>';

                }

            }  

        }  
        closedir($handle);
    }  
    echo '</ul>';

?>
