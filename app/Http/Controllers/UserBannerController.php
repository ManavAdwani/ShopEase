<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class UserBannerController extends Controller
{
    public function index(){
        $banners = Banner::orderBy('id','DESC')->get();
        $activePage = 'user_banners';
        return view('admin.user_banners.index',compact('activePage','banners'));
    }

    public function create(){
        $activePage = 'user_banners';
        return view('admin.user_banners.create',compact('activePage'));
    }

    public function store(Request $request){
        $name = $request->input('banner_name') ?? '';
        $banners =$request->file('banner');
        if(!empty($banners)){
            foreach($banners as $banner){
                $bannerDb = new Banner();
                $bannerDb->name = $name;
                $ogBanner = $banner;
                $bannerPath = $ogBanner->store('banners', 'public');
                $bannerDb->banner = $bannerPath;
                $bannerDb->status = 1;
                $bannerDb->save();
            }
            return redirect()->route('admin.user_banner');
        }
    }

    public function change_status(Request $request, $id){
        $bannerId = $id ?? 0;
        $banner = Banner::findOrFail($bannerId);
        if(!empty($banner)){
            if($banner->status == 1){
                $banner->status = 0;
            }else{
                $banner->status = 1;
            }
            $banner->save();
            return back()->with('success','Status changed successfully!');
        }else{
            return back()->with('error','Something went wrong!');
        }
    }
}
