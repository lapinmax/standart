<?php

namespace App\Http\Controllers;

use App\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller {
    public function index () {
        $rules = Rule::orderBy('active', 'desc')->get();

        return view('rules.index', compact('rules'));
    }

    public function view (Request $request, Rule $rule) {

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'message' => 'required',
                'days' => 'integer',
            ]);

            $rule->name = $request->name;
            $rule->message = $request->message;
            $rule->days = $request->days;
            $rule->active = $request->has('active') ? 1 : 0;

            $rule->save();

            return redirect()->route('rules.index')->with('success', true);
        }

        return view('rules.view', compact('rule'));
    }
}
