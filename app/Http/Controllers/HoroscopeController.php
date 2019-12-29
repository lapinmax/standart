<?php

namespace App\Http\Controllers;

use App\Horoscope;
use App\Zodiac;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\PushTemplate as Template;

class HoroscopeController extends Controller {
    public function index () {
        $today = Carbon::today();

        $zodiacs = Zodiac::all();

        $array = Horoscope::where('type', 'day')->where('date', '<=', $today->addDays(90)->format('Y-m-d H:i:s'))->where('filled', 1)->get();

        $horoscopes = [];

        foreach ($array as $horoscope) {
            $horoscopes[$horoscope->zodiac_id][$horoscope->date->format('d-m-Y')] = $horoscope;
        }

        return view('horoscope.index', compact('zodiacs', 'horoscopes'));
    }

    public function next (Request $request) {
        $type = $request->type;

        $zodiac = Zodiac::find($request->zodiac);
        $date = Carbon::parse($request->date);
        $canNext = Carbon::today()->addDays(90)->greaterThanOrEqualTo($date->copy()->addDay());
        $templates = Template::all();


        if ($type == 'year') {
            $horoscope = Horoscope::where('type', 'year')->where('zodiac_id', $zodiac->id)->where('year', '2020')->first();
        } else {
            $horoscope = Horoscope::where('type', 'day')->where('zodiac_id', $zodiac->id)->where('date', $date->format('Y-m-d'))->first();
        }

        if ($request->isMethod('post')) {
            $validator = validator($request->all(), [
                'love_title' => 'required',
                'love_image' => 'image' . ($horoscope && !is_null($horoscope->love_image) ? '' : '|required'),
                'love_subtitle' => 'required',

                'overall_title' => 'required',
                'overall_image' => 'image' . ($horoscope && !is_null($horoscope->overall_image) ? '' : '|required'),
                'overall_subtitle' => 'required',
                'overall_text' => 'required',

                'career_title' => 'required',
                'career_image' => 'image' . ($horoscope && !is_null($horoscope->career_image) ? '' : '|required'),
                'career_subtitle' => 'required',

                'health_title' => 'required',
                'health_image' => 'image' . ($horoscope && !is_null($horoscope->health_image) ? '' : '|required'),
                'health_subtitle' => 'required',

                'lucky_number' => 'required',
                'lucky_human' => 'required',

                'dream_sex' => 'required',
                'dream_hustle' => 'required',
                'dream_vibe' => 'required',
                'dream_success' => 'required',

                'biorhythms_physical_number' => 'required',
                'biorhythms_intellectual_number' => 'required',
                'biorhythms_emotional_number' => 'required',
                'biorhythms_average_number' => 'required',
            ]);

            if (!$horoscope) {
                $horoscope = new Horoscope();

                $horoscope->zodiac_id = $zodiac->id;

                if ($type == 'year') {
                    $horoscope->year = '2020';
                    $horoscope->type = 'year';
                } else {
                    $horoscope->date = $date->format('Y-m-d');
                }
            }

            $horoscope->filled = $validator->fails() ? 0 : 1;

            $horoscope->love_title = $request->love_title;
            $horoscope->love_subtitle = $request->love_subtitle;

            $horoscope->overall_title = $request->overall_title;
            $horoscope->overall_subtitle = $request->overall_subtitle;
            $horoscope->overall_text = $request->overall_text;

            $horoscope->career_title = $request->career_title;
            $horoscope->career_subtitle = $request->career_subtitle;

            $horoscope->health_title = $request->health_title;
            $horoscope->health_subtitle = $request->health_subtitle;

            $horoscope->lucky_number = $request->lucky_number;
            $horoscope->lucky_human = $request->lucky_human;

            $horoscope->dream_sex = $request->dream_sex;
            $horoscope->dream_hustle = $request->dream_hustle;
            $horoscope->dream_vibe = $request->dream_vibe;
            $horoscope->dream_success = $request->dream_success;

            $horoscope->biorhythms_physical_number = $request->biorhythms_physical_number;
            $horoscope->biorhythms_intellectual_number = $request->biorhythms_intellectual_number;
            $horoscope->biorhythms_emotional_number = $request->biorhythms_emotional_number;
            $horoscope->biorhythms_average_number = $request->biorhythms_average_number;

            if ($request->hasFile('love_image')) {
                $name = explode('.', $request->love_image->getClientOriginalName());
                $extension = end($name);

                $horoscope->love_image = $request->love_image->storeAs('public/images', Str::random(20) . '.' . $extension);
            }

            if ($request->hasFile('overall_image')) {
                $name = explode('.', $request->overall_image->getClientOriginalName());
                $extension = end($name);

                $horoscope->overall_image = $request->overall_image->storeAs('public/images', Str::random(20) . '.' . $extension);
            }

            if ($request->hasFile('career_image')) {
                $name = explode('.', $request->career_image->getClientOriginalName());
                $extension = end($name);

                $horoscope->career_image = $request->career_image->storeAs('public/images', Str::random(20) . '.' . $extension);
            }

            if ($request->hasFile('health_image')) {
                $name = explode('.', $request->health_image->getClientOriginalName());
                $extension = end($name);

                $horoscope->health_image = $request->health_image->storeAs('public/images', Str::random(20) . '.' . $extension);
            }

            if (!is_null($request->template_message)) {
                $template = Template::create([
                    'message' => $request->template_message,
                    'sort' => Template::all()->count()
                ]);

                $horoscope->template_id = $template->id;
            } elseif ($request->has('template_id')) {
                $horoscope->template_id = $request->template_id;
            }

            $horoscope->save();

            if (!$canNext || $request->action == 'save') {
                return redirect()->route('index')->with('success', true);
            }

            return redirect()->route('horoscope.next', [
                'zodiac' => $zodiac->id, 'date' => $date->addDay()->format('Y-m-d')
            ])->with('success', true);
        }

        return view('horoscope.next', compact('zodiac', 'date', 'horoscope', 'canNext', 'templates', 'type'));
    }

