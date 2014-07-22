<?php
require_once(__DIR__.'/../core/lib_wordup.php');
// All the php functions are now in the separate core/lib_wordup.php



if (isset($_GET["q"])) {
    $theWord = $_GET["q"]; // This is the dangerous part, where the changable user input comes in, so it has to be watched like a hawk, 
    // and never used without proper escaping or sanitation.
    $theQuery = urlencode($_GET["q"]);
} else {
  $theWord = "what word would you like to look up?";
}

?>

<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
 <title>WordUp</title>
 <link rel="stylesheet" type="text/css" href="/css/styles.css">
 <!-- CSS moved to external stylesheet -->
</head>

<body>

<table>
 <tr>
  <td></td>
  <td width=800px>

    <table class=topTable height=80px>
     <tr height=30px><td></td></tr>
     <tr height=32px valign=top>
      <td width=525px>
        <?php echo $theWord; ?>
      </td>
      <td align=right width=225px>
        <form method="get"><input type="text" name="q" style="width:200px; height:32px;" />
      </td>
      <td>
        <img src='img/icon_info_1.svg' style='height: 32px; width: 32px;' />
      </td>
     </tr>
     <tr height=18px><td></td></tr>
    </table>

    <table height=400px class='<?php if($theQuery){ echo 'query-present';} ?>'>
     <tr align=left valign=top>
      <td width=260px class='definitionBox'>
       <?php if ($theQuery) echo get_dictionary($theQuery,$theWord); ?>
      </td>
      <td width=10px></td>
      <td width=260px class='definitionBox'>
       <?php if ($theQuery) echo get_slang($theQuery); ?>
      </td>
      <td width=10px></td>
      <td width=260px class='definitionBox'>
       <?php if ($theQuery) echo get_thesaurus($theQuery); ?>
      </td>
    </tr>
   </table>

  </td>
  <td></td>
 </tr>
</table>
</body>