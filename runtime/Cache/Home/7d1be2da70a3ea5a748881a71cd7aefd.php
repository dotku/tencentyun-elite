<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elite 图片服务中心</title>
    <link href="/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/lib/dpatch/dist/css/general-cn.css" rel="stylesheet"/>
    <script src="/lib/angular/angular.js"></script>
    <script src="/lib/jquery/dist/jquery.min.js"></script>
    <script src="/lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <style>
      .container {max-width: 600px;}
      footer {line-height: inherit;}
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Elite 图片服务中心</h1>
      <div class="container">
        <form method="post" action="<?php echo U('Index/post') ?>" enctype="multipart/form-data">
          <div class="form-group">
            <div class="text-center">
              <?php  use Tencentyun\ImageV2; use Tencentyun\Auth; use Tencentyun\Video; use Tencentyun\ImageProcess; use Tencentyun\Conf; $statRet = ImageV2::stat(Conf::BUCKET, $_GET['fileid']); if ($statRet['httpcode'] == 200 && $statRet['data']['downloadUrl']) { ?>
                <img src="<?php echo $statRet['data']['downloadUrl'] . '?' . rand() ?>" width="300" style="padding: 20px">
              <?php } else { ?>
                <i class="glyphicon glyphicon-cloud-upload" style="font-size: 150px; padding: 20px"></i>
              <?php }?>
            </div>
            <input type="file" name="imagefile" class="form-control"/>
            <input type="hidden" name="fileid" value="<?php echo $_GET['fileid'] ?>"/>
            <input type="hidden" name="http_referer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>" /> 
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary pull-right">Upload</button>

          </div>
        </form>

      </div>
      <footer>
        <div>Sponsored by <a href="http://www.fnmili.com">Funmili.com</a></div>
        <div>&copy; 2016 DotKu Studio</div>
      </footer>
    </div>
  </body>
</html>