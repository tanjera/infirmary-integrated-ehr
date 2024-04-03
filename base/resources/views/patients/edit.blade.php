<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header flex items-center">Edit Patient</div>
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

                <form method="POST" action="/patients/edit/{{ $patient->id }}">
                    @csrf

                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="name_first" :value="__('First Name')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="name_first" class="block mt-1 w-full text-sm"
                                              name="name_first"
                                              required
                                              value="{{$patient->name_first}}"
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="name_middle" :value="__('Middle Name')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="name_middle" class="block mt-1 w-full text-sm"
                                              name="name_middle"
                                              value="{{$patient->name_middle}}"
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="name_last" :value="__('Last Name')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="name_last" class="block mt-1 w-full text-sm"
                                              name="name_last"
                                              required
                                              value="{{$patient->name_last}}"
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="name_preferred" :value="__('Preferred Name')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="name_preferred" class="block mt-1 w-full text-sm"
                                              name="name_preferred"
                                              value="{{$patient->name_preferred}}"
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="date_of_birth" class="block mt-1 w-full text-sm shadow-sm"
                                              name="date_of_birth" type="datetime-local" value="1900-01-01T00:00"
                                              required
                                              value="{{$patient->date_of_birth}}" />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="medical_record_number" :value="__('Medical Record #')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="medical_record_number" class="block mt-1 w-full text-sm"
                                              name="medical_record_number"
                                              required
                                              value="{{$patient->medical_record_number}}" />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="sex" :value="__('Sex')" />
                            </td>

                            <td class="text-sm">
                                <select id="sex" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        name="sex" required>
                                    <option value="unknown" {{$patient->sex == 'unknown' ? "selected" : ""}}>Unknown</option>
                                    <option value="female" {{$patient->sex == 'female' ? "selected" : ""}}>Female</option>
                                    <option value="male" {{$patient->sex == 'male' ? "selected" : ""}}>Male</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="gender" :value="__('Gender')" />
                            </td>

                            <td class="text-sm">
                                <select id="gender" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        name="gender" required>
                                    <option value="unknown" {{$patient->gender == 'unknown' ? "selected" : ""}}>Unknown</option>
                                    <option value="female" {{$patient->gender == 'female' ? "selected" : ""}}>Female</option>
                                    <option value="male" {{$patient->gender == 'male' ? "selected" : ""}}>Male</option>
                                    <option value="transgender" {{$patient->gender == 'transgender' ? "selected" : ""}}>Transgender</option>
                                    <option value="non_binary" {{$patient->gender == 'non_binary' ? "selected" : ""}}>Non-Binary</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="pronouns" :value="__('Pronouns')" />
                            </td>

                            <td class="text-sm">
                                <select id="pronouns" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        name="pronouns" required>
                                    <option value="unknown" {{$patient->pronouns == 'unknown' ? "selected" : ""}}>Unknown</option>
                                    <option value="she_her" {{$patient->pronouns == 'she_her' ? "selected" : ""}}>She/Her</option>
                                    <option value="he_him" {{$patient->pronouns == 'he_him' ? "selected" : ""}}>He/Him</option>
                                    <option value="they_them" {{$patient->pronouns == 'they_them' ? "selected" : ""}}>They/Them</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="code_status" :value="__('Code Status')" />
                            </td>

                            <td class="text-sm">
                                <select id="code_status" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        name="code_status" required>
                                    <option value="full" {{$patient->code_status == 'full' ? "selected" : ""}}>Full Code</option>
                                    <option value="dnr" {{$patient->code_status == 'dnr' ? "selected" : ""}}>DNR (No CPR)</option>
                                    <option value="dnr_dni" {{$patient->code_status == 'dnr_dni' ? "selected" : ""}}>DNR & DNI (Medical Only)</option>
                                    <option value="palliative" {{$patient->code_status == 'palliative' ? "selected" : ""}}>Palliative (Natural Death)</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="address" :value="__('Address')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="address" class="block mt-1 w-full text-sm"
                                              name="address"
                                              value="{{$patient->address}}"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="telephone" :value="__('Telephone #')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="telephone" class="block mt-1 w-full text-sm"
                                              name="telephone"
                                              value="{{$patient->telephone}}"/>
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
