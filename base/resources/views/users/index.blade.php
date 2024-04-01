<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header grid grid-cols-2">
                    <div class="flex items-center">Manage Users</div>
                    <div class="flex justify-end">
                        <a href="/users/create" class="btn btn-outline-success px-3 py-1 text-sm">Add User</a>
                    </div>
                </div>
                <div class="card-body table table-responsive">

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
                            <th scope="col" class="align-content-center text-sm">Email</th>
                            <th scope="col" class="align-content-center text-sm">Role</th>
                            <th scope="col" class="align-content-center text-sm">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($users) > 0)
                            @foreach ($users as $user)
                                @if ($user->active == true)
                                    <tr>
                                        <td class="align-content-center text-sm">{{ $user->name }}</td>
                                        <td class="align-content-center text-sm">{{ $user->email }}</td>
                                        <td class="align-content-center text-sm">{{ ucfirst($user->role) }}</td>
                                        <td class="align-content-center text-sm">
                                            <a href="/users/edit/{{ $user->id }}" class="btn btn-outline-primary px-3 py-1 text-sm">Edit</a>
                                            @if ($user->id != Auth::user()->id)
                                                <a href="/users/delete/confirm/{{ $user->id }}" class="btn btn-outline-danger px-3 py-1 text-sm">Delete</a>
                                            @endif
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
