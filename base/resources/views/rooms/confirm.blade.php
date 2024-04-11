<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header flex items-center">Confirm Clearing Room Assignments</div>
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

                    <p class="text-sm p-2">
                        Are you sure you want to clear all the room assignments?
                    </p>

                    <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                        <div class="flex justify-center">
                            <a href="/patients" class="btn btn-outline-primary px-3 py-1 text-sm">No</a>
                        </div>
                        <div class="flex justify-center">
                            <a href="/rooms/clear" class="btn btn-outline-danger px-3 py-1 text-sm">Yes</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection

</x-app-layout>
