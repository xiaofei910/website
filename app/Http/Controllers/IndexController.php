<?php

namespace App\Http\Controllers;

use App\Models\NavModel;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function message($code,$msg,$url,$data=[]){
        $message = [
            'code'=> $code,
            'msg'=> $msg,
            'url'=> $url,
            'data'=>$data
        ];
        return json_encode($message,JSON_UNESCAPED_UNICODE);
    }
    public function index(){
        return view('admin.index');
    }
    public function nav(){
        return view('admin.nav');
    }

    /**
     * 添加导航
     * @param Request $request
     * @return string|void
     */
    public function addnav(Request $request){
        $arr = $request->all();
//        var_dump($arr);exit;
        $data['name'] = $arr['nav_name'];
        $data['url'] = $arr['url'];
        $data['sorts'] = $arr['sorts'];
        $data['hidden'] = $arr['is_show'];
        $data['addtime'] = time();
        $res = NavModel::insert($data);
        if($res){
            return $this->message('00000','添加成功','/admin/shownav');
        }else{
            return $this->message('00001','添加失败','');
        }
    }
    /**
     * 展示导航
     */
    public function shownav(){
        $info = NavModel::where(['is_del'=>1])->orderBy('sorts','desc')->paginate(2);
//        var_dump($info);exit;
        return view('admin.shownav',['info'=>$info]);
    }
    /**
     * 删除
     */
    public function delnav(Request $request){
        $id = $request->id;
        $res = NavModel::where('id',$id)->update(['is_del'=>2]);
        if($res){
            return $this->message('00000','删除成功','/admin/shownav');
        }else{
            return $this->message('00001','删除失败','');
        }
    }
    /**
     * 修改页面
     */
    public function updnav($id){
//        $id = $request->id;
//        var_dump($id);exit;
        $info = NavModel::where('id',$id)->first();
//        var_dump($info);exit;
        return view('admin.updnav',['info'=>$info]);
    }
    /**
     * 修改
     */
    public function editnav($id){
//        var_dump($id);exit;
        $arr = request()->all();
//        var_dump($arr);exit;
        $data['name'] = $arr['nav_name'];
        $data['url'] = $arr['url'];
        $data['sorts'] = $arr['sorts'];
        $data['hidden'] = $arr['is_show'];
        $data['addtime'] = time();
        $res = NavModel::where('id',$id)->update($data);
        if($res !== false ){
            return $this->message('00000','修改成功','/admin/shownav');
        }else{
            return $this->message('00001','修改失败','');
        }
    }
    /**
     * 即点即改
     */
    public function editsorts(Request $request){
        $data = $request->info;
        $id=$request->id;
//        var_dump($id,$data);
        $res = NavModel::where('id',$id)->update(['sorts'=>$data]);
        if($res !== false){
            return $this->message('00000','修改成功','/admin/shownav');
        }else{
            return $this->message('00001','修改失败','');
        }
    }
    public function edithidden(Request $request){
        $data = $request->val;
        $id=$request->id;
//        var_dump($id,$data);exit;
        $data = intval($data);
        $info = ['hidden'=>$data];
        $res = NavModel::where('id',$id)->update($info);
//        var_dump($res);exit;
        if($res !== false){
            return $this->message('00000','修改成功','/admin/shownav');
        }else{
            return $this->message('00001','修改失败','');
        }
    }
}
