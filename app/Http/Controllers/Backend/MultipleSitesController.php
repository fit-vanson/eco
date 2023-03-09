<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Media_option;
use App\Models\MultipleSites;
use App\Models\Pro_category;
use App\Models\Site_option;
use App\Models\Tp_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MultipleSitesController extends Controller
{
    //Multiple Site page load
    public function getMultipleSitesPageLoad() {

        $AllCount = MultipleSites::count();
        $PublishedCount = MultipleSites::where('is_publish', '=', 1)->count();
        $DraftCount = MultipleSites::where('is_publish', '=', 2)->count();
        $categorylist = Pro_category::where('is_publish', 1)->orderBy('name','asc')->get();
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();


        $datalist = MultipleSites::orderBy('id','desc')
            ->with('tp_status','categories')
            ->paginate(20);

        return view('backend.multiple_sites', compact('AllCount', 'PublishedCount', 'DraftCount', 'categorylist','statuslist', 'datalist'));
    }
    //Get data for Products Pagination
    public function getMultipleSitesTableData(Request $request){
        $search = $request->search;
        $status = $request->status;

        $category_id = $request->category_id;
        if($request->ajax()){
            if($search != ''){
                $datalist =  MultipleSites::orderBy('id','desc')
                    ->where(function ($query) use ($search){
                        $query
                            ->where('multiple_sites.site_name', 'like', '%'.$search.'%')
                            ->orwhere('multiple_sites.site_web', 'like', '%'.$search.'%')
                            ->orWhere('pro_categories.name', 'like', '%'.$search.'%');
                    })
                    ->where(function ($query) use ($status){
                        $query->whereRaw("multiple_sites.is_publish = '".$status."' OR '".$status."' = '0'");
                    })
                    ->whereHas('categories', function ($query) use ($category_id) {
                        return $query
                            ->whereRaw("pro_categories.id = '".$category_id."' OR '".$category_id."' = '0'");
                    })
                    ->paginate(20);
            }else{
                $datalist =  MultipleSites::orderBy('id','desc')
                    ->where(function ($query) use ($status){
                        $query->whereRaw("multiple_sites.is_publish = '".$status."' OR '".$status."' = '0'");
                    })
                    ->whereHas('categories', function ($query) use ($category_id) {
                        return $query
                            ->whereRaw("pro_categories.id = '".$category_id."' OR '".$category_id."' = '0'");
                    })
                    ->paginate(20);
            }

            return view('backend.partials.multiple_sites_table', compact('datalist'))->render();
        }
    }

    //Save data for Multiple Sites
    public function saveMultipleSitesData(Request $request){
        $res = array();

        $id = $request->input('RecordId');
        $name = $request->input('site_name');
        $web = $request->input('site_web');
        $is_publish = $request->input('is_publish');
        $cat_id = $request->input('categoryid');

        $validator_array = array(
            'site_name' => $request->input('site_name'),
            'site_web' => $request->input('site_web'),
            'category' => $request->input('categoryid'),
        );

        $rId = $id == '' ? '' : ','.$id;
        $validator = Validator::make($validator_array, [
            'site_name' => 'required|max:191|unique:multiple_sites,site_name' . $rId,
            'site_web' => 'required|max:191|unique:multiple_sites,site_web' . $rId,
            'category' => 'required',
        ]);

        $errors = $validator->errors();

        if($errors->has('site_name')){
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('site_name');
            return response()->json($res);
        }
        if($errors->has('site_web')){
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('site_web');
            return response()->json($res);
        }

        if($errors->has('category')){
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('category');
            return response()->json($res);
        }


        $data = array(
            'site_name' => $name,
            'site_web' => $web,
            'is_publish' => $is_publish
        );


        if($id ==''){
            $response = MultipleSites::create($data);
            if($response){
                $response->categories()->attach($cat_id);

                $site_options = new Site_option(['site_id'=>$response->id]);
                $response->site_options()->save($site_options);

                $res['id'] = $response->id;
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            }else{
                $res['id'] = '';
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        }else{
            $response = MultipleSites::where('id', $id)->first();
//            $response = MultipleSites::where('id', $id)->update($data);
            if($response){
//                dd($response)->update($data);
                $response->update($data);
                $response->categories()->sync($cat_id);

                $res['id'] = $id;
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            }else{
                $res['id'] = '';
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }
        }
        return response()->json($res);
    }

    //get Multiple Sites
    public function getMultipleSitesPageData($id=null){

        $datalist = MultipleSites::with('site_options','categories')->where('id', $id)->first();
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();
        $categorylist = Pro_category::where('is_publish', '=', 1)->orderBy('name','asc')->get();



//        $categories = $datalist->categories;

        $media_datalist = Media_option::orderBy('id','desc')->paginate(28);

//        $data = array();
//
//            $data['id'] = $dataSite->id;
//            $data['favicon'] = '';
//            $data['front_logo'] = '';
//            $data['back_logo'] = '';
//        $datalist = $data;

        return view('backend.theme-site', compact('datalist','statuslist','categorylist','media_datalist'));





        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $categorylist = Pro_category::where('is_publish', '=', 1)->orderBy('name','asc')->get();


        $taxlist = Tax::orderBy('title','asc')->get();
        $unitlist = Attribute::orderBy('name','asc')->get();
        $media_datalist = Media_option::orderBy('id','desc')->paginate(28);

        $storeList = DB::table('users')
            ->select('users.id', 'users.shop_name')
            ->where('users.role_id', '=', 3)
            ->where('users.status_id', '=', 1)
            ->orderBy('users.shop_name','asc')
            ->get();

        return view('backend.product', compact('datalist', 'statuslist', 'languageslist', 'brandlist', 'categorylist', 'taxlist', 'media_datalist', 'storeList', 'unitlist'));
    }
}