    public function info () {
        $fields = ['overall_image', 'love_image', 'career_image', 'health_image'];
        $zodiacs = Zodiac::all();
        $end = today()->addDays(7);
        $dates = [];
        $date = today();

        $array = Horoscope::where('type', 'day')->whereBetween('date', [
            today()->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s')
        ])->get();

        $horoscopes = [];

        foreach ($array as $horoscope) {
            foreach ($fields as $field) {
                $info[$field] = !is_null($horoscope->{$field});
            }

            $info['texts'] = $this->filled($horoscope->toArray());

            $horoscopes[$horoscope->zodiac_id][$horoscope->date->format('d.m.Y')] = $info;
        }

        while ($date->lte($end)) {
            $dates[$date->format('d.m.Y')] = ['status' => true, 'zodiacs' => []];

            foreach ($zodiacs as $zodiac) {
                foreach ($fields as $field) {
                    if (isset($horoscopes[$zodiac->id][$date->format('d.m.Y')])) {
                        if (!$horoscopes[$zodiac->id][$date->format('d.m.Y')][$field]) {
                            $dates[$date->format('d.m.Y')]['status'] = false;
                        }

                        $dates[$date->format('d.m.Y')]['zodiacs'][$zodiac->id][$field] = $horoscopes[$zodiac->id][$date->format('d.m.Y')][$field];
                    } else {
                        $dates[$date->format('d.m.Y')]['zodiacs'][$zodiac->id][$field] = false;
                        $dates[$date->format('d.m.Y')]['status'] = false;
                    }
                }

                if (isset($horoscopes[$zodiac->id][$date->format('d.m.Y')])) {
                    if (!$horoscopes[$zodiac->id][$date->format('d.m.Y')]['texts']) {
                        $dates[$date->format('d.m.Y')]['status'] = false;
                    }

                    $dates[$date->format('d.m.Y')]['zodiacs'][$zodiac->id]['texts'] = $horoscopes[$zodiac->id][$date->format('d.m.Y')]['texts'];
                } else {
                    $dates[$date->format('d.m.Y')]['zodiacs'][$zodiac->id]['texts'] = false;
                }
            }

            $date->addDay();
        }

        return view('horoscope.info', compact('dates', 'zodiacs'));
    }

