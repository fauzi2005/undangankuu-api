<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * *
     * @OA\Post(
     *   path="/auth/jwt/login",
     *   tags={"Auth"},
     *   security={{"passport": {}}},
     *   summary="JWT login",
     *   description="Login a user and generate JWT token",
     *   operationId="jwtLogin",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="email",
     *                   description="User email",
     *                   type="string",
     *                   example="ihamzehald@gmail.com"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="User password",
     *                   type="string",
     *                   example="larapoints123"
     *               ),
     *           )
     *       )
     *   ),
     *  @OA\Response(
     *         response="200",
     *         description="ok",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="access_token",
     *                         type="string",
     *                         description="JWT access token"
     *                     ),
     *                     @OA\Property(
     *                         property="token_type",
     *                         type="string",
     *                         description="Token type"
     *                     ),
     *                     @OA\Property(
     *                         property="expires_in",
     *                         type="integer",
     *                         description="Token expiration in miliseconds",
     *                     ),
     *                     example={
     *                         "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
     *                         "token_type": "bearer",
     *                         "expires_in": 3600
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *   @OA\Response(response="401",description="Unauthorized"),
     * )
     */
    public function checkConnections() {
        try {
            $response = Http::get('https://undangankuu.com');
            // Check for a successful response code (e.g. 200)
            if ($response->ok()) {
                // API is reachable and working
                echo "API connection successful!";
            } else {
                // API is reachable, but returned an error status code
                echo "API returned an error status code: " . $response->status();
            }
        } catch (\Exception $e) {
            // API is unreachable or returned an error
            echo "API connection failed: " . $e->getMessage();
        }
    }

    /**
     * *
     * @OA\Get(
     *     path="/checkConnection",
     *     @OA\Response(
     *      response="200",
     *      description="API connection successful!",
     *      content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="errcode",
     *                         type="integer",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="errmsg",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "errcode": 1,
     *                         "errmsg": "ok",
     *                         "data": {}
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(response="401", description="fail"),
     *     tags={"Check Connection"},
     *     summary="Check internet connection",
     *     description="Fetches all the Asset records",
     * )
     */
    public function checkConnection() {
        try {
            $response = Http::get('https://undangankuu.com');
            // Check for a successful response code (e.g. 200)
            if ($response->ok()) {
                // API is reachable and working
                echo "API connection successful!";
            } else {
                // API is reachable, but returned an error status code
                echo "API returned an error status code: " . $response->status();
            }
        } catch (\Exception $e) {
            // API is unreachable or returned an error
            echo "API connection failed: " . $e->getMessage();
        }
    }

//    /**
//     * Delete notification by ID.
//     *
//     * @OA\Delete(
//     *      path="/api/v0.0.2/notifications/{id}",
//     *      operationId="deleteNotificationById",
//     *      @OA\Parameter(name="id", in="path", @OA\Schema(type="integer")),
//     *      @OA\Response(response=200, description="OK"),
//     *      @OA\Response(response=400, description="Bad Request")
//     * )
//     *
//     * @param Request $request
//     * @param AppNotification $notification
//     *
//     * @return Response
//     * @throws Exception
//     */
//    public function destroy(Request $request, AppNotification $notification) {
//        //
//    }
}
