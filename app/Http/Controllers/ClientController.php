<?php

namespace App\Http\Controllers;

use App\Client;
use App\Exports\UsersExport;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;

class ClientController extends Controller {
    public function index () {
        return view('clients.index');
    }

    public function export () {
        return (new UsersExport())->download('Users.xlsx');
    }
}
