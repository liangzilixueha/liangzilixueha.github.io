<!DOCTYPE html>
<html>

<head>
  <title>吃掉小鹿乃-排行榜</title>
  <meta item="description" content="来看神仙" />
  <meta itemprop="image" content="https://www.thac.cc/kano/res/logo.jpg" />
  <meta charset="utf-8" />
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <?php
  include('conn.php');
  $lbtype = isset($_GET['lbtype']) ? $_GET['lbtype'] : 'day';
  $num = 30;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  if ($page <= 0) {
    $page = $page + 1;
  }
  $offset = ($page - 1) * $num;
  if ($lbtype == 'day') {
    $title = "日";
    $cond = "to_days(time) = to_days(now())";
  }
  if ($lbtype == 'week') {
    $title = "周";
    $cond = "DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(time)";
  }
  if ($lbtype == 'month') {
    $title = "月";
    $cond = "DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(time)";
  }
  $filtercond = " ORDER BY score DESC limit {$offset},{$num};";
  $sql1="SELECT * FROM ".$ranking." where ".$cond.$filtercond;
  $sql2="SELECT count(*) FROM ".$ranking." where ".$cond;
  ?>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./index.php">返回</a></li>
      <li class="breadcrumb-item"><a href="https://www.thac.cc">官网</a></li>
      <li class="breadcrumb-item"><a href="?lbtype=day">日榜</a></li>
      <li class="breadcrumb-item"><a href="?lbtype=week">周榜</a></li>
      <li class="breadcrumb-item"><a href="?lbtype=month">月榜</a></li>
      <li class="breadcrumb-item"><a href="https://www.thac.cc/game/index.php">更多游戏</a></li>
    </ol>
  </nav>
  <div class="page-header text-center">
    <h1>排行榜(<?php echo $title; ?>榜)</h1><br/>
    <a href="https://www.thac.cc/kano/x/description.html">查看排行榜说明-<<</a>
  </div>
  <div class="list-group">
    <?php
    //最大显示页数
    $max_pages = 9;
    //数据
    $result1 = mysqli_query($link, $sql1);
    $data = mysqli_fetch_all($result1);
    //数据的长度
    $result2 = mysqli_query($link, $sql2);
    $count = mysqli_fetch_row($result2);
    if ($count[0] > $num * $max_pages) {
      $count = $num * $max_pages;
    } else {
      $count = $count[0];
    }
    $total = ceil($count / $num);
    if ($page >= $total) {
      $page = $page - 1;
    }
    $rank = $offset;
    foreach ($data as $row) :
      $rank += 1;
      echo "<a href='#' class='list-group-item list-group-item-action'><div class='d-flex w-100 justify-content-between'>
            <h5 class='mb-1'>" . $rank . "位   " . $row[2] . "</h5><small>" . $row[3] . "</small></div><p class='mb-1'>SCORE: " . $row[1] . " -" . $row[4] . " -" . $row[5] . "</p>
            <small>" . $row[6] . "</small></a>";
    endforeach
    ?>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php
        $total = ceil($count / $num);
        if ($page >= $total) {
          $page = $page - 1;
        }
        echo "<li class='page-item'>";
        echo "<a class='page-link' href='?lbtype=" . $lbtype . "&page=" . ($page - 1) . "' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
        for ($p = 1; $p <= $total; $p++) {
          echo "<li class='page-item'><a class='page-link' href='?lbtype=" . $lbtype . "&page=" . $p . "'>" . $p . "</a></li>";
        }
        echo "<li class='page-item'><a class='page-link' href='?lbtype=" . $lbtype . "&page=" . ($page + 1) . "' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
        ?>
      </ul>
    </nav>
  </div>
</body>