<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header flex items-center">Confirm Deletion</div>
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

                    <p class="text-sm p-2">
                        Are you sure you want to delete this order?
                    </p>
                    <p class="text-sm p-2 text-danger">
                        Deleting this order will remove all its doses from the medication administration record (MAR) regardless of dose status!
                    </p>
                    <p class="text-sm p-2">
                        If you want to keep the drug doses on the MAR, consider discontinuing or completing the order.
                    </p>
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
                            <td class="text-sm align-content-start w-75">{{ Auth::user()->adjustDateTime($order->start_time)->format("d M o H:i") }}</td>
                        </tr>
                        <tr>
                            <td class="text-sm align-content-start w-25">End Time:</td>
                            <td class="text-sm align-content-start w-75">
                                @if(!is_null($order->end_time))
                                    {{ Auth::user()->adjustDateTime($order->start_time)->format("d M o H:i") }}
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
                                    {{ $authors->find($order->status_by)->name }} at {{ Auth::user()->adjustDateTime($order->updated_at)->format("d M o H:i") }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                        <div class="flex justify-center">
                            <a href="/chart/orders/{{ $patient->id }}" class="btn btn-outline-primary px-3 py-1 text-sm">No</a>
                        </div>
                        <div class="flex justify-center">
                            <a href="/chart/orders/delete/process/{{ $order->id }}" class="btn btn-outline-danger px-3 py-1 text-sm">Yes</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</x-app-layout>
