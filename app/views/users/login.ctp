 <?php
if ($session->check('Message.auth')) $session->flash('auth');
echo $form->create('User', array('action' => 'new_user_session'));
echo $form->input('username');
echo $form->input('password');
echo $form->input('auto_login', array('type' => 'checkbox', 'label' => 'Log me in automatically?')); 
echo $form->end('Login');
?>
