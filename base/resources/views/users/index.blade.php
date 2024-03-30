<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header">Manage Users</div>
                <div class="card-body table table-responsive">
                    <table class="table mt-5">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($users) > 0)
                            @foreach ($users as $user)
                                <tr>
                                    <td class="align-content-center">{{ $user->name }}</td>
                                    <td class="align-content-center">{{ $user->email }}</td>
                                    <td class="align-content-center">{{ $user->role }}</td>
                                    <td class="align-content-center">
                                        <a href="/edit/{{ $user->id }}" class="btn btn-primary px-3 py-1">Edit</a>
                                        <a href="/delete/{{ $user->id }}" class="btn btn-danger px-3 py-1">Delete</a>
                                    </td>
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
