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
                @if(Auth::user()->isManager())
                    <th scope="col" class="align-content-center w-25 text-sm">Actions</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @if (count($notes) > 0)
                @foreach ($notes as $note)
                    <tr>
                        <td class="align-content-center text-sm">
                            <a href="{{ route('chart.notes.view', ['id' => $note->id]) }}">
                                {{ date("d M o H:i", strtotime($note->created_at)) }}
                            </a>
                        </td>
                        <td class="align-content-center text-sm">
                            <a href="{{ route('chart.notes.view', ['id' => $note->id]) }}">
                                {{ $note->textCategory() }}
                            </a>
                        </td>
                        <td class="align-content-center text-sm">
                            <a href="{{ route('chart.notes.view', ['id' => $note->id]) }}">
                                {{ $note->author }}
                            </a>
                        </td>

                        @if(Auth::user()->isManager())
                            <td class="align-content-center text-sm">
                                <a href="/chart/notes/delete/{{ $note->id }}" class="btn btn-outline-danger px-3 py-1 text-sm">Delete</a>
                            </td>
                        @endif
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
