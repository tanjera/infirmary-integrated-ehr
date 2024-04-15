<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Orders</div>
            <div class="flex justify-end">
                @if(Auth::user()->canChart())
                    <a href="/chart/orders/create/{{$patient->id}}" class="btn btn-outline-success px-3 py-1 ms-2 text-sm">Write an Order</a>
                @endif
            </div>
        </div>
    @endsection

    @section("chart_content")

        <table class="table">
            <tbody>
            <tr>
                <th scope="col" class="align-content-center text-sm">General Orders</th>
            </tr>

            @if (count($orders->where('category', 'general')) > 0)
                @foreach ($orders->where('category', 'general') as $order)
                    <tr>
                        <td class="align-content-center text-sm">

                            @if($order->status != "active" || $order->priority == 'routine')
                                <div class="container-fluid">
                            @elseif($order->status == "active" && $order->priority == 'now')
                                <div class="container-fluid border-1 border-warning rounded-2 p-2">
                            @elseif($order->status == "active" && $order->priority == 'stat')
                                <div class="container-fluid border-1 border-danger rounded-2 p-2">
                            @endif

                                <div class="row">
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Start: </span>
                                            {{ Auth::user()->adjustDateTime($order->start_time)->format("d M o H:i") }}
                                        </a>
                                    </div>
                                    <div class="col-9">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            @if($order->status == 'discontinued' || $order->status == 'completed')
                                                <span style="text-decoration: line-through">{{ $order->note }}</span>
                                            @elseif($order->status == 'pending')
                                                <span style="font-style: italic">{{ $order->note }}</span>
                                            @else
                                                    {{ $order->note }}
                                            @endif
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            @if(!is_null($order->end_time))
                                                <span class="text-gray-400">End: </span>
                                                {{ Auth::user()->adjustDateTime($order->end_time)->format("d M o H:i") }}
                                            @else
                                                <span class="text-gray-400">No End Date</span>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Priority: </span>
                                            @if($order->priority == 'stat')
                                                <span class="text-danger">{{ ucfirst($order->priority) }}</span>
                                            @elseif($order->priority == 'now')
                                                <span class="text-warning">{{ ucfirst($order->priority) }}</span>
                                            @else
                                                <span class="text-gray-400">{{ ucfirst($order->priority) }}</span>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Status: {{ ucfirst($order->status) }}</span>
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Method: {{ ucfirst($order->method) }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Ordered by: </span>
                                            {{ $authors->find($order->ordered_by)->name }}
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            @if(!is_null($order->cosigned_by) && $order->cosign_complete == false)
                                                <span class="text-warning">Awaiting Cosign: </span>
                                                {{ $authors->find($order->cosigned_by)->name }}
                                            @elseif(!is_null($order->cosigned_by) && $order->cosign_complete == true)
                                                <span class="text-gray-400">Cosigned By: </span>
                                                {{ $authors->find($order->cosigned_by)->name }}
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>
                        <p class="px-2">No General Orders</p>
                    </td>
                </tr>
            @endif

            <tr>
                <th scope="col" class="pt-3 align-content-center text-sm">Medication Orders</th>
            </tr>

            @if (count($orders->where('category', 'medication')) > 0)
                @foreach ($orders->where('category', 'medication') as $order)
                    <tr>
                        <td class="align-content-center text-sm">

                            @if($order->priority == 'routine')
                                <div class="container-fluid">
                            @elseif($order->priority == 'now')
                                <div class="container-fluid border-1 border-warning rounded-2 p-2">
                            @elseif($order->priority == 'stat')
                                <div class="container-fluid border-1 border-danger rounded-2 p-2">
                            @endif

                                <div class="row">
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Start: </span>
                                            {{ Auth::user()->adjustDateTime($order->start_time)->format("d M o H:i") }}
                                        </a>
                                    </div>
                                    <div class="col-9">
                                        @php
                                            $formatted = "$order->drug $order->dose $order->dose_amount "
                                            . $order->textDoseunit() . " " . $order->textRoute() . " ";
                                            if ($order->period_type == 'once')
                                                $formatted .= "once. ";
                                            else {
                                                if ($order->period_type == 'prn') {
                                                    $formatted .= "PRN ";
                                                }

                                                $formatted .= "q $order->period_amount $order->period_unit"
                                                . ($order->period_amount > 1 ? "s" : "") .". ";

                                                if (!is_null($order->total_doses)) {
                                                    $formatted .= "Total doses: $order->total_doses"
                                                    . (str_ends_with($order->indication, '.') ? " " : ". ");
                                                }
                                                if (!is_null($order->indication)) {
                                                    $formatted .= "Indication: $order->indication"
                                                    . (str_ends_with($order->indication, '.') ? " " : ". ");
                                                }
                                                if (!is_null($order->note)) {
                                                    $formatted .= "Note: $order->note"
                                                    . (str_ends_with($order->indication, '.') ? " " : ". ");
                                                }
                                            }
                                        @endphp

                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            @if($order->status == 'discontinued' || $order->status == 'completed')
                                                <span style="text-decoration: line-through">{{ $formatted }}</span>
                                            @elseif($order->status == 'pending')
                                                <span style="font-style: italic">{{ $formatted }}</span>
                                            @else
                                                {{ $formatted }}
                                            @endif
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            @if(!is_null($order->end_time))
                                                <span class="text-gray-400">End: </span>
                                                {{ Auth::user()->adjustDateTime($order->end_time)->format("d M o H:i") }}
                                            @else
                                                <span class="text-gray-400">No End Date</span>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Priority: </span>
                                            @if($order->priority == 'stat')
                                                <span class="text-danger">{{ ucfirst($order->priority) }}</span>
                                            @elseif($order->priority == 'now')
                                                <span class="text-warning">{{ ucfirst($order->priority) }}</span>
                                            @else
                                                <span class="text-gray-400">{{ ucfirst($order->priority) }}</span>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Status: {{ ucfirst($order->status) }}</span>
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Method: {{ ucfirst($order->method) }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            <span class="text-gray-400">Ordered by: </span>
                                            {{ $authors->find($order->ordered_by)->name }}
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <a href="/chart/orders/view/{{ $order->id }}">
                                            @if(!is_null($order->cosigned_by) && $order->cosign_complete == false)
                                                <span class="text-warning">Awaiting Cosign: </span>
                                                {{ $authors->find($order->cosigned_by)->name }}
                                            @elseif(!is_null($order->cosigned_by) && $order->cosign_complete == true)
                                                <span class="text-gray-400">Cosigned By: </span>
                                                {{ $authors->find($order->cosigned_by)->name }}
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>
                        <p class="px-2">No Medication Orders</p>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    @endsection

</x-chart.chart>
