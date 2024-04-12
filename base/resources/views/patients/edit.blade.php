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
                            <th class="text-md align-content-start" colspan="2">
                                Patient Information
                            </th>
                        </tr>

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
                                    @foreach(\App\Models\Patient::$pronouns_index as $pronoun)
                                        <option value="{{ $pronoun }}" {{ $pronoun == $patient->pronouns ? "selected" : ""}}>
                                            {{ \App\Models\Patient::$pronouns_text[array_search($pronoun, \App\Models\Patient::$pronouns_index)] }}
                                        </option>
                                    @endforeach
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
                                    @foreach(\App\Models\Patient::$code_status_index as $code_status)
                                        <option value="{{ $code_status }}" {{ $code_status == $patient->code_status ? "selected" : ""}}>
                                            {{ \App\Models\Patient::$code_status_text[array_search($code_status, \App\Models\Patient::$code_status_index)] }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-md align-content-start" colspan="2">
                                Contact Information
                            </th>
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

                        <tr>
                            <th class="text-md align-content-start" colspan="2">
                                Insurance Information
                            </th>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="insurance_provider" :value="__('Provider / Company')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="insurance_provider" class="block mt-1 w-full text-sm"
                                              name="insurance_provider"
                                              value="{{$patient->insurance_provider}}"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="insurance_account_number" :value="__('Account #')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="insurance_account_number" class="block mt-1 w-full text-sm"
                                              name="insurance_account_number"
                                              value="{{$patient->insurance_account_number}}"/>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-md align-content-start" colspan="2">
                                Next of Kin
                            </th>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="next_of_kin_name" :value="__('Name')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="next_of_kin_name" class="block mt-1 w-full text-sm"
                                              name="next_of_kin_name"
                                              value="{{$patient->next_of_kin_name}}"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="next_of_kin_relationship" :value="__('Relationship')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="next_of_kin_relationship" class="block mt-1 w-full text-sm"
                                              name="next_of_kin_relationship"
                                              value="{{$patient->next_of_kin_relationship}}"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="next_of_kin_address" :value="__('Address')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="next_of_kin_address" class="block mt-1 w-full text-sm"
                                              name="next_of_kin_address"
                                              value="{{$patient->next_of_kin_address}}"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="next_of_kin_telephone" :value="__('Telephone #')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="next_of_kin_telephone" class="block mt-1 w-full text-sm"
                                              name="next_of_kin_telephone"
                                              value="{{$patient->next_of_kin_telephone}}"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                        <div class="flex justify-center">
                            <a href="/patients" class="btn btn-outline-danger px-3 py-1 text-sm">Cancel</a>
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
