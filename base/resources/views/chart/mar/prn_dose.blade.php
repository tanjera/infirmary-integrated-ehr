<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">PRN Dose Information</div>
            <div class="flex justify-end">
                @if(Auth::user()->canChart())
                    <a href="/chart/mar/prn_given/{{$order->id}}" class="btn btn-outline-success px-3 py-1 ms-2 text-sm">Mark Given</a>
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
                <td class="text-sm align-content-start w-25">Last Dose Administered:</td>
                <td class="text-sm align-content-start w-75">

                    @if(is_null($doses) || count($doses) == 0)
                        Never
                    @else
                        @php
                            $last_dose = $doses
                                ->where('status', 'given')
                                ->whereBetween('status_at', [$order->start_time, Auth::user()->dt_revertTimeZone($at_time)])
                                ->sortByDesc('status_at')->first();
                        @endphp
                    
                        @if(is_null($last_dose))
                            Never
                        @else
                            {{ Auth::user()->dt_applyTimeZone($last_dose->status_at)->format("d M o H:i")  }}
                        @endif
                    @endif

                </td>
            </tr>

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
