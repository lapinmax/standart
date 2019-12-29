@extends ('layouts.app')

@section ('content')
    <div class="d-flex flex-row justify-content-start">
        <div class="mr-3">
            <a href="{{ route('index') }}" class="btn btn-sm btn-outline-info">Back</a>
        </div>
        <h3>
            Create horoscope | {{ $zodiac->title }} {{ $type == 'year' ? '2020' : $date->format('d.m.Y') }}
        </h3>
    </div>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
        <input type="hidden" name="zodiac" value="{{ $zodiac->id }}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card card-mh mb-3">
                    <div class="card-header">
                        <h3 class="mb-1 float-left">Overall</h3>
                        <div class="float-right">
                            <span class="badge badge-success">
                                {{ $horoscope ? $horoscope->likes->where('field', 'overall')->count() : 0 }}
                            </span>
                            <span class="badge badge-danger">
                                {{ $horoscope ? $horoscope->dislikes->where('field', 'overall')->count() : 0 }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="overall_title">Title</label>
                            <input type="text" class="form-control" id="overall_title" name="overall_title"
                                   placeholder="Enter title..."
                                   value="{{ old('overall_title') ?? ($horoscope ? $horoscope->overall_title : '') }}">
                        </div>
                        <div class="form-group">
                            <label for="overall_subtitle">Subtitle</label>
                            <input type="text" class="form-control" id="overall_subtitle" name="overall_subtitle"
                                   placeholder="Enter subtitle..."
                                   value="{{ old('overall_subtitle') ?? ($horoscope ? $horoscope->overall_subtitle : '') }}">
                        </div>

                        <div class="form-group">
                            <label for="overall_text">Text</label>
                            <textarea class="form-control" id="overall_text" name="overall_text"
                                      placeholder="Enter text..."
                                      rows="8">{{ old('overall_text') ?? ($horoscope ? $horoscope->overall_text : '') }}</textarea>
                        </div>

                        @if($horoscope && $horoscope->overall_image)
                            <div class="horoscope-image">
                                <img src="{{ \Storage::url($horoscope->overall_image) }}"
                                     alt="">
                            </div>
                        @endif
                        <div class="custom-file mb-2 mt-2">
                            <input type="file" class="custom-file-input" id="overall_image" name="overall_image"
                                   lang="ru">
                            <label for="overall_image" class="custom-file-label">Select image</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card card-mh mb-3">
                    <div class="card-header">
                        <h3 class="mb-1 float-left">Love</h3>
                        <div class="float-right">
                            <span class="badge badge-success">
                                {{ $horoscope ? $horoscope->likes->where('field', 'love')->count() : 0 }}
                            </span>
                            <span class="badge badge-danger">
                                {{ $horoscope ? $horoscope->dislikes->where('field', 'love')->count() : 0 }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="love_title">Title</label>
                            <input type="text" class="form-control" id="love_title" name="love_title"
                                   placeholder="Enter title..."
                                   value="{{ old('love_title') ?? ($horoscope ? $horoscope->love_title : '') }}">
                        </div>
                        <div class="form-group">
                            <label for="love_subtitle">Subtitle</label>
                            <input type="text" class="form-control" id="love_subtitle" name="love_subtitle"
                                   placeholder="Enter subtitle..."
                                   value="{{ old('love_subtitle') ?? ($horoscope ? $horoscope->love_subtitle : '') }}">
                        </div>
                        @if($horoscope && $horoscope->love_image)
                            <div class="horoscope-image">
                                <img src="{{ \Storage::url($horoscope->love_image) }}"
                                     alt="">
                            </div>
                        @endif
                        <div class="custom-file mb-2 mt-2">
                            <input type="file" class="custom-file-input" id="love_image" name="love_image" lang="ru">
                            <label for="love_image" class="custom-file-label">Select image</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-mh mb-3">
                    <div class="card-header">
                        <h3 class="mb-1 float-left">Career</h3>
                        <div class="float-right">
                            <span class="badge badge-success">
                                {{ $horoscope ? $horoscope->likes->where('field', 'career')->count() : 0 }}
                            </span>
                            <span class="badge badge-danger">
                                {{ $horoscope ? $horoscope->dislikes->where('field', 'career')->count() : 0 }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="career_title">Title</label>
                            <input type="text" class="form-control" id="career_title" name="career_title"
                                   placeholder="Enter title..."
                                   value="{{ old('career_title') ?? ($horoscope ? $horoscope->career_title : '') }}">
                        </div>
                        <div class="form-group">
                            <label for="career_subtitle">Subtitle</label>
                            <input type="text" class="form-control" id="career_subtitle" name="career_subtitle"
                                   placeholder="Enter subtitle..."
                                   value="{{ old('career_subtitle') ?? ($horoscope ? $horoscope->career_subtitle : '') }}">
                        </div>
                        @if($horoscope && $horoscope->career_image)
                            <div class="horoscope-image">
                                <img src="{{ \Storage::url($horoscope->career_image) }}"
                                     alt="">
                            </div>
                        @endif
                        <div class="custom-file mb-2 mt-2">
                            <input type="file" class="custom-file-input" id="career_image" name="career_image"
                                   lang="ru">
                            <label for="career_image" class="custom-file-label">Select image</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card card-mh mb-3">
                    <div class="card-header">
                        <h3 class="mb-1 float-left">Health</h3>
                        <div class="float-right">
                            <span class="badge badge-success">
                                {{ $horoscope ? $horoscope->likes->where('field', 'health')->count() : 0 }}
                            </span>
                            <span class="badge badge-danger">
                                {{ $horoscope ? $horoscope->dislikes->where('field', 'health')->count() : 0 }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="health_title">Title</label>
                            <input type="text" class="form-control" id="health_title" name="health_title"
                                   placeholder="Enter title..."
                                   value="{{ old('health_title') ?? ($horoscope ? $horoscope->health_title : '') }}">
                        </div>
                        <div class="form-group">
                            <label for="health_subtitle">Subtitle</label>
                            <input type="text" class="form-control" id="health_subtitle" name="health_subtitle"
                                   placeholder="Enter subtitle..."
                                   value="{{ old('health_subtitle') ?? ($horoscope ? $horoscope->health_subtitle : '') }}">
                        </div>
                        @if($horoscope && $horoscope->health_image)
                            <div class="horoscope-image">
                                <img src="{{ \Storage::url($horoscope->health_image) }}"
                                     alt="">
                            </div>
                        @endif
                        <div class="custom-file mb-2 mt-2">
                            <input type="file" class="custom-file-input" id="health_image" name="health_image"
                                   lang="ru">
                            <label for="health_image" class="custom-file-label">Select image</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-mh mb-3">
                    <div class="card-header">
                        <h3 class="mb-1 float-left">Biorhythms</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="biorhythms_physical_number">Physical number</label>
                                    <input type="number" class="form-control" id="biorhythms_physical_number"
                                           name="biorhythms_physical_number"
                                           placeholder="Enter number..."
                                           value="{{ old('biorhythms_physical_number') ?? ($horoscope ? $horoscope->biorhythms_physical_number : '') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="biorhythms_emotional_number">Emotional number</label>
                                    <input type="number" class="form-control" id="biorhythms_emotional_number"
                                           name="biorhythms_emotional_number"
                                           placeholder="Enter number..."
                                           value="{{ old('biorhythms_emotional_number') ?? ($horoscope ? $horoscope->biorhythms_emotional_number : '') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="biorhythms_intellectual_number">Intellectual number</label>
                                    <input type="number" class="form-control" id="biorhythms_intellectual_number"
                                           name="biorhythms_intellectual_number"
                                           placeholder="Enter number..."
                                           value="{{ old('biorhythms_intellectual_number') ?? ($horoscope ? $horoscope->biorhythms_intellectual_number : '') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="biorhythms_average_number">Average number</label>
                                    <input type="number" class="form-control" id="biorhythms_average_number"
                                           name="biorhythms_average_number"
                                           placeholder="Enter number..."
                                           value="{{ old('biorhythms_average_number') ?? ($horoscope ? $horoscope->biorhythms_average_number : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card card-mh mb-3">
                    <div class="card-header">
                        <h3 class="mb-1">Lucky</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="lucky_number">Number</label>
                            <input type="number" class="form-control" id="lucky_number" name="lucky_number"
                                   placeholder="Enter number..."
                                   value="{{ old('lucky_number') ?? ($horoscope ? $horoscope->lucky_number : '') }}">
                        </div>
                        <div class="form-group">
                            <label for="lucky_human">Human</label>
                            <textarea class="form-control" id="lucky_human" name="lucky_human"
                                      rows="4">{{ old('lucky_human') ?? ($horoscope ? $horoscope->lucky_human : '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-mh mb-3">
                    <div class="card-header">
                        <h3 class="mb-1">Dream</h3>
                    </div>
                    <div class="card-body">
                        <span>Sex</span>
                        <div class="rating">
                            <input type="radio" id="sex_star5" name="dream_sex" value="5"
                                {{ (old('dream_sex') && old('dream_sex') == 5) || ($horoscope && $horoscope->dream_sex == 5) ? 'checked' : '' }}/>
                            <label for="sex_star5"></label>

                            <input type="radio" id="sex_star4" name="dream_sex" value="4"
                                {{ (old('dream_sex') && old('dream_sex') == 4) || ($horoscope && $horoscope->dream_sex == 4) ? 'checked' : '' }}/>
                            <label for="sex_star4"></label>

                            <input type="radio" id="sex_star3" name="dream_sex" value="3"
                                {{ (old('dream_sex') && old('dream_sex') == 3) || ($horoscope && $horoscope->dream_sex == 3) ? 'checked' : '' }}/>
                            <label for="sex_star3"></label>

                            <input type="radio" id="sex_star2" name="dream_sex" value="2"
                                {{ (old('dream_sex') && old('dream_sex') == 2) || ($horoscope && $horoscope->dream_sex == 2) ? 'checked' : '' }}/>
                            <label for="sex_star2"></label>

                            <input type="radio" id="sex_star1" name="dream_sex" value="1"
                                {{ (old('dream_sex') && old('dream_sex') == 1) || ($horoscope && $horoscope->dream_sex == 1) ? 'checked' : '' }}/>
                            <label for="sex_star1"></label>
                        </div>
                        <span>Hustle</span>
                        <div class="rating">
                            <input type="radio" id="hustle_star5" name="dream_hustle" value="5"
                                {{ (old('dream_hustle') && old('dream_hustle') == 5) || ($horoscope && $horoscope->dream_hustle == 5) ? 'checked' : '' }}/>
                            <label for="hustle_star5"></label>

                            <input type="radio" id="hustle_star4" name="dream_hustle" value="4"
                                {{ (old('dream_hustle') && old('dream_hustle') == 4) || ($horoscope && $horoscope->dream_hustle == 4) ? 'checked' : '' }}/>
                            <label for="hustle_star4"></label>

                            <input type="radio" id="hustle_star3" name="dream_hustle" value="3"
                                {{ (old('dream_hustle') && old('dream_hustle') == 3) || ($horoscope && $horoscope->dream_hustle == 3) ? 'checked' : '' }}/>
                            <label for="hustle_star3"></label>

                            <input type="radio" id="hustle_star2" name="dream_hustle" value="2"
                                {{ (old('dream_hustle') && old('dream_hustle') == 2) || ($horoscope && $horoscope->dream_hustle == 2) ? 'checked' : '' }}/>
                            <label for="hustle_star2"></label>

                            <input type="radio" id="hustle_star1" name="dream_hustle" value="1"
                                {{ (old('dream_hustle') && old('dream_hustle') == 1) || ($horoscope && $horoscope->dream_hustle == 1) ? 'checked' : '' }}/>
                            <label for="hustle_star1"></label>
                        </div>
                        <span>Vibe</span>
                        <div class="rating">
                            <input type="radio" id="vibe_star5" name="dream_vibe" value="5"
                                {{ (old('dream_vibe') && old('dream_vibe') == 5) || ($horoscope && $horoscope->dream_vibe == 5) ? 'checked' : '' }}/>
                            <label for="vibe_star5"></label>

                            <input type="radio" id="vibe_star4" name="dream_vibe" value="4"
                                {{ (old('dream_vibe') && old('dream_vibe') == 4) || ($horoscope && $horoscope->dream_vibe == 4) ? 'checked' : '' }}/>
                            <label for="vibe_star4"></label>

                            <input type="radio" id="vibe_star3" name="dream_vibe" value="3"
                                {{ (old('dream_vibe') && old('dream_vibe') == 3) || ($horoscope && $horoscope->dream_vibe == 3) ? 'checked' : '' }}/>
                            <label for="vibe_star3"></label>

                            <input type="radio" id="vibe_star2" name="dream_vibe" value="2"
                                {{ (old('dream_vibe') && old('dream_vibe') == 2) || ($horoscope && $horoscope->dream_vibe == 2) ? 'checked' : '' }}/>
                            <label for="vibe_star2"></label>

                            <input type="radio" id="vibe_star1" name="dream_vibe" value="1"
                                {{ (old('dream_vibe') && old('dream_vibe') == 1) || ($horoscope && $horoscope->dream_vibe == 1) ? 'checked' : '' }}/>
                            <label for="vibe_star1"></label>
                        </div>
                        <span>Success</span>
                        <div class="rating">
                            <input type="radio" id="success_star5" name="dream_success" value="5"
                                {{ (old('dream_success') && old('dream_success') == 5) || ($horoscope && $horoscope->dream_success == 5) ? 'checked' : '' }}/>
                            <label for="success_star5"></label>

                            <input type="radio" id="success_star4" name="dream_success" value="4"
                                {{ (old('dream_success') && old('dream_success') == 4) || ($horoscope && $horoscope->dream_success == 4) ? 'checked' : '' }}/>
                            <label for="success_star4"></label>

                            <input type="radio" id="success_star3" name="dream_success" value="3"
                                {{ (old('dream_success') && old('dream_success') == 3) || ($horoscope && $horoscope->dream_success == 3) ? 'checked' : '' }}/>
                            <label for="success_star3"></label>

                            <input type="radio" id="success_star2" name="dream_success" value="2"
                                {{ (old('dream_success') && old('dream_success') == 2) || ($horoscope && $horoscope->dream_success == 2) ? 'checked' : '' }}/>
                            <label for="success_star2"></label>

                            <input type="radio" id="success_star1" name="dream_success" value="1"
                                {{ (old('dream_success') && old('dream_success') == 1) || ($horoscope && $horoscope->dream_success == 1) ? 'checked' : '' }}/>
                            <label for="success_star1"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="mb-1">Push template</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="template_id">Template</label>
                            <select class="form-control" id="template_id" name="template_id">
                                @foreach($templates as $template)
                                    <option
                                        value="{{ $template->id }}" {{ ($horoscope && $horoscope->template_id == $template->id) ? 'selected' : '' }}>{{ $template->message }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="template_message">Custom template message</label>
                            <textarea class="form-control" id="template_message" rows="3" name="template_message"
                                      placeholder="Enter custom template message..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" value="save" name="action"
                        class="btn btn-lg btn-outline-success btn-block text-uppercase">
                    Save
                </button>
            </div>
            @if($type != 'year')
                <div class="col">
                    <button type="submit" value="next" name="action"
                            class="btn btn-lg btn-success btn-block text-uppercase" {{ $canNext ? '' : 'disabled' }}>
                        Save & next day
                    </button>
                </div>
            @endif
        </div>
    </form>
@endsection

