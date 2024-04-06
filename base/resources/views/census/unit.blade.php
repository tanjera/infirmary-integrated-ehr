<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header grid grid-cols-2">
                    <div class="flex items-center">Unit Census: {{ $facility->name }}</div>
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
                            <th scope="col" class="align-content-center text-sm">Room</th>
                            <th scope="col" class="align-content-center text-sm">Patient</th>
                            <th scope="col" class="align-content-center text-sm">Date of Birth</th>
                            <th scope="col" class="align-content-center text-sm">Sex / Gender</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($rooms) > 0)
                            @foreach ($rooms as $room)
                                @php
                                    if (is_null($room->patient))
                                        $patient = null;
                                    else
                                        $patient = $patients->where('id', $room->patient)->first();
                                @endphp

                                <tr>
                                    @if(is_null($patient))
                                        <td class="align-content-center text-sm">
                                                {{ is_null($facility->acronym) ? "$room->number" : "$facility->acronym-$room->number" }}
                                        </td>
                                        <td class="align-content-center text-sm"></td>
                                        <td class="align-content-center text-sm"></td>
                                        <td class="align-content-center text-sm"></td>

                                    @elseif (!is_null($patient))
                                        <td class="align-content-center text-sm">
                                            <a href="{{ route('chart', ['id' => $patient->id]) }}">
                                                {{ is_null($facility->acronym) ? "$room->number" : "$facility->acronym-$room->number" }}
                                            </a>
                                        </td>

                                        <td class="align-content-center text-sm">
                                            <a href="{{ route('chart', ['id' => $patient->id]) }}">
                                                {{
                                                    "$patient->name_last, $patient->name_first"
                                                    . (strlen($patient->name_middle) == 0 ? "" : " $patient->name_middle")
                                                    . (strlen($patient->name_preferred) == 0 ? "" : " '$patient->name_preferred'")
                                                }}
                                            </a>
                                        </td>

                                        <td class="align-content-center text-sm">
                                            <a href="{{ route('chart', ['id' => $patient->id]) }}">
                                                {{ is_null($patient->date_of_birth) ? '' : $patient->date_of_birth->format('d M o') }}
                                                @php
                                                    if (!is_null($patient->date_of_birth)) {
                                                        $diff = $patient->date_of_birth->diff($patient->created_at);
                                                        if ($diff->y > 0) echo '(' . $diff->y . ' years)';
                                                        else if ($diff->m > 0) echo '(' . $diff->m . ' months)';
                                                        else if ($diff->d > 0) echo '(' . $diff->d . ' days)';
                                                        else if ($diff->h > 0) echo '(' . $diff->h . ' hours)';
                                                        else if ($diff->i > 0) echo '(' . $diff->i . ' minutes)';
                                                    }
                                                @endphp
                                            </a>
                                        </td>

                                        <td class="align-content-center text-sm">
                                            <a href="{{ route('chart', ['id' => $patient->id]) }}">
                                                @if($patient->sex == $patient->gender)
                                                    {{ ucfirst($patient->sex) }}
                                                @else
                                                    {{ ucfirst($patient->sex) ." / " . ucfirst($patient->gender) }}
                                                @endif
                                            </a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th>No Data</th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

</x-app-layout>
