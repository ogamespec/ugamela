<?
include_once "../../administrator/baglan.php";
?>
<?
$sql=mysql_query("select id, aciklama from duyuru order by tarih desc limit 0, 10");
for ($di=0; $di<mysql_num_rows($sql); $di++) {
  $fa=mysql_fetch_array($sql);
  echo "<li><a href=\"javascript: void(0);\" onClick=\"javascript: window.open('duyurupop.php?ID=$fa[id]', 'duyuru', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=400,height=220');\"><font style=\"FONT-SIZE: 9pt\" face=\"Tahoma\" color=\"#B50000\">".substr(nl2br($fa[aciklama]), 0, 120)."...</a><br><br>\n";
}
?>