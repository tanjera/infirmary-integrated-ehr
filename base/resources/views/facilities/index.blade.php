<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header grid grid-cols-2">
                    <div class="flex items-center">Manage Facilities (Units/Wards)</div>
                    <div class="flex justify-end">
                        <a href="/facilities/create" class="btn btn-outline-success px-3 py-1 text-sm">Add Facility</a>
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
                            <th scope="col" class="align-content-center text-sm">Name</th>
                            <th scope="col" class="align-content-center text-sm">Acronym</th>
                            <th scope="col" class="align-content-center text-sm">Type</th>
                            <th scope="col" class="align-content-center text-sm">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($facilities) > 0)
                            @foreach ($facilities as $facility)
                                <tr>
                                    <td class="align-content-center text-sm">{{ $facility->name }}</td>
                                    <td class="align-content-center text-sm">{{ $facility->acronym }}</td>
                                    <td class="align-content-center text-sm">{{ ucfirst($facility->type) }}</td>
                                    <td class="align-content-center text-sm">
                                        <a href="/facilities/edit/{{ $facility->id }}" class="btn btn-outline-primary px-3 py-1 text-sm">Edit</a>
                                        <a href="/facilities/delete/confirm/{{ $facility->id }}" class="btn btn-outline-danger px-3 py-1 text-sm">Delete</a>
                                    </td>
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
