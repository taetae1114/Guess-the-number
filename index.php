<?php

if (empty($_COOKIE['num']) || empty($_GET['num'])) {
  // 在游戏开始时执行生成随机数
  $num = rand(0, 100);
  // 不能存在文件中，因为有可能同时有多个用户使用
  // file_put_contents('number.txt', $num);
  // 因为 cookie 是每个用户自己保存，每个用户存的是属于自己的要猜的数字
  setcookie('num', $num);
} else {
  // 用户来试一试 猜了一次
  // 还是通过cookie记录之前输入的内容
  $count = empty($_COOKIE['count']) ? 0 : (int)$_COOKIE['count'];

  if ($count < 10) {
    // 对比用户提交的数字和用户 Cookie 中存放的被猜的数字
    // $_GET['num'] => 用户试一试的数字
    // $_COOKIE['num'] => 被猜的数字
    $result = (int)$_GET['num'] - (int)$_COOKIE['num'];
    if ($result == 0) {
      $message = '猜对了';
      // 重新开始，删除cookie即可
      setcookie('num');
      setcookie('count');
    } elseif ($result > 0) {
      $message = '太大了';
    } else {
      $message = '太小了';
    }

    setcookie('count', $count + 1);
  } else {
    // 游戏结束
    $message = 'looooooooooooow!';
    setcookie('num');
    setcookie('count');
  }
}

/


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>猜数字</title>
  <style>
    body {
      padding: 100px 0;
      background-color: #708090;
      color: #F5DEB3;
      text-align: center;
      font-size: 2.5em;
      
    }
    p {
      font-size: 0.5em;
    }
    input {
      padding: 5px 20px;
      height: 50px;
      background-color: #fff;
      border: 0px solid #fff;
      box-sizing: border-box;
      color: #666;
      font-size: 20px;
      border-radius: 5px;
    }
    button {
      padding: 5px 20px;
      height: 50px;
      font-size: 16px;
      border-radius: 5px;
      background-color: #CD5555;
      color: #fff;
    }
  </style>
</head>
<body>
  <h1>猜数字</h1>
  <p>Hi，这里有一个0~100的数字，你需要在10机会之内猜对它。</p>
  <?php if (isset($message)): ?>
  <p><?php echo $message; ?></p>
  <?php endif ?>
  <form action="index.php" method="get">
    <input type="number" min="0" max="100" name="num" placeholder="随便猜">
    <button type="submit">试一试</button>
  </form>
</body>
</html>
