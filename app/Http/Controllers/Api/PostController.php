<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $posts = Post::all();

        //return collection of posts as a resource

        return response()->json([
            // "success" => true,
            // "message" => "Product List",
            "posts" => $posts
            ]);

        // return new PostResource(true, 'List Data Posts', $posts);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        $post = Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
            'read'      => FALSE,
            'id_post'        => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 6)
        ]);

        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        //return single post as a resource
        // return new PostResource(true, 'Data Post Ditemukan!', $post);

        $post = Post::firstWhere('id_post',$id);


        if (is_null($post)) {
            return response()->json('Data not found', 422);
        } else {
            return response()->json([
                // "success" => true,
                // "message" => "Product List",
                "posts" => $post
            ]);
        }
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Post $post)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.$post->image);

            //update post with new image
            $post->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content,
                'read'      => TRUE,
            ]);

        } else {

            //update post without image
            $post->update([
                'title'     => $request->title,
                'content'   => $request->content,
                'read'      => TRUE,
            ]);
        }

        //return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($param)
    {
        // $post = Post::all();
        //delete image
        /// Storage::delete('public/posts/'.$post->image);

        //delete post
        ///$post->delete();
        // $post = Post::find($id);

        //return response
        ///return new PostResource(true, 'Data Post Berhasil Dihapus!', null);

        $post = Post::findOrFail($param);

        if($post) {
            Storage::delete('public/posts/'.$post->image);
            $post->delete(); 
            return response()->json("Data berhasil dihapus", 200);
        } else {
            return response()->json("Data tidak ditemukan", 422);
        }
    }
}