    public function upload (Request $request) {
        $zodiacs = [
            'capricorn', 'aquarius', 'pisces', 'aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra',
            'scorpio', 'sagittarius'
        ];

        $fields = ['overall', 'love', 'career', 'health'];

        if ($request->hasFile('zip')) {
            do {
                $dir = Str::random(16);
            } while (file_exists(storage_path() . '/app/archive/' . $dir));

            $dirname = storage_path() . '/app/archive/' . $dir;


            $zip = new \ZipArchive();
            $zip->open($request->zip->path());
            $zip->extractTo($dirname);
            $zip->close();

            if (file_exists($dirname . '/images')) {
                for ($i = 0; $i < count($zodiacs); $i++) {
                    $zodiac_path = $dirname . '/images/' . $zodiacs[$i];

                    if (file_exists($zodiac_path)) {
                        $images = $this->clean(scandir($zodiac_path));

                        foreach ($images as $image) {
                            if (in_array($image['field'], $fields)) {

                                $horoscope = Horoscope::updateOrCreate([
                                    'zodiac_id' => ($i + 1),
                                    'date' => $image['date'],
                                ]);

                                $path = 'public/images/' . Str::random(20) . '.' . $image['extension'];

                                \Storage::move('archive/' . $dir . '/images/' . $zodiacs[$i] . '/' . $image['original'], $path);

                                $horoscope->{$image['field'] . '_image'} = $path;

                                $horoscope->filled = $this->filled($horoscope->toArray(), true);

                                $horoscope->save();
                            }
                        }
                    }
                }
            }

            $this->deleteDir($dirname);
        }

        return redirect()->route('horoscope.info')->with('success', true);
    }

    private function clean ($array) {
        $formats = ['png', 'jpg', 'jpeg'];
        $res = [];

        foreach ($array as $item) {
            $tmp = explode('.', $item);

            if (in_array(strtolower(end($tmp)), $formats)) {
                $extension = end($tmp);
                unset($tmp[count($tmp) - 1]);

                $tmp = explode('|', implode(',', $tmp));

                if (count($tmp) == 2) {
                    $res[] = [
                        'date' => $tmp[0],
                        'field' => $tmp[1],
                        'extension' => $extension,
                        'original' => $item,
                    ];
                }
            }
        }

        return $res;
    }

    private function deleteDir ($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDir($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }

    private function filled ($data, $with_images = false) {
        $fields = [
            'love_title' => 'required',
            'love_subtitle' => 'required',

            'overall_title' => 'required',
            'overall_subtitle' => 'required',
            'overall_text' => 'required',

            'career_title' => 'required',
            'career_subtitle' => 'required',

            'health_title' => 'required',
            'health_subtitle' => 'required',

            'lucky_number' => 'required',
            'lucky_human' => 'required',

            'dream_sex' => 'required',
            'dream_hustle' => 'required',
            'dream_vibe' => 'required',
            'dream_success' => 'required',

            'biorhythms_physical_number' => 'required',
            'biorhythms_intellectual_number' => 'required',
            'biorhythms_emotional_number' => 'required',
            'biorhythms_average_number' => 'required',
        ];

        if ($with_images) {
            $fields['love_image'] = 'required';
            $fields['overall_image'] = 'required';
            $fields['career_image'] = 'required';
            $fields['health_image'] = 'required';
        }

        $validator = validator($data, $fields);

        return $validator->fails() ? 0 : 1;
    }
}
