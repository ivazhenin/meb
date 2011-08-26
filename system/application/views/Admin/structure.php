<h1>СТРУКТУРА/КОНТЕНТ</h1>
<a href="/admin/pagenew" style="border:1px solid #00f;padding:3px 10px;margin:3px;display:block;width:200px;text-align:center;background-color:#eee;">Добавить страницу</a>
<div class='pages_list'>
</div>
<div class='break'>
</div>
<div class="help">Древовидная структура страниц сайта. Редактируется перетаскиванием элементов (страниц). При двойном нажатии на заголовок страницы осуществляется переход к редактированию соответствующей страницы.</div>

<script type="text/javascript">
  function ajaxerror(jqXHR, textStatus, errorThrown) {
    alert(textStatus);
    $('.pages_list').dynatree("getTree").reload();
  }

  $(document).ready(function () {
    $(".pages_list").dynatree({
      initAjax: {
        url: "/admin/pagesload"
      },
      dnd: {
        onDragStart: function (node) {
          return true;
        },
        onDragStop: function (node) {
          var par = node.parent.data.key;
          var id = node.data.key;
          var children = node.parent.getChildren();
          var res = '';
          for (key in children)
            res += children[key].data.key + ";";
          $.post('/admin/pagesmove', { 'id': id, 'par': par }, function (data) { if (!data.success) ajaxerror(null, 'error'); else $.post('/admin/pagesord', { 'arr': res }, function (data) { if (!data.success) ajaxerror(null, 'error'); }, 'json').error(ajaxerror); }, 'json').error(ajaxerror);
        },
        autoExpandMS: 1000,
        preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
        onDragEnter: function (node, sourceNode) {
          return true;
        },
        onDragOver: function (node, sourceNode, hitMode) {
        },
        onDrop: function (node, sourceNode, hitMode, ui, draggable) {
          sourceNode.move(node, hitMode);
        },
        onDragLeave: function (node, sourceNode) {
        }
      },
      onClick: function (node, event) {
        logMsg("onClick(%o, %o)", node, event);
        if (event.shiftKey && node.isLazy)
          alert("ctrl");
        //return false;
      },
      onDblClick: function (node, event) {
        var id = node.data.key;
        location.href = '/admin/pageedit/' + id;
      }
    });
  });
</script>
