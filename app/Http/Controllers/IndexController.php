<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpClient\HttpClient;

class IndexController extends Controller
{
    public function index()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts/1');
        $data = json_decode($response->getContent(), true);

        return view('welcome', ['data' => implode(",",array_reverse($data))]);
    }
}
