<?php

namespace App\Http\Controllers\Api;

use App\Models\GuestBook;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuestBookResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class GuestBookController extends Controller
{
//    public function rawSql(Request $request)
//    {
//        $name = $request->input('name');
//        $email = $request->input('email');
//        $created_at = now();
//        $updated_at = now();
//
//        DB::insert('insert into users (name, email, created_at, updated_at) values (?, ?, ?, ?)', [$name, $email, $created_at, $updated_at]);
//
//        return redirect('/users');
//    }


    public function index(): JsonResponse
    {
        $guestBook = GuestBook::all();

        return response()->json(["guestBooks" => $guestBook]);
    }

    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $uuid = Uuid::uuid4()->toString();

        $guestBook = GuestBook::create([
            'uuid'  => $uuid,
            'name' => $request->name
        ]);

        return response()->json(["guestBooks" => $guestBook], 201);
    }

    public function show($id) : JsonResponse
    {
        $guestBook = GuestBook::firstWhere('uuid', $id);

        return response()->json($guestBook);
    }

    public function update($id) : JsonResponse
    {
        $guestBook = GuestBook::firstWhere('uuid', $id);

        if ($guestBook->alreadyAttend) {
            $updatedAt = DB::table('guest_books')
                ->select(DB::raw('updated_at as updatedAt'))
                ->where('uuid', $id)
                ->value('updatedAt');

            $results = Carbon::parse($updatedAt)->format('Y-m-d\TH:i:s.u\Z');
            // The alreadyAttend field is true, do something here
            return response()->json(['message' => 'Already attended.', 'alreadyAttend' => true, 'updatedAt' => $results], 200);
        }

        $guestBook->alreadyAttend = true;
        $guestBook->typeForm = 'RSVP';

        // Set the timezone to Jakarta
        // Carbon::setTimezone('Asia/Jakarta');


        $guestBook->touch();

        return response()->json($guestBook);
    }
}
