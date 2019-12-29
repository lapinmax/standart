@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            <h3 class="mb-1 float-left">Create horoscopes</h3>
            <form action="{{ route('horoscope.upload') }}" method="post" id="form-upload" class="float-right"
                  enctype="multipart/form-data">
                @csrf
                <label>
                    <input type="file" name="zip" id="zip" class="d-none">
                    <button type="button" class="btn btn-sm btn-outline-primary">Upload</button>
                </label>
            </form>
            <a href="{{ route('horoscope.info') }}" class="btn btn-sm btn-outline-info float-right mr-1">Overview</a>
        </div>
        <div class="card-body">
            <form id="next" action="{{ route('horoscope.next') }}" method="get">
                <div class="form-group">
                    <div>Choose zodiac</div>
                    <div class="btn-group-toggle" data-toggle="buttons">
                        @foreach($zodiacs as $zodiac)
                            <label class="btn btn-outline-primary pointer {{ $loop->first ? 'active' : '' }} zodiacs">
                                <input type="radio" name="zodiac" id="zadiac-{{ $zodiac->id }}"
                                       value="{{ $zodiac->id }}" {{ $loop->first ? 'checked' : '' }}> {{ $zodiac->title }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <button name="type" value="year" type="submit" class="btn btn-outline-primary mb-1">
                    Year horoscope
                </button>
                <div class="form-group">
                    <div>Date</div>

                    <div id="date"></div>
                </div>
                <input type="hidden" id="input_date" name="date">

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var zodiacs = @json($horoscopes);

            var picker = function (zodiac) {
                var today = moment().startOf('day').valueOf();

                $('#date').datepicker('destroy').off().datepicker({
                    maxViewMode: 0,
                    // startDate: "+0d",
                    endDate: "+90d",
                    format: "yyyy-mm-dd",
                    beforeShowDay: function (date) {
                        var date = moment(date);

                        if (zodiac in zodiacs && zodiacs[zodiac].hasOwnProperty(date.format('DD-MM-YYYY'))) {
                            if (date.valueOf() < today) {
                                return "highlight-before";
                            }

                            return "highlight";
                        }
                    },
                    // todayBtn: "linked"
                }).on('changeDate', function () {
                    $('#input_date').val(
                        $('#date').datepicker('getFormattedDate')
                    );

                    $('#next').submit();
                });
            };

            $('.zodiacs').click(function () {
                picker($(this).find('input').val());
                $('#input_date').val('');
            });

            $('.zodiacs').get(0).click();

            $('#zip').change(function () {
                $('#form-upload').submit();
            });
        });

    </script>
@endsection

