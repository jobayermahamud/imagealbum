<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function index(){
        $path=base_path('dbfile')."/db.json";
        $dataArr=json_decode(file_get_contents($path));
        return view('index',['title'=>"Home page",'image_path'=>base_path('images'),'images'=>$dataArr]);

    }

    public function loadJson(){
        $path=base_path('dbfile')."/db.json";
        $dataArr=file_get_contents($path);

        return $dataArr;


    }
    public function uploadImage(Request $request){
        $request->validate([
            'title' => 'required',
            'image' => 'required|mimes:png|max:5000'
        ]);
        $path=base_path('dbfile')."/db.json";
        $dataArr=json_decode(file_get_contents($path));
        $imageId=uniqid().".png";
        $id=uniqid();
        $request->file('image');
        $request->image->storeAs('images',$imageId);
        array_push($dataArr,array('id'=>$id,'title'=>$request->title,'img_url'=>$imageId));
        $myfile = file_put_contents($path,json_encode($dataArr));
       
    }

    public function removeImage($imageId){
        $path=base_path('dbfile')."/db.json";
        $dataArr=json_decode(file_get_contents($path));
        $newArr=array();
        for($i=0;$i<count($dataArr);$i++){
            if($dataArr[$i]->id != $imageId){
                //echo "counting";
                array_push($newArr,$dataArr[$i]);
            }

            if($dataArr[$i]->id==$imageId){
               unlink(base_path('images').'/'.$dataArr[$i]->img_url);
            }
        }
        
        $myfile = file_put_contents($path,json_encode($newArr));
        //print_r($imageId);
    }
}
