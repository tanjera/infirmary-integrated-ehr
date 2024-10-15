<x-chart.chart :patient="$patient" :at_time="$at_time">

    @section("chart_title")
        <div class="grid grid-cols-3">
            @php
                if (gettype($at_time) == "string")
                    $at_time = new \DateTime($at_time, Auth::user()->getTimeZone());
            @endphp

            <form method="GET" action="/chart/mar/{{$patient->id}}">
                @csrf
                <div class="row">
                    <div class="col flex items-center">Medication Administration Record (MAR)</div>
                    <div class="col items-center">
                        <x-text-input id="at_time" class="block w-full text-sm shadow-sm"
                                      name="at_time" type="datetime-local"
                                      value="{{ $at_time->format('Y-m-d\TH:i') }}" />
                    </div>
                    <div class="col flex items-center justify-content-end">
                        <button type="submit" name="at_time" value="{{ (clone $at_time)->sub(new \DateInterval('PT8H'))->format('c') }}"
                                class="btn btn-outline-success mx-1 px-3 py-1 text-sm">&#8592;</button>
                        <button type="submit" class="btn btn-outline-success mx-1 px-3 py-1 text-sm">Set Time</button>
                        <button type="submit" name="at_time" value="{{ (clone $at_time)->add(new \DateInterval('PT8H'))->format('c') }}"
                                class="btn btn-outline-success mx-1 px-3 py-1 text-sm">&#8594;</button>
                    </div>
                </div>
            </form>
        </div>
    @endsection

    @section("chart_content")
        <table class="table">
            <tr>
                <td class="border-1 border-gray text-center p-2" style="width: 10%">{{-- Drug Column--}}</td>

                @php
                    $range_amount = 4;
                @endphp

                @for($i = -$range_amount; $i <= $range_amount; $i++)
                    @php
                        $col_time = clone $at_time;
                        $off_min = intval($at_time->format('i'));

                        if ($i <= 0)
                            $col_time->sub(new \DateInterval('PT' . ((abs($i) * 60) + $off_min) . 'M'));
                        else
                            $col_time->add(new \DateInterval('PT' . (($i * 60) - $off_min) . 'M'));

                    @endphp

                    <td class="border-1 border-gray text-center p-2" style="width: 10%">
                        @if($i == 0)
                            <p style="font-weight: bold">{{ $col_time->format("d M o") }}</p>
                            <p style="font-weight: bold">{{ $col_time->format("H:i") }}</p>
                        @else
                            <p>{{ $col_time->format("d M o") }}</p>
                            <p>{{ $col_time->format("H:i") }}</p>
                        @endif
                    </td>
                @endfor
            </tr>

            @foreach($orders as $order)
                <tr>

                    @if($order->status != 'active')
                        <td class="border-1 border-gray text-center p-2" style="background: #e3cdd1">
                    @elseif($order->period_type == 'prn')
                        <td class="border-1 border-gray text-center p-2" style="background: #e3e3cf">
                    @else
                        <td class="border-1 border-gray text-center p-2" style="background: #ccdee3">
                    @endif

                        @php
                            $formatted_period = "";

                            if ($order->period_type == 'once')
                                $formatted_period .= "once";
                            else {
                                if ($order->period_type == 'prn') {
                                    $formatted_period .= "PRN ";
                                }

                                $formatted_period .= "q $order->period_amount $order->period_unit"
                                . ($order->period_amount > 1 ? "s" : "");
                            }

                            $formatted_note = "";

                            if (!is_null($order->indication)) {
                                $formatted_note .= "$order->indication"
                                . (str_ends_with($order->indication, '.') ? " " : ". ");
                            }
                            if (!is_null($order->note)) {
                                $formatted_note .= "$order->note"
                                . (str_ends_with($order->indication, '.') ? " " : ". ");
                            }
                        @endphp

                        @if($order->status == 'discontinued' || $order->status == 'completed')
                            <span style="text-decoration: line-through">
                                <a href="/chart/orders/view/{{ $order->id }}">
                                    <p>{{ $order->drug }}</p>
                                    <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                    <p>{{ $formatted_period }}</p>
                                    @if(trim($formatted_note) != '')
                                        <p class="text-xs" style="text-decoration: line-through">
                                            {{ $formatted_note }}
                                        </p>
                                    @endif
                                </a>
                            </span>
                        @elseif($order->status == 'pending')
                            <span style="font-style: italic">
                                <a href="/chart/orders/view/{{ $order->id }}">
                                    <p>{{ $order->drug }}</p>
                                    <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                    <p>{{ $formatted_period }}</p>
                                    @if(trim($formatted_note) != '')
                                        <p class="text-xs" style="font-style: italic">
                                            {{ $formatted_note }}
                                        </p>
                                    @endif
                                </a>
                            </span>
                        @else
                            <a href="/chart/orders/view/{{ $order->id }}">
                                <p>{{ $order->drug }}</p>
                                    <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                <p>{{ $formatted_period }}</p>
                                @if(trim($formatted_note) != '')
                                    <p class="text-xs">{{ $formatted_note }}</p>
                                @endif
                            </a>
                        @endif

                    </td>

                    @php
                        $off_min = intval($at_time->format('i'));
                        $range_start = (clone $at_time)->sub(new \DateInterval('PT' . (($range_amount * 60) + $off_min) . 'M'));
                        $range_end = (clone $at_time)->add(new \DateInterval('PT' . ((($range_amount + 1) * 60) - $off_min - 1) . 'M59S'));

                        $order_doses = $doses->where('order', $order->id);
                        $range_doses = $doses->where('order', $order->id)
                            ->whereBetween('due_at', [$range_start, $range_end]);
                    @endphp

                    @for($i = -$range_amount; $i <= $range_amount; $i++)
                        @php
                            $prn_dose_due = false;
                            $col_start = clone $at_time;

                            if ($i <= 0)
                                $col_start->sub(new \DateInterval('PT' . ((abs($i) * 60) + $off_min) . 'M'));
                            else
                                $col_start->add(new \DateInterval('PT' . (($i * 60) - $off_min) . 'M'));

                            $col_end = (clone $col_start)->add(new \DateInterval('PT59M59S'));

                            if (count($range_doses) > 0)
                                $col_doses = $range_doses->whereBetween('due_at', [$col_start, $col_end]);
                            else
                                $col_doses = [];

                            // If it is a PRN order, check if a dose has been given in the last available timespan
                            if ($i == 0 && $order->status == 'active' && $order->period_type == 'prn'){
                                $period_span = (clone $at_time)->sub(new DateInterval('PT' . $order->getPeriodMinutes() . 'M'));
                                if (count($order_doses
                                    ->where('status', 'given')
                                    ->whereBetween('due_at', [$period_span, $at_time])) == 0)
                                    $prn_dose_due = true;
                            }

                        @endphp

                        @if(count($col_doses) > 0 || $prn_dose_due)
                            @if($order->status != 'active')
                                <td class="border-1 border-gray text-center align-middle p-2" style="background: #ffe6ea">
                            @elseif($order->period_type == 'prn')
                                <td class="border-1 border-gray text-center align-middle p-2" style="background: #ffffe5">
                            @else
                                <td class="border-1 border-gray text-center align-middle p-2" style="background: #e5f9ff">
                            @endif

                            @if($order->status == 'discontinued' || $order->status == 'completed')
                                <span style="text-decoration: line-through">
                            @elseif($order->status == 'pending')
                                <span style="font-style: italic">
                            @else
                                <span>
                            @endif

                            @if($prn_dose_due == true)
                                <a href="/chart/mar/prn_dose/{{ $order->id }}">
                                    <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                    <p>Available</p>
                                </a>
                            @endif

                            @if(count($col_doses) > 0)
                                @if(count($col_doses) == 1)
                                    <a href="/chart/mar/q_dose/{{ $col_doses->first()->id }}">
                                        <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                    </a>
                                @else
                                    <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                @endif

                                @foreach($col_doses as $each_dose)
                                    <a href="/chart/mar/q_dose/{{ $each_dose->id }}">
                                        @if($each_dose->status == "due")
                                            <p style="color: red">
                                        @elseif($each_dose->status == "not_given")
                                            <p style="color: black">
                                        @elseif($each_dose->status == "given")
                                            <p style="color: gray">
                                        @endif

                                        @if(is_null($each_dose->status_at))
                                            {{ $each_dose->textStatus() . ": " . Auth::user()->dt_applyTimeZone($each_dose->due_at)->format("H:i") }}</p>
                                        @else
                                            {{ $each_dose->textStatus() . ": " . Auth::user()->dt_applyTimeZone($each_dose->status_at)->format("H:i") }}</p>
                                        @endif

                                    </a>
                                @endforeach
                            @endif

                            </span>
                        @else
                            <td class="border-1 border-gray text-center p-2">
                        @endif

                        </td>
                    @endfor
                </tr>
            @endforeach
        </table>
    @endsection

</x-chart.chart>
