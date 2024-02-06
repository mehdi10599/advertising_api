<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminShop extends Controller
{
    public function getShopItems()
    {
        try{
            $result = Shop::all();
            return response($result,200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    public function updateShopItemUrl(Request $request)
    {
        try{
            $request->validate([
                'id' => 'required|integer',
                'newUrl' => 'required|string',
            ]);
            $shopItem = Shop::where('id',$request->id)->first();
            $shopItem->url = $request->newUrl;
            $shopItem->save();
            return response(['result'=>true],200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    public function updateShopItemDescription(Request $request)
    {
        try{
            $request->validate([
                'id' => 'required|integer',
                'newDescription' => 'required|string',
            ]);
            $shopItem = Shop::where('id',$request->id)->first();
            $shopItem->description = $request->newDescription;
            $shopItem->save();
            return response(['result'=>true],200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    public function deleteShopItem(Request $request)
    {
        try{
            $request->validate([
                'id' => 'required|integer',
            ]);
            Shop::where('id',$request->id)->delete();
            return response(['result'=>true],200);
        }
        catch (\Exception $exception){
            return  response()->json(['error'=>$exception->getMessage()],500);
        }
    }

    public function updateShopItemImage(Request $request)
    {
        try{
            $request->validate([
                'id' => 'required|integer',
                'imageFile' => 'required',
            ]);
            $imageFile = $request->imageFile;
            $id = $request->id;
            $shopItem = Shop::where('id',$id)->first();
            if ($request->hasFile('imageFile')) {

                //delete old image
                $dir = 'public/post_images/'.$id.'/';
                Storage::deleteDirectory($dir);

                //save new image
                $originalName = $imageFile->getClientOriginalName();
                $path = "post_images/$id/".$originalName;
                Storage::disk('public')->put($path, file_get_contents($imageFile));

                //save image address in url
                $shopItem->image_url = url('storage/'.$path);
                $shopItem->save();

                return response(['result'=>true],200);
            }
        }
        catch (\Exception $exception){
            return  response()->json(['laravel error'=>$exception->getMessage()],500);
        }
    }

    public function createShopItem(Request $request)
    {
        try{
            $request->validate([
                'url' => 'required|string',
                'description' => 'required|string',
                'imageFile' => 'required',
            ]);
            $imageFile = $request->imageFile;
            $url = $request->url;
            $description = $request->description;

            $shopItem = new Shop();
            $shopItem->url = $url;
            $shopItem->description = $description;
            $shopItem->image_url = '';
            $shopItem->save();
            $id = $shopItem->id;

            if ($request->hasFile('imageFile')) {
                //save new image
                $originalName = $imageFile->getClientOriginalName();
                $path = "post_images/$id/".$originalName;
                Storage::disk('public')->put($path, file_get_contents($imageFile));

                //save image address in url
                $imageUrl = url('storage/'.$path);

                $shopItem->image_url = $imageUrl;
                $shopItem->save();

                return response(['result'=>true],200);
            }
        }
        catch (\Exception $exception){
            return  response()->json(['laravel error'=>$exception->getMessage()],500);
        }
    }
}
