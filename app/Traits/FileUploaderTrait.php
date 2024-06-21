<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploaderTrait
{
    public function uploadFile($request, $fieldName, $storagePath)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($storagePath, $fileName, 'public');
            return $path;
        }
        return null;
    }
}
