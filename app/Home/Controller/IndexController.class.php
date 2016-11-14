<?php
namespace Home\Controller;

use Think\Controller;
use Tencentyun\ImageV2;
use Tencentyun\Auth;
use Tencentyun\Video;
use Tencentyun\ImageProcess;
use Tencentyun\Conf;

class IndexController extends Controller
{
    public function index(){
        $this->display();
    }
    public function _get($paramid = 'sample1478762319'){
        $fileid = $_GET['fileid'] ? $_GET['fileid'] : $paramid; //regular

        $aURL = parse_url($_SERVER['HTTP_REFERER']);
        $bucket = Conf::BUCKET; // 自定义空间名称，在 http://console.qcloud.com/image/bucket 创建
        $statRet = ImageV2::stat($bucket, $fileid);
        return $statRet;
    }
    public function del(){
        $fileid = $_GET['fileid'] ? $_GET['fileid'] : $paramid; //regular

        $aURL = parse_url($_SERVER['HTTP_REFERER']);
        $bucket = Conf::BUCKET; // 自定义空间名称，在 http://console.qcloud.com/image/bucket 创建
        $statRet = ImageV2::del($bucket, $fileid);
        var_dump($statRet);
    }
    public function get(){
        $this->_get();
        echo json_encode($this->_get());
    }

    public function post(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     TEMP_PATH . './Uploads/'; // 设置附件上传根目录
        // $upload->savePath  =     date('yyyymm') . '/'; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            echo json_encode($upload->getError(), JSON_UNESCAPED_UNICODE);
        }else{// 上传成功
            $imgpath = TEMP_PATH . "Uploads/" . $info['imagefile']['savepath'] . $info['imagefile']['savename'];
            $bucket = Conf::BUCKET; // 自定义空间名称，在 http://console.qcloud.com/image/bucket 创建
            $fileid = $_POST['fileid'];  // 自定义文件名
            $uploadRet = ImageV2::upload($imgpath, Conf::BUCKET, $fileid);

            if ($uploadRet['code'] == -1886) {
                ImageV2::del(Conf::BUCKET, $fileid);
                $uploadRet = ImageV2::upload($imgpath, Conf::BUCKET, $fileid);
            }

            if ($uploadRet['httpcode'] == 200) {
                // echo json_decode($uploadRet['data']);
                // var_dump($uploadRet);
                if ($_POST['http_referer']) {
                    // $this->redirect($_POST['http_referer']);
                    redirect($_POST['http_referer']);
                } else {
                    $this->success('upload success');
                }
                
            } else {
                var_dump($info);
                var_dump($imgpath);
                var_dump($uploadRet);
            }
            // echo $imgpath;
            // var_dump();
            // echo "<img src='" . $imagepath . ">";
            // echo json_encode($info, JSON_UNESCAPED_UNICODE);
        }
    }
    public function test()
    {
        //智能鉴黄
        /*
        $pornUrl = 'http://b.hiphotos.baidu.com/image/pic/item/8ad4b31c8701a18b1efd50a89a2f07082938fec7.jpg';
        $pornRet = ImageProcess::pornDetect($pornUrl);
        var_dump($pornRet);
        */
        var_dump(TEMP_PATH);
        
        $bucket = Conf::BUCKET; // 自定义空间名称，在 http://console.qcloud.com/image/bucket 创建
        $fileid = 'sample'.time();  // 自定义文件名
        $uploadRet = ImageV2::upload(TEMP_PATH . 'image.png', Conf::BUCKET, $fileid);
        var_dump('upload',$uploadRet);
        var_dump($uploadRet['data']['info']);

        $uploadSliceRet = ImageV2::uploadSlice(TEMP_PATH . 'image.png');
var_dump('upload_slice',$uploadSliceRet);

            // 查询管理信息
    $statRet = ImageV2::stat($bucket, $fileid);
    var_dump('stat',$statRet);
    // 复制
    $copyRet = ImageV2::copy($bucket, $fileid);
    var_dump('copy', $copyRet);

    // 生成私密下载url
    $expired = time() + 999;
    $sign = Auth::getAppSignV2($bucket, $fileid, $expired);
    $signedUrl = $downloadUrl . '?sign=' . $sign;
    var_dump('downloadUrl:', $signedUrl);

    //生成新的单次签名, 必须绑定资源fileid，复制和删除必须使用，其他不能使用
    $fileid = $fileid.time().rand();  // 自定义文件名
    $expired = 0;
    $sign = Auth::getAppSignV2($bucket, $fileid, $expired);
    var_dump($sign);

    //生成新的多次签名, 可以不绑定资源fileid
    $fileid = '';
    $expired = time() + 999;
    $sign = Auth::getAppSignV2($bucket, $fileid, $expired);
    var_dump($sign);
        
    }
}