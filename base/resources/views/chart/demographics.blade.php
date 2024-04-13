<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="flex items-center">Demographic Information</div>
    @endsection

    @section("chart_content")
        <table class="table">
            <tbody>
                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        Patient Information
                    </th>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">First Name:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->name_first }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Middle Name:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->name_middle }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Last Name:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->name_last }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Preferred Name:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->name_preferred }}</td>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">Date of Birth:</td>
                    <td class="text-sm align-content-start w-75">{{ is_null($patient->date_of_birth) ? '' : $patient->date_of_birth->format('d M o') }}</td>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">Sex:</td>
                    <td class="text-sm align-content-start w-75">{{ ucfirst($patient->sex) }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Gender:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->textGender() }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Pronouns:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->textPronouns() }}</td>
                </tr>


                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        <p class="pt-3">Contact Information</p>
                    </th>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Address:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->address }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Telephone:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->telephone }}</td>
                </tr>


                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        <p class="pt-3">Insurance Information</p>
                    </th>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">Provider / Company:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->insurance_provider }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Account #:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->insurance_account_number }}</td>
                </tr>


                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        <p class="pt-3">Next of Kin</p>
                    </th>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">Name:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->next_of_kin_name }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Relationship:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->next_of_kin_relationship }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Address:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->next_of_kin_address }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Telephone #:</td>
                    <td class="text-sm align-content-start w-75">{{ $patient->next_of_kin_telephone }}</td>
                </tr>
            </tbody>
        </table>
    @endsection

</x-chart.chart>
