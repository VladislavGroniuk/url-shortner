<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkStoreRequest;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function index()
    {
        return view('pages.home.index');
    }

    public function store(LinkStoreRequest $request)
    {
        $validated_data = $request->validated();

        $link = Link::create([
            'short_link' => Str::random(5),
            'url' => $validated_data['link'],
        ]);

        return response()->json($link, 201);
    }

    public function redirectToUrl($url)
    {
        $link = Link::where('short_link', $url)->firstOrFail();

        return redirect()->away($link->url);
    }
}
