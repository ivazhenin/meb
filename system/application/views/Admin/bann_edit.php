<div class='img_edit'>
  <div class='img' type='{type}' url='/bann/{filename}'></div>
  <?=form_open('admin/baneditsave','',array('id'=>$id))?>
  <p>Адрес перехода (работает для не Flash форматов)</p>
  <?=form_input(array('name'=>'url', 'value'=>$url))?><br />
  <p>Даты показа:</p>
  С <?=form_input(array('name'=>'startdate', 'value'=>"{$ds}.{$ms}.{$ys}", 'style'=>'width:150px'))?>
   по <?=form_input(array('name'=>'enddate', 'value'=>"{$de}.{$me}.{$ye}", 'style'=>'width:150px'))?><br />
  <p>Комментарий</p>
  <?=form_input(array('name'=>'comment', 'value'=>$comment))?><br />
  <input type="submit" value='Сохранить' /><input type="button" id='delete' value="Удалить" />
  <?=form_close()?>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    $('.img[type="swf"]').each(function () { $(this).flash({ swf: $(this).attr('url'), height:180 }); });
    $('.img[type="jpg"]').each(function () { $('<img/>').attr('src', $(this).attr('url')).css('height', '180px').appendTo($(this)); });
    $('.img[type="png"]').each(function () { $('<img/>').attr('src', $(this).attr('url')).css('height', '180px').appendTo($(this)); });
  });

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
      if (confirm('Вы действительно хотите удалить баннер?'))
        $.post('/admin/bandelete/{id}', analyze);
    });
    $('input[type="text"]').focus(function () { $(this).select(); });
    $('input[name="startdate"]').datepicker({ dateFormat: 'dd.mm.yy' });
    $('input[name="enddate"]').datepicker({ dateFormat: 'dd.mm.yy' });
  });
</script>