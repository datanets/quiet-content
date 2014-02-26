<div id="content_heading">

<h1><?php echo $html->link('File Manager', '/file_managers'); ?></h1>
<?php echo $html->link('+ New Folder', '/' . $this->params['url']['url'] . '#page_bottom', array('id' => 'new_folder')); ?>
&nbsp;&nbsp;&nbsp;
<?php echo $html->link('+ Upload File', '/' . $this->params['url']['url'] . '#top', array('id' => 'upload_file')); ?>
&nbsp;&nbsp;&nbsp;
</div>

<div id="details_message" title="Details">
Details go here...
</div>

<div id="rename_message" title="Rename">
Rename goes here...
</div>

<div id="upload_file_message" title="Upload">
<label>File to Upload:</label><form id="FileUploadForm" enctype="multipart/form-data" method="post" action="<?php echo $site_base_url ?>file_managers/upload_file"><input type="file" name="upload_this_file" id="upload_this_file" /></form><br /><br />
<div id="upload_file_throbber"></div>
</div>


<?php
    echo $form->create('FileManager', array('action' => 'remove'));
?>
<div id="single_column">
<div id="file_manager_box">
<?php

    echo '<ul class="file_manager connectedSortable">';
    if ($handle = opendir($dir_root)) {
    
        while (false !== ($file = readdir($handle))) {

            // skip some unnecessary files
            if ($file != '.' && $file != '..' && $file != '.DS_Store') {

                // check if file or dir
                if (is_dir($dir_root . $file)) {

                    // check for protected folders...
                    if (in_array($dir_root . $file, $protected_folders) || in_array($dir_root . $file . '/', $protected_folders)) {

                        echo '<li id="' . str_replace('/', '__', $dir_root . $file) . '"><img src="' . $site_base_url . 'img/protected_folder_16.gif" /><a href="' . $this->params['url']['url'] . '?path=' . $file . '" class="directory">' . $file .'</a>';
                        echo '<div class="throbber"></div>
                        <ul class="file_manager connectedSortable">
                            <li class="folder_place_holder"></li>
                        </ul>
                        </li>';

                    } else {
$safe_filename = str_replace(' ', '----', $file);
//$safe_filename = $file;
                        echo '<li id="' . str_replace('/', '__', $dir_root . $safe_filename) . '"><img src="' . $site_base_url . 'img/folder_16.gif" /><a href="' . $this->params['url']['url'] . '?path=' . $safe_filename . '" class="directory">' . $file .'</a>';
                        echo '<div class="category_options"><a href="file_managers#rename" class="rename_item">Rename</a> | <a href="' . $site_base_url . 'file_managers/delete_item/' . str_replace('/', '__', $dir_root . $file) . '" class="delete_item">Delete</a></div>';
                        echo '<div class="throbber"></div>
                        <ul class="file_manager connectedSortable">
                            <li class="folder_place_holder"></li>
                        </ul>
                        </li>';

                    }

                } else {

                    echo '<li id="' . str_replace('/', '__', $dir_root . $file) . '"><img src="' . $site_base_url . 'img/file_16.gif" />' . $file;
                    echo '<div class="category_options"><a href="file_managers#rename" class="file_details">Details</a> | <a href="file_managers#rename" class="rename_item">Rename</a> | <a href="' . $site_base_url . 'file_managers/delete_item/' . str_replace('/', '__', $dir_root . $file) . '" class="delete_item">Delete</a></div>';
                    echo '</li>';

                }

            }   

        }   
        closedir($handle);
    }   
    echo '</ul>';

?>
</div>
</div>

<?php
    echo $form->end();
?>

<form name="url_information_for_javascript">
<input type="hidden" id="site_base_url" value="<?php echo $site_base_url; ?>" />
<input type="hidden" id="uploads_base_url" value="<?php echo $uploads_base_url; ?>" />
<input type="hidden" id="uploads_base_dir" value="<?php echo $uploads_base_dir; ?>" />
</form>

<a name="page_bottom"></a>

