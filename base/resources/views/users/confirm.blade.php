<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header">Confirm Deletion</div>
                <div class="card-body table table-responsive">
                    <p class="text-sm p-2">
                        Are you sure you want to delete this user?
                    </p>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="align-content-center text-sm">Name</th>
                            <th scope="col" class="align-content-center text-sm">Email</th>
                            <th scope="col" class="align-content-center text-sm">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-content-center text-sm">{{ $user->name }}</td>
                                <td class="align-content-center text-sm">{{ $user->email }}</td>
                                <td class="align-content-center text-sm">{{ $user->role }}</td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                        <div class="flex justify-center">
                            <a href="/users" class="btn btn-outline-primary px-3 py-1 text-sm">No</a>
                        </div>
                        <div class="flex justify-center">
                            <a href="/users/delete/process/{{ $user->id }}" class="btn btn-outline-danger px-3 py-1 text-sm">Yes</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</x-app-layout>
