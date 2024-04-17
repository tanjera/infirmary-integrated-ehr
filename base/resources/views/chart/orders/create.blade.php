<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Write an Order</div>
        </div>
    @endsection

    @section("chart_content")

        <script type='text/javascript'>
            function displayPrescription(category) {
                var elements = document.getElementsByClassName("prescription");
                for(i = 0; i < elements.length; i++) {
                    if (category == "general") {
                        elements[i].style.display = "none";
                    } else if (category == "medication") {
                        elements[i].style.display = "table";
                    }
                }
            }

            function displayPeriodDetails(category) {
                var elements = document.getElementsByClassName("prescription-period");
                for(i = 0; i < elements.length; i++) {
                    if (category == "once") {
                        elements[i].style.display = "none";
                    } else {
                        elements[i].style.display = "initial";
                    }
                }
            }
        </script>

        <form method="POST" action="/chart/orders/create/{{$patient->id}}">
            @csrf

            <table class="table">
                <tbody>

                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        <p class="pt-0">Information</p>
                    </th>
                </tr>

                <tr>
                    <td class="text-sm align-content-center">
                        <x-input-label for="category" :value="__('Category')" />
                    </td>

                    <td class="text-sm align-items-center">
                        <select id="category" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                name="category" required
                                onchange="displayPrescription(this.value)">
                            @foreach(\App\Models\Chart\Order::$category_index as $category)
                                <option value="{{ $category }}" {{ $category == "general" ? "selected" : ""}}>
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="text-sm align-content-center">
                        <x-input-label for="method" :value="__('Method')" />
                    </td>

                    <td class="text-sm align-items-center">
                        <select id="method" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                name="method" required>
                            @foreach(\App\Models\Chart\Order::$method_index as $method)
                                <option value="{{ $method }}" {{ $method == "written" ? "selected" : ""}}>
                                    {{ ucfirst($method) }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="text-sm align-content-center">
                        <x-input-label for="priority" :value="__('Priority')" />
                    </td>

                    <td class="text-sm align-items-center">
                        <select id="priority" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                name="priority" required>
                            @foreach(\App\Models\Chart\Order::$priority_index as $priority)
                                <option value="{{ $priority }}" {{ $priority == "routine" ? "selected" : ""}}>
                                    {{ ucfirst($priority) }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                @php
                    $def_starttime = (new \DateTime("now", Auth::user()->getTimeZone()))
                        ->format('Y-m-d\TH:i');
                @endphp

                <tr>
                    <td class="text-sm align-content-center">
                        <x-input-label for="start_time" :value="__('Start Time')" />
                    </td>

                    <td class="text-sm">
                        <x-text-input id="start_time" class="block mt-1 w-full text-sm shadow-sm"
                                      name="start_time" type="datetime-local"
                                      value="{{$def_starttime}}"
                                      required />
                    </td>
                </tr>

                <tr>
                    <td class="text-sm align-content-center">
                        <x-input-label for="end_time" :value="__('End Time')" />
                    </td>

                    <td class="text-sm">
                        <x-text-input id="end_time" class="block mt-1 w-full text-sm shadow-sm"
                                      name="end_time" type="datetime-local" />
                    </td>
                </tr>

                <tr>
                    <td class="text-sm align-content-center">
                        <x-input-label for="pend_order" :value="__('Pend Order')" />
                    </td>

                    <td class="text-sm">
                        <x-text-input id="pend_order" class="block my-2 p-2 text-sm shadow-sm"
                                      name="pend_order" type="checkbox" />
                    </td>
                </tr>
                </tbody>
            </table>

            <table class="prescription table w-100" style="display: none">
                <tbody>
                    <tr>
                        <th class="text-md align-content-start" colspan="2">
                            <p class="pt-0">Prescription</p>
                        </th>
                    </tr>

                    <tr>
                        <td class="text-sm align-content-center">
                            <x-input-label :value="__('Drug')" />
                        </td>

                        <td class="text-sm">
                            <div class="container">
                                <div class="row">
                                    <x-text-input id="drug" class="col block mt-1 w-full text-sm"
                                          name="drug" placeholder="Drug"/>

                                    <x-text-input id="dose_amount" class="col ms-2 block mt-1 w-full text-sm"
                                                  name="dose_amount" placeholder="Dose"/>

                                    <select id="dose_unit" class="col ms-2 block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            name="dose_unit">
                                        @foreach(\App\Models\Chart\Order::$doseunits_index as $doseunit)
                                            <option value="{{ $doseunit }}">
                                                {{ \App\Models\Chart\Order::$doseunits_text[array_search($doseunit, \App\Models\Chart\Order::$doseunits_index)] }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select id="route" class="col ms-2 block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            name="route">
                                        @foreach(\App\Models\Chart\Order::$routes_index as $route)
                                            <option value="{{ $route }}">
                                                {{ \App\Models\Chart\Order::$routes_text[array_search($route, \App\Models\Chart\Order::$routes_index)] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-sm align-content-center">
                        </td>

                        <td class="text-sm">
                            <div class="container">
                                <div class="row">
                                    <select id="period_type" class="col ms-0 block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            name="period_type"
                                            onchange="displayPeriodDetails(this.value)">
                                        @foreach(\App\Models\Chart\Order::$periodtypes_index as $periodtype)
                                            <option value="{{ $periodtype }}" @selected($periodtype == "repeats")>
                                                {{ \App\Models\Chart\Order::$periodtypes_text[array_search($periodtype, \App\Models\Chart\Order::$periodtypes_index)] }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <p class="prescription-period col-1 ms-2 text-center align-content-center">q</p>

                                    <x-text-input id="period_amount" class="prescription-period col ms-2 block mt-1 w-full text-sm"
                                                  name="period_amount" placeholder="#"/>

                                    <select id="period_unit" class="prescription-period col ms-2 block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            name="period_unit">
                                        @foreach(\App\Models\Chart\Order::$periodunits_index as $periodunit)
                                            <option value="{{ $periodunit }}" @selected($periodunit == "hour")>
                                                {{ \App\Models\Chart\Order::$periodunits_text[array_search($periodunit, \App\Models\Chart\Order::$periodunits_index)] }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <p class="prescription-period col-1 ms-2 text-center align-content-center">for</p>
                                    <x-text-input id="total_doses" class="col ms-2 block mt-1 w-full text-sm"
                                                  name="total_doses" placeholder="# of Doses" value="100"/>
                                    <p class="prescription-period col-1 ms-2 text-center align-content-center">doses</p>

                                </div>

                                <div class="row">
                                    <p style="color: darkgoldenrod" class="prescription-period col-12 text-center align-content-center mt-1 py-2">
                                        Note: Maximum 1,000 doses propagate to medication administration record per order.
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-sm align-content-center">
                        </td>

                        <td class="text-sm">
                            <div class="container">
                                <div class="row">

                                    <x-text-input id="indication" class="col ms-0 block mt-1 w-full text-sm"
                                                  name="indication" placeholder="Indication"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table w-100">
                <tbody>
                    <tr>
                        <th class="text-md align-content-start" colspan="2">
                            <p class="pt-0">Notes</p>
                        </th>
                    </tr>

                    <tr>
                        <td class="text-sm align-content-center">
                            <x-input-label for="note" :value="__('Note')" />
                        </td>

                        <td class="text-sm">
                            <x-text-input id="note" class="block mt-1 w-full text-sm"
                                          name="note"/>
                        </td>
                    </tr>

                    @if(!Auth::user()->canOrder())
                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="cosign_by" :value="__('Request Cosign By')" />
                            </td>

                            <td class="text-sm">
                                <select id="cosign_by" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        name="cosign_by" required>
                                    @foreach($cosigners as $cosigner)
                                        <option value="{{ $cosigner->id }}">
                                            {{ $cosigner->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                    @endif

                </tbody>
            </table>

            <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                <div class="flex justify-center">
                    <a href="/chart/orders/{{$patient->id}}" class="btn btn-outline-danger px-3 py-1 text-sm">Cancel</a>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="btn btn-outline-success px-3 py-1 text-sm">Sign</button>
                </div>
            </div>
        </form>
    @endsection

</x-chart.chart>
