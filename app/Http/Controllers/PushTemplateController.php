<?php

namespace App\Http\Controllers;

use App\PushTemplate as Template;
use Illuminate\Http\Request;

class PushTemplateController extends Controller {
    public function create (Request $request) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'message' => 'required',
            ]);

            $template = Template::create([
                'message' => $request->message,
                'sort' => Template::all()->count()
            ]);

            return redirect()->route('templates.index')->with('success', true);
        }

        return view('templates.push.create');
    }

    public function update (Request $request, Template $template) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'message' => 'required',
            ]);

            $template->message = $request->message;

            $template->save();

            return redirect()->route('templates.index')->with('success', true);
        }

        return view('templates.push.update', compact('template'));
    }

    public function delete (Template $template) {
        $template->delete();

        return redirect()->route('templates.push.index')->with('success', true);
    }

    public function sort (Request $request) {
        $ids = $request->ids;

        for ($i = 0; $i < count($ids); $i++) {
            if ($template = Template::find($ids[$i])) {
                $template->sort = $i;
                $template->save();
            }
        }

        return response()->json(JSONSuccess());
    }
}
