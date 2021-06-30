<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <?php
  $preLink = '../';
  require '../commons/includes.php';
   ?>
   <link rel='stylesheet' type='text/css' href='panel.css'>
</head>
<body>

  <div class='container'>
    <table class='table'>
      <th>Starting Time</th><th>Ending Time</th><th>Duration</th>
      <?php
      require '../commons/getResult.php';
      $sql = "SELECT * FROM `usage_stats` WHERE 1";
      $result = getResult($sql);
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . strftime("%r %a %B %d, %Y",strtotime($row['STARTING TIME'])) . "</td>";

        if ($row['ENDING TIME']!='') {
          echo "<td>" . strftime("%r %a %B %d, %Y",strtotime($row['ENDING TIME'])) . "</td>";
        } else {
          echo "<td>Ended Instantly</td>";
        }
        //calculating time difference between starting time and ending time in seconds
        $start = strtotime($row['STARTING TIME']);
        $now = strtotime($row['ENDING TIME']);
        $diff = $now - $start;

        $w = $diff / 86400 / 7;
        $d = $diff / 86400 % 7;
        $h = $diff / 3600 % 24;
        $m = $diff / 60 % 60;
        $s = $diff % 60;
        $diff='';
        if ($h>0) {
          $diff .="{$h} hours, ";
        }
        if ($m>0) {
          $diff.="{$m} minutes and ";
        }
        $diff .= "{$s} seconds";

        echo "<td>" . $diff . "</td>";

        echo "</tr>";
      }
       ?>
    </table>
  </div>

</body>
</html>
