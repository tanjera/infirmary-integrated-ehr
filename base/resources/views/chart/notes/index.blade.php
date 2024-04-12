<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Notes</div>
            <div class="flex justify-end">
                @if(Auth::user()->canChart())
                    <a href="/chart/notes/create/{{$patient->id}}" class="btn btn-outline-success px-3 py-1 ms-2 text-sm">Create a Note</a>
                @endif
            </div>
        </div>
    @endsection

    @section("chart_content")

        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="align-content-center w-25 text-sm">Timestamp</th>
                <th scope="col" class="align-content-center w-25 text-sm">Category</th>
                <th scope="col" class="align-content-center w-25 text-sm">Author</th>
            </tr>
            </thead>
            <tbody>
            @if (count($notes) > 0)
                @foreach ($notes as $note)
                    @php
                        $hasAttachments = (count($attachments->whereIn('note', $note->id)) > 0);
                    @endphp

                    <tr>
                        <td class="align-content-center text-sm">
                            <a href="{{ route('chart.notes.view', ['id' => $note->id]) }}">
                                {{ Auth::user()->adjustDateTime($note->created_at)->format("d M o H:i") }}
                            </a>
                        </td>
                        <td class="align-content-center text-sm">
                            <table>
                                <tr>
                                    <td>
                                        <a href="{{ route('chart.notes.view', ['id' => $note->id]) }}">
                                            {{ $note->textCategory() }}
                                        </a>
                                    </td>
                                    <td class="ps-2">
                                        @if($hasAttachments)
                                            <img
                                                src="{{asset('vendor\third_party\icon_attachment.svg')}}"
                                                alt="Attachment Present"
                                                height="16"
                                                width="16" />
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="align-content-center text-sm">
                            <a href="{{ route('chart.notes.view', ['id' => $note->id]) }}">
                                {{ $note->author }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>No Data</td>
                </tr>
            @endif
            </tbody>
        </table>

    @endsection

</x-chart.chart>
