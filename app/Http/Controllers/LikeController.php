<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Auth;
use DB;

class LikeController extends Controller
{
    public function like($album_id)
    {
        try {
            DB::beginTransaction();
            $like = Like::where('user_id', Auth::user()->id)->where('album_id', $album_id)->first();
            if (!$like) {
                Like::create([
                    'user_id' => Auth::user()->id,
                    'album_id' => $album_id
                ]);
            } else {
                $like->delete();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }

}
