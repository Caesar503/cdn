<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $res = Goods::get()->toArray();
//        echo "<pre>";
//        print_r($res);echo "</pre>";
        return view('goods.index',['res'=>$res]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('goods.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->goods_name||!$request->goods_desc||!$request->file('goods_img')||!$request->token){
            $arr = [
                'err'=>2,
                'msg'=>'缺少参数！！！'
            ];
            die(json_encode($arr,JSON_UNESCAPED_UNICODE));
        }
        $file = $request->file('goods_img');
        $a = $file->getClientOriginalExtension();
        $qian = date('ymd').rand(1111,9999);
        $goods_img = $file->storeAs('images',$qian.'.'.$a);
        $data = [
            'goods_name'=>$request->goods_name,
            'goods_desc'=>$request->goods_desc,
            'goods_img'=>$goods_img
        ];
        $res = Goods::insertGetId($data);
        if($res){
            $arr = [
                'err'=>0,
                'msg'=>'ok'
            ];
        }else{
            $arr = [
                'err'=>1,
                'msg'=>'出现错误！'
            ];
        }
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=0,Request $request)
    {
        if(!$id||!$request->token){
            $arr =[
                'err'=>4,
                'msg'=>'参数不完整！'
            ];
            die(json_encode($arr,JSON_UNESCAPED_UNICODE));
        }
        $res =Goods::where('id',$id)->first()->toArray();
        echo json_encode($res);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$id){
            $arr =[
                'err'=>4,
                'msg'=>'参数不完整！'
            ];
            die(json_encode($arr));
        }
        $res =Goods::where('id',$id)->first()->toArray();
        return view('goods.edit',['res'=>$res]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$request->goods_name||!$request->goods_desc||!$request->file('goods_img')||!$request->token){
            $arr = [
                'err'=>2,
                'msg'=>'缺少参数！！！'
            ];
            die(json_encode($arr,JSON_UNESCAPED_UNICODE));
        }
        $file = $request->file('goods_img');
        $a = $file->getClientOriginalExtension();
        $qian = date('ymd').rand(1111,9999);
        $goods_img = $file->storeAs('images',$qian.'.'.$a);
        $data = [
            'goods_name'=>$request->goods_name,
            'goods_desc'=>$request->goods_desc,
            'goods_img'=>$goods_img
        ];
        $res = Goods::where('id',$id)->update($data);
        if($res){
            $arr = [
                'err'=>0,
                'msg'=>'ok'
            ];
        }else{
            $arr = [
                'err'=>1,
                'msg'=>'出现错误！'
            ];
        }
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        if(!$id||!$request->token){
            $arr = [
                'err'=>2,
                'msg'=>'缺少参数！！！'
            ];
            die(json_encode($arr,JSON_UNESCAPED_UNICODE));
        }
        $res = Goods::where('id',$id)->delete();
        if($res){
            $arr = [
                'err'=>0,
                'msg'=>'ok'
            ];
        }else{
            $arr = [
                'err'=>1,
                'msg'=>'出现错误！'
            ];
        }
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    }
}
