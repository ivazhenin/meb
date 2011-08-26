<div class='page_edit'>
  <?=form_open('admin/pageeditsave','',array('id'=>$id))?>
  <p>Заголовок страницы</p>
  <?=form_input(array('name'=>'titlepage', 'value'=>$titlepage))?><br />
  <p>Наименование</p>
  <?=form_input(array('name'=>'title', 'value'=>$title))?><br />
  <p>Ключевые слова</p>
  <?=form_input(array('name'=>'keywords', 'value'=>$keywords))?><br />
  <p>Описание</p>
  <?=form_textarea(array('name'=>'description', 'value'=>$description, 'style'=>'height:50px;'))?><br />
  <?=form_textarea(array('name'=>'content','id'=>'content', 'value'=>'', 'style'=>'height:400px;'))?><br />
  <?=form_dropdown('menu', array('0'=>'Не использовать в меню', '1'=>'Использовать в горизонтальном меню', '2'=>'Использовать в выпадающем меню'), $menu)?><br />
  <input type="submit" id='save' disabled value='Сохранить' /><input type="button" id='delete' value="Удалить" />
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
		if({id}<0) {$('#delete').hide(); $('#save').removeAttr('disabled'); }
    editor = $('#content').redactor({css:['editor.css']});
    if({id}>0)
      $.post('/admin/pageload/{id}', function (data) {
			  editor.setHtml(data.page);
				$('#save').removeAttr('disabled'); 
			}, 'json');

    $('form').ajaxForm({
      success: analyze
    });

    $('#delete').click(function() {
      if(confirm('Вы действительно хотите удалить страницу?'))
        $.post('/admin/pagedelete/{id}', analyze);
    });
  });
</script>