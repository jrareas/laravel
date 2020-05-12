<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Images as ImageModel;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function upload(Request $request) {
        $ret = [];
        if (count($request->file()) > 0) {
            foreach ($request->file() as $file) {
                $image = Image::make($file->getRealPath());
                $imageModel = new ImageModel;
                $imageModel->image_name = $file->getClientOriginalName();
                Response::make($image->encode('jpeg'));

                $imageModel->image_data = $image;
                $imageModel->save();
                $ret[] = ["id" => $imageModel->id];
            }
        }
        return $ret;
    }

    public function get($image_id, $size = null) {
        $image = ImageModel::find($image_id);
        if ($size) {
            $dimensions = explode("x",$size);
            if (count($dimensions) == 2) {
                return Image::make($image->image_data)->resize($dimensions[0],$dimensions[1])->response();
            }
        }
        return Image::make($image->image_data)->response();
    }
}
