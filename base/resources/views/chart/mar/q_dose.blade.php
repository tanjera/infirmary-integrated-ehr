<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Dose Information</div>
            <div class="flex justify-end">
                @if(Auth::user()->canChart())
                    <a href="/chart/mar/q_status/{{$dose->id}}" class="btn btn-outline-danger px-3 py-1 ms-2 text-sm">Edit Status</a>

                    @if($dose->status != 'given')
                        <a href="/chart/mar/q_given/{{$dose->id}}" class="btn btn-outline-success px-3 py-1 ms-2 text-sm">Mark Given</a>
                    @endif
                @endif
            </div>
        </div>
    @endsection

    @section("chart_content")
        <table class="table">
            <tbody>
            <tr>
                <th class="text-md align-content-start" colspan="2">
                    Dose Information:
                </th>
            </tr>

            <tr>
                <td class="text-sm align-content-start w-25">Due:</td>
                <td class="text-sm align-content-start w-75">
                    {{ Auth::user()->dt_applyTimeZone($dose->due_at)->format("d M o H:i") }}
                </td>
            </tr>

            <tr>
                <td class="text-sm align-content-start w-25">Status:</td>
                <td class="text-sm align-content-start w-75">
                    {{ $dose->textStatus() }}
                </td>
            </tr>

            <tr>
                <td class="text-sm align-content-start w-25">Note:</td>
                <td class="text-sm align-content-start w-75">
                    {{ is_null($dose->note) ? "Empty" : $dose->note }}
                </td>
            </tr>

            @if(!is_null($dose->status_at))
                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        Status Change:
                    </th>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">Time:</td>
                    <td class="text-sm align-content-start w-75">
                        {{ Auth::user()->dt_applyTimeZone($dose->status_at)->format("d M o H:i") }}
                    </td>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">By:</td>
                    <td class="text-sm align-content-start w-75">
                        @php
                            $user = \App\Models\User::find($dose->status_by);
                            $name = is_null($user) ? "" : $user->name;
                        @endphp

                        {{ $name }}
                    </td>
                </tr>
            @endif

            <tr>
                <th class="text-md align-content-start" colspan="2">
                    Order Information:
                </th>
            </tr>

            <tr>
                <td class="text-sm align-content-start w-25">Order:</td>
                <td class="text-sm align-content-start w-75">
                    @php
                        $formatted = "$order->drug $order->dose_amount "
                        . $order->textDoseunit() . " " . $order->textRoute() . " ";
                        if ($order->period_type == 'once')
                            $formatted .= "once. ";
                        else {
                            if ($order->period_type == 'prn') {
                                $formatted .= "PRN ";
                            }

                            $formatted .= "q $order->period_amount $order->period_unit"
                            . ($order->period_amount > 1 ? "s" : "") .". ";
                        }
                    @endphp
                    <a href="/chart/orders/view/{{ $order->id }}">
                        {{ $formatted }}
                    </a>

                </td>
            </tr>

            <tr>
                <td class="text-sm align-content-start w-25">Indication:</td>
                <td class="text-sm align-content-start w-75"> {{ !is_null($order->indication) ? $order->indication : "None" }}</td>
            </tr>

            <tr>
                <td class="text-sm align-content-start w-25">Note:</td>
                <td class="text-sm align-content-start w-75"> {{ !is_null($order->note) ? $order->null : "Empty" }}</td>
            </tr>

            <tr>
                <td class="text-sm align-content-start w-25">Priority:</td>
                @if($order->priority == 'routine')
                    <td class="text-sm align-content-start w-75">{{ ucfirst($order->priority) }}</td>
                @elseif($order->priority == 'now')
                    <td class="text-sm align-content-start w-75 text-warning">{{ ucfirst($order->priority) }}</td>
                @elseif($order->priority == 'stat')
                    <td class="text-sm align-content-start w-75 text-danger">{{ ucfirst($order->priority) }}</td>
                @endif

            </tr>

            </tbody>
        </table>
    @endsection

</x-chart.chart>
