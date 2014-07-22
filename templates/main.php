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

    <table height=400px class='<?php echo $query_present;?>'>
     <tr align=left valign=top>
      <td width=260px class='definitionBox'>
        <?php echo $dictionary_section; // Notably unescaped, which has it's dangers ?>
      </td>
      <td width=10px></td>
      <td width=260px class='definitionBox'>
       <?php echo $slang_section; // Again, naked dynamic html here ?>
      </td>
      <td width=10px></td>
      <td width=260px class='definitionBox'>
       <?php echo $thesaurus_section; // Naked dynamic html again ?>
      </td>
    </tr>
   </table>

  </td>
  <td></td>
 </tr>
</table>
</body>