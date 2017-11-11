<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DropZoneController extends Controller
{
    public function show()
    {
        return view('dropzone.test');
    }
    
    public function submit( Request $request )
    {
        dd($request->all());
    }
    
    public function fileUpload(Request $request)
    {
        if(!$request->hasFile('image'))
            return abort(404);
        $uf = sha1(time()).'.'.$request->file('image')->extension();
        $request->file('image')->move(public_path('uploads'), $uf);
        return response()->json([
            'success' => true,
            'filename' => $uf
        ], 200);
    }
    
    public function fileRemove(Request $request)
    {
                
        if( File::exists(public_path('uploads'.DIRECTORY_SEPARATOR.$request->input('filename'))) )
        {
           File::delete(public_path('uploads'.DIRECTORY_SEPARATOR.$request->input('filename')));
            return response()->json([
                'success' => true
            ]);
        }
        
        return response()->json([
            'success' => false,
            'f' => $request->input('filename')
        ]);
    }

}
