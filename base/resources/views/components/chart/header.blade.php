<!-- Patient Header w/ Info, Demographics, etc. -->

<div class="bg-white border-t border-b border-gray-900 mx-auto py-2 px-4 sm:px-6 lg:px-8 grid">
    <div class="row">
        <div class="col-3">
            <p class="h6 mb-1">
                {{-- Name --}}
                {{
                    "$patient->name_last, $patient->name_first"
                    . (strlen($patient->name_middle) == 0 ? "" : " $patient->name_middle")
                    . (strlen($patient->name_preferred) == 0 ? "" : " '$patient->name_preferred'")
                }}
            </p>

            <p>
                {{-- Sex/Gender --}}
                <span class="text-gray-400">Sex / Gender: </span>
                @if($patient->sex == $patient->gender)
                    {{ ucfirst($patient->sex) }}
                @else
                    {{ ucfirst($patient->sex) . " / " . ucfirst($patient->gender) }}
                @endif
            </p>

            <p>
                <span class="text-gray-400">Date of Birth: </span>
                {{-- Date of Birth --}}
                {{ is_null($patient->date_of_birth) ? '' : $patient->date_of_birth->format('d M o') }}

                {{-- Age --}}
                @php
                    if (!is_null($patient->date_of_birth)) {
                        $diff = $patient->date_of_birth->diff($patient->created_at);
                        if ($diff->y > 0) echo "($diff->y y)";
                        else if ($diff->m > 0) echo "($diff->m mo)";
                        else if ($diff->d > 0) echo "($diff->d d)";
                        else if ($diff->h > 0) echo "($diff->h h)";
                        else if ($diff->i > 0) echo "($diff->i min)";
                    }
                @endphp
            </p>

            <p>
                <span class="text-gray-400">Allergies:</span>
                {{-- Allergies --}}
                @if(count($patient->getAllergies()) > 0)
                    <span style="color: red">Present</span>
                @else
                    <span style="color: green">None</span>
                @endif
            </p>
        </div>
        <div class="col-3">
            <p>
                <span class="text-gray-400">Location:</span>
                {{-- Room # --}}
                {{ is_null($facility->acronym) ? "$room->number" : "$facility->acronym-$room->number" }}
            </p>

            <p>
                <span class="text-gray-400">Medical Record #:</span>
                {{-- MRN --}}
                {{ $patient->medical_record_number }}
            </p>
            <p>
                <span class="text-gray-400">Code Status:</span>
                {{-- Code Status --}}
                <span style="color: {{ $patient->code_status == "full" ? "green" : "red" }}">
                    {{ $patient->textCodeStatus() }}
                </span>
            </p>
        </div>
    </div>
</div>
