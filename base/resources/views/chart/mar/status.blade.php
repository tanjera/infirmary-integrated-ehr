<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Dose Status</div>
            <div class="flex justify-end"></div>
        </div>
    @endsection

    @section("chart_content")
        <form method="POST" action="/chart/mar/status/{{$dose->id}}">
            @csrf

            <table class="table">
                <tbody>
                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        Dose Information:
                    </th>
                </tr>

                <tr>
                    <td class="text-sm align-content-center">
                        <x-input-label for="status" :value="__('Status')" />
                    </td>
                    <td class="text-sm align-items-center">
                        <select id="category" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                name="status" required>
                            @foreach(\App\Models\Chart\MAR\Dose::$status_text as $status)
                                <option value="{{ $status }}" {{ $status == $dose->textStatus() ? "selected" : ""}}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                @php
                    $def_status_at = (new \DateTime("now", Auth::user()->getTimeZone()))
                        ->format('Y-m-d\TH:i');
                @endphp

                <tr>
                    <td class="text-sm align-content-center">
                        <x-input-label for="status_at" :value="__('Time')" />
                    </td>

                    <td class="text-sm">
                        <x-text-input id="status_at" class="block mt-1 w-full text-sm shadow-sm"
                                      name="status_at" type="datetime-local"
                                      value="{{$def_status_at}}"
                                      required />
                    </td>
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

                </tbody>
            </table>

            <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                <div class="flex justify-center">
                    <a href="/chart/mar/dose/{{$dose->id}}" class="btn btn-outline-danger px-3 py-1 text-sm">Cancel</a>
                </div>
                <div class="flex justify-center">
                    @if(Auth::user()->canChart())
                        <button type="submit" class="btn btn-outline-success px-3 py-1 text-sm">Sign</button>
                    @endif
                </div>
            </div>
        </form>
    @endsection

</x-chart.chart>
