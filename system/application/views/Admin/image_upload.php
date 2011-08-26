<div class='img_edit'>
  <?=form_open_multipart('admin/imgupload')?>
  <p>Выберите файл для загрузки</p>
  <?=form_upload(array('name'=>'file'))?><br />
  <input type="submit" value='Загрузить' />
  <?=form_close()?>
</div>
<div class="help">Выберите изображение для загрузки. Поддерживаемые форматы: jpeg и png. После загрузки автоматически формируется миниатюра изображения.</div>
