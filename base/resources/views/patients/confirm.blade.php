<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header flex items-center">Confirm Deletion</div>
                <div class="card-body table table-responsive">,

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="text-sm p-2">
                        Are you sure you want to delete this patient?
                    </p>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="align-content-center text-sm">Medical Record #</th>
                            <th scope="col" class="align-content-center text-sm">Name</th>
                            <th scope="col" class="align-content-center text-sm">Date of Birth</th>
                            <th scope="col" class="align-content-center text-sm">Sex / Gender</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-content-center text-sm">{{ $patient->medical_record_number }}</td>
                                <td class="align-content-center text-sm">
                                    {{
                                                $patient->name_last . ', ' . $patient->name_first
                                                . (strlen($patient->name_middle) == 0 ? '' : ' ' . $patient->name_middle)
                                                . (strlen($patient->name_preferred) == 0 ? '' : ' "' . $patient->name_preferred . '"')
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
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                        <div class="flex justify-center">
                            <a href="/patients" class="btn btn-outline-primary px-3 py-1 text-sm">No</a>
                        </div>
                        <div class="flex justify-center">
                            <a href="/patients/delete/process/{{ $patient->id }}" class="btn btn-outline-danger px-3 py-1 text-sm">Yes</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</x-app-layout>
