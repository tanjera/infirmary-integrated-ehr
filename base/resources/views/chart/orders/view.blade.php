<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Order Information</div>
            <div class="flex justify-end">
                @if(Auth::user()->canChart() && $order->status == "pending")
                    <a href="/chart/orders/activate/{{$order->id}}" class="btn btn-outline-primary px-3 py-1 ms-2 text-sm">Activate Order</a>
                @endif

                @if(Auth::user()->canChart() && $order->status == "active")
                    <a href="/chart/orders/complete/{{$order->id}}" class="btn btn-outline-secondary px-3 py-1 ms-2 text-sm">Complete Order</a>
                @endif

                @if(Auth::user()->canOrder() && ($order->status == "active" || $order->status == "pending"))
                    <a href="/chart/orders/discontinue/{{$order->id}}" class="btn btn-outline-secondary px-3 py-1 ms-2 text-sm">Discontinue Order</a>
                @endif

                @if($order->cosign_complete == false && Auth::user()->id == $order->cosigned_by)
                    <a href="/chart/orders/cosign/{{$order->id}}" class="btn btn-outline-success px-3 py-1 ms-2 text-sm">Cosign Order</a>
                @endif

                @if(Auth::user()->isManager() || Auth::user() ->isAdministrator())
                    <a href="/chart/orders/delete/{{$order->id}}" class="btn btn-outline-danger px-3 py-1 ms-2 text-sm">Delete Order</a>
                @endif
            </div>
        </div>
    @endsection

    @section("chart_content")
        <table class="table">
            <tbody>
            <tr>
                <th class="text-md align-content-start" colspan="2">
                    Order
                </th>
            </tr>

            @if($order->category == 'general')
                <tr>
                    <td class="text-sm align-content-start w-25">Order:</td>
                    <td class="text-sm align-content-start w-75">
                            {{ $order->note }}
                    </td>
                </tr>
            @elseif($order->category == 'medication')
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

                        {{ $formatted }}

                    </td>
                </tr>

                @if($order->period_type != 'once' && !is_null($order->total_doses))
                    <tr>
                        <td class="text-sm align-content-start w-25">Total Doses:</td>
                        <td class="text-sm align-content-start w-75"> {{ $order->total_doses }}</td>
                    </tr>
                @endif

                <tr>
                    <td class="text-sm align-content-start w-25">Indication:</td>
                    <td class="text-sm align-content-start w-75"> {{ !is_null($order->indication) ? $order->indication : "None" }}</td>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">Note:</td>
                    <td class="text-sm align-content-start w-75"> {{ !is_null($order->note) ? $order->null : "Empty" }}</td>
                </tr>
            @endif

            <tr>
                <td class="text-sm align-content-start w-25">Start Time:</td>
                <td class="text-sm align-content-start w-75">{{ Auth::user()->dt_applyTimeZone($order->start_time)->format("d M o H:i") }}</td>
            </tr>
            <tr>
                <td class="text-sm align-content-start w-25">End Time:</td>
                <td class="text-sm align-content-start w-75">
                    @if(!is_null($order->end_time))
                        {{ Auth::user()->dt_applyTimeZone($order->start_time)->format("d M o H:i") }}
                    @else
                        No End Time
                    @endif

                </td>
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

            <tr>
                <th class="text-md align-content-start" colspan="2">
                    Order Information
                </th>
            </tr>
            <tr>
                <td class="text-sm align-content-start w-25">Method:</td>
                <td class="text-sm align-content-start w-75">{{ ucfirst($order->method) }}</td>
            </tr>

            <tr>
                <td class="text-sm align-content-start w-25">Ordered By:</td>
                <td class="text-sm align-content-start w-75">{{ $authors->find($order->ordered_by)->name }}</td>
            </tr>

            @if(!is_null($order->cosigned_by) && $order->cosign_complete == false)
                <tr>
                    <td class="text-sm align-content-start w-25 text-warning">Awaiting Cosign By:</td>
                    <td class="text-sm align-content-start w-75">{{ $authors->find($order->cosigned_by)->name }}</td>
                </tr>
            @elseif(!is_null($order->cosigned_by) && $order->cosign_complete == true)
                <tr>
                    <td class="text-sm align-content-start w-25">Cosigned By:</td>
                    <td class="text-sm align-content-start w-75">{{ $authors->find($order->cosigned_by)->name }}</td>
                </tr>
            @endif

            <tr>
                <td class="text-sm align-content-start w-25">Status:</td>
                @if($order->status == 'active')
                    <td class="text-sm align-content-start w-75">{{ ucfirst($order->status) }}</td>
                @elseif($order->status == 'pending')
                    <td class="text-sm align-content-start w-75 text-warning">{{ ucfirst($order->status) }}</td>
                @elseif($order->status == 'discontinued')
                    <td class="text-sm align-content-start w-75 text-danger">{{ ucfirst($order->status) }}</td>
                @elseif($order->status == 'completed')
                    <td class="text-sm align-content-start w-75 text-success">{{ ucfirst($order->status) }}</td>
                @endif
            </tr>
            <tr>
                <td class="text-sm align-content-start w-25">Status Updated By:</td>
                <td class="text-sm align-content-start w-75">
                    @if(!is_null($order->status_by))
                        {{ $authors->find($order->status_by)->name }} at {{ Auth::user()->dt_applyTimeZone($order->updated_at)->format("d M o H:i") }}
                    @else
                        Not Applicable
                    @endif
                </td>
            </tr>

            @if($order->category == 'medication')
                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        Doses
                    </th>
                </tr>

                @php
                    $doses = \App\Models\Chart\MAR\Dose::where('order', $order->id)->get();
                @endphp

                @if($doses->count() == 0)
                    <tr>
                        <td class="text-sm align-content-start w-25"></td>
                        <td class="text-sm align-content-start w-75">
                            No Doses Administered
                        </td>
                    </tr>
                @endif

                @foreach($doses as $dose)
                    <tr>
                        <td class="text-sm align-content-start w-25"></td>
                        <td class="text-sm align-content-start w-75">
                            <a href="/chart/mar/q_dose/{{ $dose->id }}">
                                @if($dose->status == "due")
                                    <span style="color: red">
                                @elseif($dose->status == "not_given")
                                    <span style="color: black">
                                @elseif($dose->status == "given")
                                    <span style="color: gray">
                                @endif
                                    {{ $dose->textStatus() }}
                                </span>

                                at

                                @if(!is_null($dose->status_at))
                                    {{ Auth::user()->dt_applyTimeZone($dose->status_at)->format("d M o H:i") }}
                                    (due {{ Auth::user()->dt_applyTimeZone($dose->due_at)->format("d M o H:i") }})
                                @else
                                    {{ Auth::user()->dt_applyTimeZone($dose->due_at)->format("d M o H:i") }}
                                @endif
                            </a>
                        </td>
                    </tr>
                @endforeach

            @endif

            </tbody>
        </table>
    @endsection

</x-chart.chart>
