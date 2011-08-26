<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>CMS</title>

  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content=" " />

  <script src="/js/jquery-1.6.1.min.js" type="text/javascript"></script>
  <script src="/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript"></script>
  <link href="/css/styles.css" rel="stylesheet" type="text/css" />
  <link href="/css/jquery-ui-1.8.13.custom.css" rel="stylesheet" type="text/css" />
  <script src="/js/redactor/redactor.js" type="text/javascript"></script>
  <script src="/js/jquery.form.js" type="text/javascript"></script>
  <script src="/js/jquery.dynatree.js" type="text/javascript"></script>
  <link href="/css/skin/ui.dynatree.css" rel="stylesheet" type="text/css" />
  <script src="/js/jquery.tmpl.min.js" type="text/javascript"></script>
  <link href="/js/redactor/css/redactor.css" rel="stylesheet" type="text/css" />
  <script src="/js/jquery.swfobject.1-1-1.min.js" type="text/javascript"></script>
  <script src="/js/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
</head>
<body>
  <div class='left'>
    <h1><a href='/admin'>{user}</a></h1>
    <ul>
      <li><a href='/admin/pages'>Структура/контент</a>
        <ul>
          <li><a href='/admin/pagenew'>Новая страница</a></li>
        </ul>
      </li>
      <!--<li><a href='/admin/news'>Новости</a>
        <ul>
          <li><a href='/admin/newsnew'>Добавить новость</a></li>
        </ul>
      </li>
      <li><a href='/admin/banners'>Банеры</a>
        <ul>
          <li><a href='/admin/banupload'>Добавить новый банер</a></li>
        </ul>
      </li>-->
      <li><a href='/admin/images'>Галерея</a>
        <ul>
          <li><a href='/admin/imgupload'>Загрузка</a></li>
        </ul>
      </li>
      <li><a href='/admin/templates'>Элементы страниц</a>
      </li>
<!--      <li><a href='/admin/files'>Управление файлами</a>
        <ul>
          <li><a href='#'>Загрузка</a></li>
        </ul>
      </li>
-->		<li style="height:25px;"></li>
      <li><a href='/admin/logout'>Выход из системы</a>
      </li>
    </ul>
    <p>{elapsed_time}</p>
  </div>
  <div class='center'>
    <div class='content'>{content}</div>
  </div>
  <script type='text/javascript'>
    $(document).ready(function () {
    });

    function ShowModal(title, html, handler) {
      var dialog = $('<div/>');
      dialog.attr('title', title).html(html).appendTo($('body'));
      dialog.dialog({
        width: '70%',
        beforeClose: function () { if (handler != null) handler(); },
        close: function () { dialog.remove(); },
        modal: true
      });
    }
  </script>
</body>
</html>
