<div class="navbar">
    <div class="d-flex flex-column align-items-starts">
        <a href="{{route('chart.demographics', $patient->id)}}">
            <div class="d-flex px-4 pb-2 border-b border-gray-900
                    justify-content-start align-items-center text-start">
                    <img
                        src="{{asset('vendor\third_party\icon_demographics.svg')}}"
                        alt="Demographics"
                        height="48"
                        width="48" />

                    <span class="px-4 pt-2 h6">
                        Demographics
                    </span>
            </div>
        </a>

        <a href="{{route('chart.allergies', $patient->id)}}">
            <div class="d-flex px-4 py-2 border-b border-gray-900
                    justify-content-start align-items-center text-start">
                <img
                    src="{{asset('vendor\third_party\icon_allergies.svg')}}"
                    alt="Allergies"
                    height="48"
                    width="48" />

                <span class="px-4 pt-2 h6">
                    Allergies
                </span>
            </div>
        </a>

        <a href="{{route('chart.notes', $patient->id)}}">
            <div class="d-flex px-4 py-2 border-b border-gray-900
                    justify-content-start align-items-center text-start">
                <img
                    src="{{asset('vendor\third_party\icon_notes.svg')}}"
                    alt="Notes"
                    height="48"
                    width="48" />

                <span class="px-4 pt-2 h6">
                    Notes
                </span>
            </div>
        </a>

        <a href="{{route('chart.results', $patient->id)}}">
            <div class="d-flex px-4 py-2 border-b border-gray-900
                    justify-content-start align-items-center text-start">
                <img
                    src="{{asset('vendor\third_party\icon_results.svg')}}"
                    alt="Results"
                    height="48"
                    width="48" />

                <span class="px-4 pt-2 h6">
                    Results
                </span>
            </div>
        </a>

        <a href="{{route('chart.orders', $patient->id)}}">
            <div class="d-flex px-4 py-2 border-b border-gray-900
                    justify-content-start align-items-center text-start">
                <img
                    src="{{asset('vendor\third_party\icon_orders.svg')}}"
                    alt="Orders"
                    height="48"
                    width="48" />

                <span class="px-4 pt-2 h6">
                    Orders
                </span>
            </div>
        </a>

        <a href="{{route('chart.flowsheet', $patient->id)}}">
            <div class="d-flex px-4 py-2 border-b border-gray-900
                    justify-content-start align-items-center text-start">
                <img
                    src="{{asset('vendor\third_party\icon_flowsheet.svg')}}"
                    alt="Flowsheet"
                    height="48"
                    width="48" />

                <span class="px-4 pt-2 h6">
                    Flowsheet
                </span>
            </div>
        </a>

        <a href="{{route('chart.mar', $patient->id)}}">
            <div class="d-flex px-4 py-2 border-b border-gray-900
                    justify-content-start align-items-center text-start">
                <img
                    src="{{asset('vendor\third_party\icon_mar.svg')}}"
                    alt="Medication Administration Record (MAR)"
                    height="48"
                    width="48" />

                <span class="px-4 pt-2 h6">
                    Medication<br>Administration<br>Record (MAR)
                </span>
            </div>
        </a>
    </div>

</div>



