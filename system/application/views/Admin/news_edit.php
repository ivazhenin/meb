<div class='news_edit'>
  <?=form_open('admin/newseditsave','',array('id'=>$id))?>
  <p>Заголовок новости</p>
  <?=form_input(array('name'=>'title', 'value'=>$title))?><br />
  <?=form_input(array('name'=>'pubdate','id'=>'pubdate', 'value'=>$pubdate))?><br />
  
  <?=form_textarea(array('name'=>'newstext','id'=>'newstext', 'value'=>$newstext, 'style'=>'height:400px;'))?><br />
  <?=form_dropdown('status', array('0'=>'Не опубликована', '1'=>'Опубликована'), $status)?><br />
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

  var editor;
  $(document).ready(function () {
		if({id}<0) $('#delete').hide();
    editor = $('#newstext').redactor({ css: ['news.css'] });

    $('form').ajaxForm({
      success: analyze
    });
		
    $('#pubdate').datepicker({dateFormat:'dd.mm.yy'});

    $('#delete').click(function () {
      if (confirm('Вы действительно хотите удалить новость?'))
        $.post('/admin/newsdelete/{id}', analyze);
    });
  });
</script>