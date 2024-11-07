<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;

class WebServiceController extends Controller
{
    /*************** START TOKEN AND RESPONSE *****************/
        private function fetchDataFromAPI($method, $endpoint, $data = []) {
            try {
                $httpRequest = Http::accept('application/json');
                if($method === 'post') {
                    $response = $httpRequest->post(config('global.API_DEV') . $endpoint, $data);
                }
                if($method === 'get') {
                    $response = $httpRequest->get(config('global.API_DEV') . $endpoint, $data);
                }
                if($method === 'put') {
                    $response = $httpRequest->put(config('global.API_DEV') . $endpoint,$data);
                }
                if ($response->successful()) {
                    return response()->json([
                        'status' => $response->status(),
                        'message' => 'success',
                        'data' => $response->json()
                    ], 200);
                }
                return response()->json([
                    'message' => 'Failed to' . $method . ' ' . $endpoint . 'on JSON server',
                    'error' => $response->json()
                ], $response->status());
            } catch (\Exception $e) { 
                dd($e);
                return response()->json(['error' => 'Error fetching data from external API'], 500);
            }
        }
    /***************END TOKEN AND RESPONSE ****************/
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $response = Http::get(config('global.API_DEV') . 'users' , [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);
        if ($response->successful() && count($response->json()) > 0) {
            $user = $response->json()[0];
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ]);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    /******************* START GET ***********************/
    public function getUsers(Request $request){
        return $this->fetchDataFromAPI('get','users');
    }
    public function getArticles(Request $request){
        return $this->fetchDataFromAPI('get','articles');
    }
    public function getCompany(Request $request){
        return $this->fetchDataFromAPI('get','company');
    }
    /******************* START POST ***********************/
    public function postUser(Request $request){
        return $this->fetchDataFromAPI('post','users',$request->data);
    }
    public function postCompany(Request $request){
        $logo = '';
        $request->validate([
            'fileUpload' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string',
            'status' => 'required|string'
        ]);
        if ($request->file('fileUpload')) {
            $path = $request->file('fileUpload')->store('logos', 'public');
            $url = Storage::url($path);
            $logo = $url;
        }
        $data = [
            'logo' => $logo,
            'name' => $request->name,
            'status' => $request->status
        ];
        return $this->fetchDataFromAPI('post','company',$data);
    }
    public function postArticle(Request $request){
        $image = '';
        $request->validate([
            'fileUpload' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'required|string',
            'company' => 'required|string',
            'status' => 'required|string'
        ]);
        if ($request->file('fileUpload')) {
            $path = $request->file('fileUpload')->store('articles', 'public');
            $url = Storage::url($path);
            $image = $url;
        }
        $data = [
            'image' => $image,
            'title' => $request->title,
            'link' => $request->link,
            'date' => Carbon::now()->format('m/d/Y'),
            'content' => $request->content,
            'status' => $request->status,
            'writer' => $request->writer,
            'company' => $request->company
        ];
        return $this->fetchDataFromAPI('post','articles',$data);
    }
    /******************* END UPDATE *********************/
    public function putUser(Request $request){
        return $this->fetchDataFromAPI('put','users',$request->data);
    }
    public function putCompany(Request $request){
        return $this->fetchDataFromAPI('put','company',$request->data);
    }
    public function putArticle(Request $request){
        return $this->fetchDataFromAPI('put','articles',$request->data);
    }
}
