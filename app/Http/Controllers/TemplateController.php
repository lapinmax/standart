<?php

namespace App\Http\Controllers;

use App\ChatTemplate;
use App\PushTemplate;
use Illuminate\Http\Request;

class TemplateController extends Controller {
    public function index () {
        $chat = ChatTemplate::all();
        $push = PushTemplate::all();

        return view('templates.index', compact('chat', 'push'));
    }
}
