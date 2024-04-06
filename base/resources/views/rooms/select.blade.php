<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header flex items-center">Select Room Assignment</div>
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

                    <form method="POST" action="/rooms/assign/{{ $patient }}">
                        @csrf

                        <table class="table">
                            <tbody>
                            <tr>
                                <td class="text-sm align-content-center">
                                    <x-input-label for="room" :value="__('Select an Available Room:')" />
                                </td>

                                <td class="text-sm">
                                    <select id="room" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            name="room" required>
                                        @foreach($available as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach

                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                            <div class="flex justify-center">
                                <a href="/patients" class="btn btn-outline-primary px-3 py-1 text-sm">Cancel</a>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit" class="btn btn-outline-danger px-3 py-1 text-sm">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    @endsection

</x-app-layout>
