<div class='mainInfo'>
	<div class="pageTitle">Вход в систему</div>
  <div class="pageTitleBorder"></div>
	<p>Введите Ваш email address и пароль ниже.</p>
	<div id="infoMessage"><?php echo $message;?></div>
  <?php echo form_open("/admin/login");?>
  <p>
    <label for="email">Email:</label>
    <?php echo form_input($email);?>
  </p>
  <p>
    <label for="password">Пароль:</label>
    <?php echo form_input($password);?>
  </p>
  <p>
	  <label for="remember">Запомнить:</label>
	  <?php echo form_checkbox('remember', '1', FALSE);?>
	</p>
  <p><?php echo form_submit('submit', 'Войти');?></p>
  <?php echo form_close();?>
</div>
