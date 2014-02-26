<?php

App::import('Sanitize');

class FileManagersController extends AppController {

	var $name = 'FileManagers';
    var $layout = 'admin';
    var $uses = array('FileManager', 'User');


    function beforeFilter() {
        $this->disableCache();
        parent::beforeFilter();
    }

    function index() {

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $this->set('title_for_layout', 'File Manager');

            $dir_root = Configure::read('site_uploads_base_dir');
            $this->set('dir_root', $dir_root);
            $this->set('protected_folders', Configure::read('protected_folders'));

            $protected_folders = Configure::read('protected_folders');
            $user = $this->Session->read('Auth.User');
            $users_base_dir = Configure::read('users_base_dir');

            $protected_folders[count($protected_folders)] = $users_base_dir . $user['username'] . '/';
     

            if (isset($_GET['path'])) {
                $path = $_GET['path'];
                $this->set('path', $path);
            } else {
                $path = '';
                $this->set('path', $path);
            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function get_directory() {

        $this->layout = 'ajax';

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $dir_root = Configure::read('site_uploads_base_dir');
            $this->set('dir_root', $dir_root);

            // This section makes sure we add the current user to the protected folders list
            // and also makes sure we can't view/rename/delete another users' files.

            $protected_folders = Configure::read('protected_folders');
            $user = $this->Session->read('Auth.User');
            $users_base_dir = Configure::read('users_base_dir');

            $protected_folders[count($protected_folders)] = $users_base_dir . $user['username'] . '/';

            $all_users = $this->User->find('all', array('fields' => array('id', 'username')));

            $all_users_dirs = array();

            for($i=0; $i<count($all_users); $i++) {
                if ($all_users[$i]['User']['username'] != $user['username'])
                    $all_users_dirs[$i] = $users_base_dir . $all_users[$i]['User']['username'];
            }

            $this->set('protected_folders', $protected_folders);
            $this->set('users_base_dir', $users_base_dir);
            $this->set('all_users_dirs', $all_users_dirs);


            $path = $_GET['path'];
            $path = str_replace('----', ' ', $path);
            $this->set('path', $path);

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }


    }

    function move_item($source, $destination) {

        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $dir_root = Configure::read('site_uploads_base_dir');

            $source = Sanitize::escape($_GET['source']);
            $destination = Sanitize::escape($_GET['destination']);

            if (!$destination)
                $destination = $dir_root;

            // replace __ with /
            $source = preg_replace("/\_\_/", "/", $source);
            $source = preg_replace("/\-\-\-\-/", " ", $source); // for spaces in folder/file name
            $destination = preg_replace("/\_\_/", "/", $destination);
            $destination = preg_replace("/\-\-\-\-/", " ", $destination);   // for spaces in folder/file name


            // This section makes sure we add the current user to the protected folders list
            // and also makes sure we can't view/rename/delete another users' files.

            $protected_folders = Configure::read('protected_folders');
            $user = $this->Session->read('Auth.User');
            $users_base_dir = Configure::read('users_base_dir');

            //$protected_folders[count($protected_folders)] = $users_base_dir . $user['username'] . '/';

            $all_users = $this->User->find('all', array('fields' => array('id', 'username')));

            $all_users_dirs = array();

            for($i=0; $i<count($all_users); $i++) {
                if ($all_users[$i]['User']['username'] != $user['username'])
                    $all_users_dirs[$i] = $users_base_dir . $all_users[$i]['User']['username'];
            }

            if (in_array($source, $protected_folders) || in_array($source . '/', $protected_folders)) {

                // do nothing (you are not allowed...)

            } else {

                // get actual file name we are moving
                $source_array = explode('/', $source);
                $destination = $destination . '/' . end($source_array);


                if ($source && $destination) {
                    rename($source, $destination);
                }

            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function rename_item() {

        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $source_path = Sanitize::escape($_GET['source_path']);
            $destination_path = Sanitize::escape($_GET['destination_path']);

            $source_path = str_replace('__', '/', $source_path);
            $source_path = preg_replace("/\-\-\-\-/", " ", $source_path); // for spaces in folder/file name
            $destination_path = str_replace('__', '/', $destination_path);
            $destination_path = preg_replace("/\-\-\-\-/", " ", $destination_path); // for spaces in folder/file name

            if ($source_path && $destination_path) {
                rename($source_path, $destination_path);
            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function delete_item() {

        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $delete_this = $_GET['item'];
            $delete_this = str_replace('__', '/', $delete_this);
            $delete_this = preg_replace("/\-\-\-\-/", " ", $delete_this); // for spaces in folder/file name

            $base_upload_dir = Configure::read('site_uploads_base_dir');

            // double-check we are at least in uploads base dir... (no bad dreams... no bad dreams...)
            str_replace($base_upload_dir, $base_upload_dir, $delete_this, $test_base_dir);

            // delete item
            if ($delete_this > '' && count($test_base_dir) > 0) {
                if (is_dir($delete_this))
                    rmdir ($delete_this);
                else
                    unlink ($delete_this);
            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function new_folder() {

        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $base_upload_dir = Configure::read('site_uploads_base_dir');

            $new_folder_name = 'Untitled Folder';

            // Check for existing Untitled Folder folders first...
            if (is_dir($base_upload_dir . '/' . $new_folder_name)) {
                for ($i = 1; $i < 26; $i++) {
                    if (is_dir($base_upload_dir . '/' . $new_folder_name . ' ' . $i)) {
                    } else {
                        $new_folder_name = $new_folder_name . ' ' . $i;
                        break;
                    }
                }
            }

            mkdir($base_upload_dir . '/' . $new_folder_name, 0777);
            chmod($base_upload_dir . '/' . $new_folder_name, 0777);

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function upload_file() {

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $base_upload_dir = Configure::read('site_uploads_base_dir');
            $messages = '';

            if (isset($_FILES) && count($_FILES) > 0) {
                foreach ($_FILES as $k => $v) :

                    if ( isset($v['tmp_name']) ) {
                        if ( isset($v['name']) && $v['name'] > '') {

                            // clean filename
                            $clean_filename = $v['name'];
                            $clean_filename = preg_replace("/[^0-9A-Za-z\.\+\_]+/", "-", $clean_filename);

                            if (move_uploaded_file($v['tmp_name'], $base_upload_dir . $clean_filename)) {
                                chmod($base_upload_dir . $clean_filename, 0777);
                                $messages .= 'File successfully uploaded.';
                            } else {
                                $messages .= 'Sorry, the file could not be uploaded.';
                            }

                        }
                    } else {

                        $messages .= 'Sorry, the file could not be uploaded.';

                    }

                endforeach;
            }

            $this->Session->setFlash($messages);
            $this->redirect(array('action' => 'index'));


        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }


}

?>
