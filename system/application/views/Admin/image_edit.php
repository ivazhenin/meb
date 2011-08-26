<div class='img_edit'>
  <img src='/images/{thumbname}' alt='' />
  <p>Код для вставки изображения в текст:</p>
  <input type='text' value="<img src='/images/{filename}' alt='' />" style='width:400px;'/>
  <p>Код для вставки миниатюры в текст:</p>
  <input type='text' value="<img src='/images/{thumbname}' big='/images/{filename}' alt='' />" style='width:400px;'/>
  <?=form_open('admin/imgeditsave','',array('id'=>$id))?>
  <p>Комментарий</p>
  <?=form_input(array('name'=>'comment', 'value'=>$comment))?><br />
  <input type="submit" value='Сохранить' /><input type="button" id='delete' value="Удалить" />
  <?=form_close()?>
</div>
<script type="text/javascript">
  function analyze(data) {
    var err = $.parseJSON(data);
    if (err.refresh)
      location.href = '{back_link}';
    else 
      alert(err.error);
  }
  $(document).ready(function () {
    $('form').ajaxForm({
      success: analyze
    });
    $('#delete').click(function () {
      if (confirm('Вы действительно хотите удалить изображение?'))
        $.post('/admin/imgdelete/{id}', analyze);
    });
    $('input[type="text"]').focus(function () { $(this).select(); });
  });
</script>