<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        //get posts
        $posts = Post::all();

        //return collection of posts as a resource

        return response()->json(["posts" => $posts]);

        // return new PostResource(true, 'List Data Posts', $posts);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return PostResource|JsonResponse
     */
    public function store(Request $request): PostResource|JsonResponse
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
            'id_post'        => substr(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36), 0, 6)
        ]);

        //return response
//        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
        return response()->json(["posts" => $post]);
    }

    /**
     * show
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {


        try {
            $post = Post::firstWhere('id_post',$id);

            if (is_null($post)) {
                return response()->json([
                    'error' => 'The requested resource could not be found.'
                ], 404);
            }

            return response()->json($post);
        } catch (e) {
            print(e);
            return e;
        }


    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return JsonResponse|PostResource
     */
    public function update(Request $request, Post $post): PostResource|JsonResponse
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
     * @param $param
     * @return JsonResponse
     */
    public function destroy($param): JsonResponse
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
            return response()->json("Data berhasil dihapus");
        }

        return response()->json("Data tidak ditemukan", 422);
    }
}
