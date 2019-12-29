@extends ('layouts.app')

@section ('content')
    <div class="row">
        <div class="col-9">
            <div class="card" style="max-height: calc(100vh);">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-start">
                        <div class="mr-3">
                            <a href="{{ route('chats.index') }}" class="btn btn-sm btn-outline-info">Back</a>
                        </div>
                        <h3>
                            Chat
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="messages" id="messages">
                        @foreach($messages as $key => $day)
                            <div class="d-flex justify-content-center mb-2">
                                <span class="badge badge-pill badge-light">{{ $key }}</span>
                            </div>
                            @foreach($day as $message)
                                <div class="d-flex justify-content-{{ $message->type != 'user' ? 'start' : 'end' }}">
                                    @if($message->type == 'user')
                                        <div class="d-flex time mr-1">
                                            <span
                                                class="align-self-end">{{ $message->created_at->format('H:i') }}</span>
                                        </div>
                                    @endif
                                    <div class="message {{ $message->type }} py-1 px-2 mb-2"
                                         id="{{ $loop->parent->last && $loop->last ? 'last' : '' }}">{{ $message->message }}</div>
                                    @if($message->type != 'user')
                                        <div class="d-flex time ml-1">
                                            <span
                                                class="align-self-end">{{ $message->created_at->format('H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach

                    </div>

                    <div class="mt-1">
                        <form method="post">
                            @csrf
                            <div class="form-group mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="message">Message</label>
                                    <select class="custom-select custom-select-sm ml-3" id="template_id"
                                            name="template_id">
                                        <option selected disabled id="template_id_default">Insert template</option>
                                        @foreach($templates as $template)
                                            <option>{{ $template->message }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <textarea class="form-control" id="message" rows="3" name="message"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" value="send" name="action"
                                            class="btn btn-outline-success btn-block text-uppercase">
                                        Send
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" value="next" name="action"
                                            class="btn btn-success btn-block text-uppercase">
                                        Send & Next
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="alert alert-secondary" role="alert">
                <h4 class="alert-heading">User information</h4>
                <p class="mb-1">Email: <span
                        class="badge badge-light">{{ is_null($client->email) ? '-' : $client->email }}</span></p>
                <p class="mb-1">Name: <span
                        class="badge badge-light">{{ is_null($client->name) ? '-' : $client->name }}</span></p>
                <p class="mb-1">Gender: <span
                        class="badge badge-light">{{ is_null($client->gender) ? '-' : $client->gender }}</span></p>
                <p class="mb-1">Birthday: <span
                        class="badge badge-light">{{ is_null($client->birthday) ? '-' : $client->birthday->format('d.m.Y') }}</span>
                </p>

                <p class="mb-1">Time of Birth: <span
                        class="badge badge-light">{{ is_null($client->time_birth) ? '-' : minutes_time((int)$client->time_birth) }}</span>
                </p>

                <p class="mb-1">Place of Birth: <span
                        class="badge badge-light">{{ is_null($client->place_birth) ? '-' : $client->place_birth }}</span>
                </p>
                <p class="mb-1">Favorite color: <span
                        class="badge badge-light">{{ is_null($client->favoriteColor) ? '-' : $client->favoriteColor }}</span>
                </p>
                <p class="mb-1">Favorite number: <span
                        class="badge badge-light">{{ is_null($client->favoriteNumber) ? '-' : $client->favoriteNumber }}</span>
                </p>
                @if(!is_null($client->sign))
                    <p class="mb-1">Sign:
                        <a target="_blank" class="badge badge-light"
                           href="https://horoscopes.rambler.ru/{{ \App\Zodiac::find($client->sign + 1)->name }}/description/">
                            {{ is_null($client->sign) ? '-' : \App\Zodiac::find($client->sign + 1)->title }}
                        </a>
                    </p>
                @endif
                <hr>
                <p class="mb-1">Relationships: <span
                        class="badge badge-light">{{ is_null($client->relationships) ? '-' : $client->relationships }}</span>
                </p>

                @if($client->relationships == 'true')
                    <p class="mb-1">Partner birthday: <span
                            class="badge badge-light">{{ is_null($client->partner_birthday) || $client->partner_birthday == '-' ? '-' : $client->partner_birthday->format('d.m.Y') }}</span>
                    </p>

                    @if(!is_null($client->partner_birthday) && $client->partner_birthday != '-')
                        <p class="mb-1">Partner sign:
                            <a target="_blank" class="badge badge-light"
                               href="https://horoscopes.rambler.ru/{{ \App\Zodiac::getByDate($client->partner_birthday)->name }}/description/">
                                {{ is_null($client->sign) ? '-' : \App\Zodiac::getByDate($client->partner_birthday)->title }}
                            </a>
                        </p>

                        @if(!is_null($client->sign))
                            <p class="mb-1">
                                <a target="_blank"
                                   href="https://astro7.ru/search/?search_text=Совместимость+{{ \App\Zodiac::find($client->sign + 1)->translate }}+{{ \App\Zodiac::getByDate($client->partner_birthday)->translate }}">
                                    Compatibility chart
                                </a>
                            </p>
                        @endif
                    @endif
                @endif

                <hr>
                <p class="mb-1">Subscription: <span
                        class="badge badge-light">{{ is_null($client->type) ? '-' : $client->type }}</span></p>
                <p class="mb-1">3 questions: <span
                        class="badge badge-light">{{ $client->three_questions == 0 ? '-' : 'Purchased' }}</span></p>
                <p class="mb-1">5 questions: <span
                        class="badge badge-light">{{ $client->five_questions == 0 ? '-' : 'Purchased' }}</span></p>
                <p class="mb-1">10 questions: <span
                        class="badge badge-light">{{ $client->ten_questions == 0 ? '-' : 'Purchased' }}</span></p>
                <hr>
                <p class="mb-0">Registration date: <span
                        class="badge badge-light">{{ $client->created_at->format('d.m.Y H:i:s') }}</span></p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            location.href = '#last';

            $('#template_id').change(function () {
                $('#message').val($(this).val());
                $('#template_id_default').prop('selected', 'true');
            });
        });
    </script>
@endsection
