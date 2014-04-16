<?php
class PreferencesController extends AppController
{
    var $name = 'Preferences';
    var $layout = 'admin';

    function beforeFilter()
    {
        $this->disableCache();
        parent::beforeFilter();
    }

    function list_all()
    {
        return $this->Preference->find('list',
            array(
                'fields' => array('Preference.name'),
                'cache' => 'preferenceList'
            )
        );
    }

    function index()
    {
        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 3) {
            $this->set('title_for_layout', 'Preferences');
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function create()
    {
        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] == 1) {
            $this->set('title_for_layout', 'Preferences : New');
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function edit()
    {
    }

    function remove()
    {
        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] == 1) {
            $this->autorender = false;
            $warnings = '';

            foreach ($this->data['Preference'] as $key => $value) {
                if ($value == 1) {
                    $delete_this = preg_replace("/Preference|delete/", "", $key);

                    if ($this->Preference->delete($delete_this, false)) {
                        // clean cache for lists
                        Cache::delete('Preference-preferenceList');
                    } else {
                        $warnings .= 'Sorry, a preference couldn\'t be deleted.' . "\n";
                    }
                } else {
                    // do not delete
                }
            }

            if ($warnings != '')
                $this->Session->setFlash($warnings);
            else
                $this->Session->setflash('Selected preferences deleted.');

            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function website()
    {
        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] == 1) {
            $this->set('title_for_layout', 'Preferences : Website');

            if (empty($this->data)) {
                $this->set('preferences', $this->Preference->find('first'));

                // get current website theme!
                $dir_root = Configure::read('website_theme_dir');
                $themes_array = array();

                if ($handle = opendir($dir_root)) {
                    while (false !== ($file = readdir($handle))) {
                        // skip some unnecessary files
                        if ($file != '.' && $file != '..' && $file != '.DS_Store') {
                            if (is_dir($dir_root . '/' . $file))
                                $themes_array[$file] = $file;
                        }
                    }
                }

                $this->set('website_themes', array($themes_array));
            } else {
                if ($this->Preference->saveAll($this->data)) {
                    $this->Session->setFlash('Your preferences have been saved.');
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('Sorry, there was a problem saving preferences.');
                    $this->redirect(array('action' => 'website'));
                }
            }
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function widgets()
    {
        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] == 1) {
            $this->set('title_for_layout', 'Preferences : Website');
            $this->set('preferences', $this->Preference->find('first'));
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    // clear website cache folder
    function clear_cache()
    {
        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {
            if (CACHE > '') {
                // sweep away old cache files because this is part of header
                $dir = CACHE.'views'.DS;
                if (!$dh = @opendir($dir)) return;
                while (false !== ($file = readdir($dh))) {
                    if ($file == '.' || $file == '..' || $file == 'empty') continue;
                    unlink ($dir.DS.$file);
                }
                closedir($dh);

                $this->Session->setFlash('Website cache has been cleared.');
                $this->redirect('/preferences');
            }
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/preferences');
        }
    }
}
?>
