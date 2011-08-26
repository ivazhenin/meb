<div class='img_edit'>
  <?=form_open_multipart('admin/banupload')?>
  <p>Выберите файл для загрузки</p>
  <?=form_upload(array('name'=>'file'))?><br />
  <input type="submit" value='Загрузить' />
  <?=form_close()?>
</div>
<div class="help">Загрузите на сервер новый банер. Поддерживаются изображения jpeg, png и ролики Flash. При загрузке изображение автоматически масштабируется. Переход по ссылке из роликов Flash возможен только в случае, если он прописан в ролике.</div>
