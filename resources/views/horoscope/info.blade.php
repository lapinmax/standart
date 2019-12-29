@extends ('layouts.app')

@section ('content')
    @foreach($dates as $date => $v)
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="mb-1">
                    {{ $date . ($v['status'] ? ' ✅' : ' ⚠️') }}
                </h3>
            </div>
            @if(!$v['status'])
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Zodiac</th>
                            <th scope="col">Overall image</th>
                            <th scope="col">Love image</th>
                            <th scope="col">Career image</th>
                            <th scope="col">Health image</th>
                            <th scope="col">Texts</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($zodiacs as $zodiac)
                            <tr>
                                <th scope="row">{{ $zodiac->title }}</th>
                                <td>
                                    {{ $v['zodiacs'][$zodiac->id]['overall_image'] ? '✅' : '⚠️'}}
                                </td>
                                <td>
                                    {{ $v['zodiacs'][$zodiac->id]['love_image'] ? '✅' : '⚠️'}}
                                </td>
                                <td>
                                    {{ $v['zodiacs'][$zodiac->id]['career_image'] ? '✅' : '⚠️'}}
                                </td>
                                <td>
                                    {{ $v['zodiacs'][$zodiac->id]['health_image'] ? '✅' : '⚠️'}}
                                </td>
                                <td>
                                    {{ $v['zodiacs'][$zodiac->id]['texts'] ? '✅' : '⚠️'}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endforeach
@endsection
