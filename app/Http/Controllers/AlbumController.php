<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Traits\FileUploaderTrait;
use DB;
use Auth;

class AlbumController extends Controller
{
    use FileUploaderTrait;

    public function index()
    {
        return view('album.list');
    }

    public function home()
    {
        $albums = Album::with('likes')->latest()->get();
        $transformedAlbums = $albums->map(function ($album) {
            return [
                'id' => $album->id,
                'description' => $album->description,
                'user_id' => $album->user_id,
                'image' => $album->image,
                'created_at' => $album->created_at,
                'updated_at' => $album->updated_at,
                'likes' => $album->likes->isNotEmpty(),
            ];
        });
        // return $transformedAlbums;
        return view('album.home', compact('transformedAlbums'));
    }

    public function create()
    {
        return view('album.create');
    }

    public function save(AlbumRequest $request)
    {
         try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['user_id'] = Auth::user()->id;
            $fileName = $this->uploadFile($request, 'image', 'albums');
            $data['image'] = $fileName;

            Album::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Album created successfully.');

         } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create album. Please try again.');
        }
    }
    
}
