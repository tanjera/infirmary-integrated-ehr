<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Notes</div>
            <div class="flex justify-end">
                @if(Auth::user()->canChart())
                    <a href="/chart/notes/append/{{ $note->id }}" class="btn btn-outline-primary px-3 py-1 ms-2 text-sm">Append an Addition</a>
                @endif
            </div>
        </div>
    @endsection

    @section("chart_content")
        <table class="table">
            <tbody>
                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        {{ $note->textCategory() }}
                    </th>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">Author:</td>
                    <td class="text-sm align-content-start w-75">{{ $note->author }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Timestamp:</td>
                    <td class="text-sm align-content-start w-75">{{ date("d M o H:i", strtotime($note->created_at)) }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Note:</td>
                    <td class="text-sm align-content-start w-75">
                        <p style="white-space: pre-line">{{ $note->body }}</p>
                    </td>
                </tr>

            @foreach($additions as $addition)
                <tr>
                    <th class="text-md align-content-start" colspan="2">Addition</th>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">Author:</td>
                    <td class="text-sm align-content-start w-75">{{ $addition->author }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Timestamp:</td>
                    <td class="text-sm align-content-start w-75">{{ date("d M o H:i", strtotime($addition->created_at)) }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Note:</td>
                    <td class="text-sm align-content-start w-75">
                        <p style="white-space: pre-line">{{ $addition->body }}</p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endsection

</x-chart.chart>
