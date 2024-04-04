<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header grid grid-cols-2">
                    <div class="flex items-center">Manage Patients</div>
                    <div class="flex justify-end">
                        <a href="/patients/create" class="btn btn-outline-success px-3 py-1 text-sm">Add Patient</a>
                    </div>
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
                            <th scope="col" class="align-content-center text-sm">Medical Record #</th>
                            <th scope="col" class="align-content-center text-sm">Name</th>
                            <th scope="col" class="align-content-center text-sm">Date of Birth</th>
                            <th scope="col" class="align-content-center text-sm">Sex / Gender</th>
                            <th scope="col" class="align-content-center text-sm">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($patients) > 0)
                            @foreach ($patients as $patient)
                                @if ($patient->active == true)
                                    <tr>
                                        <td class="align-content-center text-sm">{{ $patient->medical_record_number }}</td>
                                        <td class="align-content-center text-sm">
                                            {{
                                                "$patient->name_last, $patient->name_first"
                                                . (strlen($patient->name_middle) == 0 ? "" : " $patient->name_middle")
                                                . (strlen($patient->name_preferred) == 0 ? "" : " '$patient->name_preferred'")
                                            }}
                                        </td>
                                        <td class="align-content-center text-sm">
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
                                        </td>
                                        <td class="align-content-center text-sm">{{ ucfirst($patient->sex) }} / {{ ucfirst($patient->gender) }}</td>
                                        <td class="align-content-center text-sm">
                                            <a href="/patients/edit/{{ $patient->id }}" class="btn btn-outline-primary px-3 py-1 text-sm">Edit</a>
                                            <a href="/patients/delete/confirm/{{ $patient->id }}" class="btn btn-outline-danger px-3 py-1 text-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endif
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
