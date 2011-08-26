<h1>БАННЕРЫ</h1>
<a href="/admin/banupload" style="border:1px solid #00f;padding:3px 10px;margin:3px;display:block;width:200px;text-align:center;background-color:#eee;">Добавить новый банер</a><br />
<?php echo $this->pagination->create_links(); ?>
<div class='ban_list'>
{banners}
<div class='banners sh{showed}'><div class='img' type='{type}' url='/bann/{filename}'></div><p>{ds}.{ms}.{ys} - {de}.{me}.{ye}</p><a href='/admin/banedit/{id}'>Изменить</a> <a href='/admin/bandel/{id}'>Удалить</a></div>
{/banners}
</div>
<div class='break'></div>
<?php echo $this->pagination->create_links(); ?>
<div class="help">Управление загруженными банерами. В данном окне отображается список загруженных банеров постранично с разбивкой по 10 банеров на страницу. Сортировка осуществляется по статусу отображения. Рамка блока банера показывает статус отображения: зеленый - банер отображается, красный - не отображается.</div>

<script type="text/javascript">
  $(document).ready(function () {
    $('.img[type="swf"]').each(function () { $(this).flash({ swf: $(this).attr('url'), height:180 }); });
    $('.img[type="jpg"]').each(function () { $('<img/>').attr('src', $(this).attr('url')).css('height', '180px').appendTo($(this)); });
    $('.img[type="png"]').each(function () { $('<img/>').attr('src', $(this).attr('url')).css('height', '180px').appendTo($(this)); });
  });
</script>