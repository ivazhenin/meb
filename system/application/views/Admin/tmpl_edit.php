<div class='page_edit'>
  <?=form_open('admin/tmpleditsave','',array('id'=>$id))?>
  <?=form_textarea(array('name'=>'value','id'=>'value', 'value'=>'', 'style'=>'height:400px;'))?><br />
  <input type="submit" value='Сохранить' />
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
    editor = $('#value').redactor({css:['{css}.css']});
    if({id}>0)
      $.post('/admin/tmplload/{id}', function (data) { editor.setHtml(data.value); }, 'json');

    $('form').ajaxForm({
      success: analyze
    });
  });
</script>