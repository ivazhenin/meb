<h1>Новости ЛК "Оптимальный вариант"</h1>
<div id='news'>
<?php if(isset($news)): ?>
{news}
<p><span>{day}.{month}.{year}</span><br /> {title} <a href='/welcome/news/{id}'>>>></a></p>
{/news}
<?php else: ?>
<h2>{title}</h2><span>{day}.{month}.{year}</span><p>{newstext}</p>
<?php endif; ?></div>

<h1>Транспортные новости</h1>
<script src="http://news.yandex.ru/common.js"></script><script>                                                         m_index = false;</script><script src="http://news.yandex.ru/transport5.utf8.js" type="text/javascript" charset="utf-8"></script><script>                                                                                                                                                                                               str = '<div class=yandex_title><a href=http://news.yandex.ru><b>Яндекс.Новости</b></a></div>'; if ((aObj = eval('m_transport')) && (aObj.length > 0)) {
                                                                                                                                                                                                 aObj.sort(compareTime); for (j = 0; j < aObj.length; j++) {
                                                                                                                                                                                                   str += '<div><span class=yandex_news_title><a href=' + aObj[j].url + '>' + aObj[j].title + '</a></span></div><div class=yandex_annotation>' + aObj[j].descr + '</div>';
                                                                                                                                                                                                 } str += '<div class=yandex_allnews><a href=http://news.yandex.ru>Все новости на ' + update_time + ' мск  &gt;&gt;</a></div>'; document.write(str);
                                                                                                                                                                                               }</script>