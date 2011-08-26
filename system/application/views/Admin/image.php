<h1>ГАЛЕРЕЯ</h1>
<a href="/admin/imgupload" style="border:1px solid #00f;padding:3px 10px;margin:3px;display:block;width:200px;text-align:center;background-color:#eee;">Загрузить изображение</a><br />
<?php echo $this->pagination->create_links(); ?>
<div class='img_list'>
{images}
  <a href='/admin/imgedit/{id}'><img src='/images/{thumbname}' alt='' /></a>
{/images}
</div>
<div class='break'></div>

<?php echo $this->pagination->create_links(); ?>
<div class="help">Управление изображениями галереи. В данном окне отображается список изображений постранично с разбивкой по 10 изображений на страницу. Сортировка осуществляется по дате загрузки. При нажатии на изображение происходит переход на страницу редактирования свойств изображения.</div>
<script type="text/javascript">
  $(document).ready(function () {
    
  });
</script>