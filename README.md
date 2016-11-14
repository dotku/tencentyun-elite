#Elite

一个基于腾讯云(qcloud.com/tencentyun)的万象优图制作的应用
感谢腾讯云提供的免费 50GB/月 的图片空间

## Usage
1. 配置

复制 common/Conf/config.tencentyun.template.php 更名为 common/Conf/config.tencentyun.php，并把你的 API KEY 完善

2. 上传

访问 `/elite/index.php/Home/Index/index/fileid/xxx` 上传图片，然后就可以通过 `/elite/index.php/Home/Index/get/fileid/xxx` 的方式来获取图片信息。

## 参考案例
范米粒 用户中心 http://www.fnmili.com/index.php/Mobile/User/index.html
