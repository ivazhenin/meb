<h1>НОВОСТИ</h1>
<div class='news_list'>
	<a href="/admin/newsnew" style="border:1px solid #00f;padding:3px 10px;margin:3px;display:block;width:200px;text-align:center;background-color:#eee;">Добавить новость</a>
	<ul style='margin-top:15px;'>
		{newslist}
		<li><a href='/admin/newsedit/{id}' class='pub{status}'>{day}.{month}.{year} - {title}</a></li>
		{/newslist}
	</ul>
</div>
<div class='break'>
</div>
<div class="help">Список новостей, упорядоченный по убыванию даты. При нажатии на соответствующую строку происходит переход к редактированию новости.</div>

<script type="text/javascript">
  $(document).ready(function () {
  });
</script>
