<x-chart.chart :patient="$patient" :at_time="$at_time">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Medication Administration Record (MAR)</div>
            <div class="flex justify-end">
                <x-text-input id="at_time" class="block mt-1 w-full text-sm shadow-sm"
                              name="at_time" type="datetime-local"
                              value="{{ $at_time->format('Y-m-d\TH:i') }}"
                              required />
            </div>
        </div>
    @endsection

    @section("chart_content")
        <table class="table">
            <tr>
                <td class="border-1 border-gray text-center p-2" style="width: 10%"> </td>

                @for($i = -4; $i <= 4; $i++)
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
                        <td class="border-1 border-gray text-center p-2" style="background: #ffe6ea">
                    @elseif($order->period_type == 'prn')
                        <td class="border-1 border-gray text-center p-2" style="background: #ffffe5">
                    @else
                        <td class="border-1 border-gray text-center p-2" style="background: #e5f9ff">
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
                                <p>{{ $order->drug }}</p>
                                <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                <p>{{ $formatted_period }}</p>
                                @if(trim($formatted_note) != '')
                                    <p class="text-xs" style="text-decoration: line-through">
                                        {{ $formatted_note }}
                                    </p>
                                @endif
                            </span>
                        @elseif($order->status == 'pending')
                            <span style="font-style: italic">
                                <p>{{ $order->drug }}</p>
                                <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                <p>{{ $formatted_period }}</p>
                                @if(trim($formatted_note) != '')
                                    <p class="text-xs" style="font-style: italic">
                                        {{ $formatted_note }}
                                    </p>
                                @endif
                            </span>
                        @else
                            <p>{{ $order->drug }}</p>
                                <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                            <p>{{ $formatted_period }}</p>
                            @if(trim($formatted_note) != '')
                                <p class="text-xs">{{ $formatted_note }}</p>
                            @endif
                        @endif

                    </td>

                    @php
                        $off_min = intval($at_time->format('i'));
                        $range_amount = 4;
                        $range_start = (clone $at_time)->sub(new \DateInterval('PT' . (($range_amount * 60) + $off_min) . 'M'));
                        $range_end = (clone $at_time)->add(new \DateInterval('PT' . ((($range_amount + 1) * 60) - $off_min - 1) . 'M59S'));

                        $order_doses = $doses->where('order', $order->id);
                        $range_doses = $doses->where('order', $order->id)
                            ->whereBetween('due_at', [$range_start, $range_end]);
                    @endphp

                    @for($i = -$range_amount; $i <= $range_amount; $i++)
                        @php
                            $temp_dose = false;
                            $col_start = clone $at_time;

                            if ($i <= 0)
                                $col_start->sub(new \DateInterval('PT' . ((abs($i) * 60) + $off_min) . 'M'));
                            else
                                $col_start->add(new \DateInterval('PT' . (($i * 60) - $off_min) . 'M'));

                            $col_end = (clone $col_start)->add(new \DateInterval('PT59M59S'));

                            if (count($range_doses) > 0)
                                $col_doses = $range_doses->whereBetween('due_at', [$col_start, $col_end]);
                            else {
                                $col_doses = [];

                                if ($i == 0 && $order->status == 'active' && $order->period_type == 'prn'){
                                    if (count($order_doses) == 0)
                                        $temp_dose = true;
                                    else {
                                        $period_span = (clone $at_time)->sub(new DateInterval('PT' . $order->getPeriodMinutes() . 'M'));

                                        if (count($order_doses->whereBetween('due_at', [$period_span, $at_time])) == 0)
                                            $temp_dose = true;
                                    }
                                }
                            }
                        @endphp

                        @if(count($col_doses) > 0 || $temp_dose == true)
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

                            @if(count($col_doses) == 1)
                                <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                <p>{{ $col_doses->first()->textStatus() . ": " .
                                        Auth::user()->adjustDateTime($col_doses->first()->due_at)->format("H:i") }}</p>
                            @elseif(count($col_doses) > 1)
                                {{ count($col_doses) }} Doses
                            @elseif($temp_dose == true)
                                <p>{{ $order->dose_amount . " " . $order->textDoseunit() . " " . $order->textRoute() }}</p>
                                <p>Available</p>
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
