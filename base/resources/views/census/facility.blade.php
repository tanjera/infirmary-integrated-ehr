<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header grid grid-cols-2">
                    <div class="flex items-center">Facility Census</div>
                </div>
                <div class="card-body table table-responsive">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session::has('message'))
                        <p class="alert">{!! Session::get('message') !!}</p>
                        @foreach($errors->all() as $error)
                            <p>{!! $error !!}</p>
                        @endforeach
                    @endif

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="align-content-center text-sm">Name</th>
                            <th scope="col" class="align-content-center text-sm">Patients / Rooms</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($facilities) > 0)
                            @foreach ($facilities as $facility)
                                @php
                                    // Gather occupied vs. total # of rooms
                                    $occupied = $rooms->where('facility', $facility->id)->whereNotNull('patient')->count();
                                    $total = $rooms->where('facility', $facility->id)->count();
                                @endphp
                                <tr>
                                    <td class="align-content-center text-sm">
                                        <a href="/census/unit/{{$facility->id}}">
                                        {{ $facility->name }} {{is_null($facility->acronym) ? "" : "($facility->acronym)" }}
                                        </a>
                                    </td>
                                    <td class="align-content-center text-sm">{{ $occupied }} / {{ $total }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>No Data</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

</x-app-layout>
