<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header flex items-center">Edit Facility (User/Ward)</div>
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

                <form method="POST" action="/facilities/edit/{{$facility->id}}">
                    @csrf

                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="name" :value="__('Name')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="name" class="block mt-1 w-full text-sm"
                                              name="name"
                                              required
                                              value="{{$facility->name}}"
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="acronym" :value="__('Acronym')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="acronym" class="block mt-1 w-full text-sm"
                                              name="acronym"
                                              required
                                              value="{{$facility->acronym}}"
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="type" :value="__('Type')" />
                            </td>

                            <td class="text-sm">
                                <select id="type" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="type" required>
                                    <option value="inpatient" {{$facility->type == 'inpatient' ? "selected" : ""}}> Inpatient </option>
                                    <option value="outpatient" {{$facility->type == 'outpatient' ? "selected" : ""}}> Outpatient </option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="rooms" :value="__('Number of Rooms')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="rooms" class="block mt-1 w-full text-sm"
                                              name="rooms" type="number"
                                              required
                                              value="{{$rooms}}"
                                />
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                        <div class="flex justify-center">
                            <a href="/facilities" class="btn btn-outline-danger px-3 py-1 text-sm">Cancel</a>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="btn btn-outline-success px-3 py-1 text-sm">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection

</x-app-layout>
