<div id="content_heading">
<h1><?php echo $html->link('Login', '/users/login'); ?></h1>
</div>
<div id="single_column">
<?php
    echo $session->flash('auth');
    echo $form->create('User', array('action' => 'login'));
    echo $form->input('username');
    echo $form->input('password');
    echo $form->end('Login');

    echo '<br />';
    echo '<div id="forgot_password_box">';
    echo $html->link('Forgot your password?', '/users/forgot_your_password');
    echo '</div>';
?>
</div>
