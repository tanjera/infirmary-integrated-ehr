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
                <td class="border-1 border-gray text-center p-2" style="width: 20%"> </td>

                @for($i = -4; $i < 4; $i++)
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
                        <td class="border-1 border-gray text-center p-2" style="background: lightpink">
                    @elseif($order->period_type == 'prn')
                        <td class="border-1 border-gray text-center p-2" style="background: lightyellow">
                    @else
                        <td class="border-1 border-gray text-center p-2" style="background: powderblue">
                    @endif


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

                            $formatted_note = "";

                            if (!is_null($order->indication)) {
                                $formatted_note .= "Indication: $order->indication"
                                . (str_ends_with($order->indication, '.') ? " " : ". ");
                            }
                            if (!is_null($order->note)) {
                                $formatted_note .= "Note: $order->note"
                                . (str_ends_with($order->indication, '.') ? " " : ". ");
                            }
                        @endphp

                        @if($order->status == 'discontinued' || $order->status == 'completed')
                            <span style="text-decoration: line-through">{{ $formatted }}
                                @if(trim($formatted_note) != '')
                                    <p class="text-xs" style="text-decoration: line-through">
                                        {{ $formatted_note }}
                                    </p>
                                @endif
                            </span>
                        @elseif($order->status == 'pending')
                            <span style="font-style: italic">
                                {{ $formatted }}
                                @if(trim($formatted_note) != '')
                                    <p class="text-xs" style="font-style: italic">
                                        {{ $formatted_note }}
                                    </p>
                                @endif
                            </span>
                        @else
                            {{ $formatted }}
                            @if(trim($formatted_note) != '')
                                <p class="text-xs">{{ $formatted_note }}</p>
                            @endif
                        @endif

                    </td>

                    @for($i = -4; $i < 4; $i++)
                        @php
                            $col_time = clone $at_time;
                            $off_min = intval($at_time->format('i'));

                            if ($i <= 0)
                                $col_time->sub(new \DateInterval('PT' . ((abs($i) * 60) + $off_min) . 'M'));
                            else
                                $col_time->add(new \DateInterval('PT' . (($i * 60) - $off_min) . 'M'));

                        @endphp

                        <td class="border-1 border-gray text-center p-2" style="width: 10%">
                        </td>
                    @endfor
                </tr>
            @endforeach
        </table>
    @endsection

</x-chart.chart>
