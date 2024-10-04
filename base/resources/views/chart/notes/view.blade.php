<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Notes</div>
            <div class="flex justify-end">
                @if(Auth::user()->isManager())
                    <td class="align-content-center text-sm">
                        <a href="/chart/notes/delete/{{ $note->id }}" class="btn btn-outline-danger px-3 py-1 text-sm">Delete Note</a>
                    </td>
                @endif

                @if(Auth::user()->canChart())
                    <a href="/chart/notes/append/{{ $note->id }}" class="btn btn-outline-success px-3 py-1 ms-2 text-sm">Append an Addition</a>
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
                    <td class="text-sm align-content-start w-75">{{ $author->name }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Timestamp:</td>
                    <td class="text-sm align-content-start w-75">{{ Auth::user()->dt_applyTimeZone($note->created_at)->format("d M o H:i") }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Note:</td>
                    <td class="text-sm align-content-start w-75">
                        <p style="white-space: pre-line">{{ $note->body }}</p>
                    </td>
                </tr>

                @if(!is_null($attachments) && count($attachments) > 0)
                    <tr>
                        <th class="text-md align-content-start" colspan="2">
                            <p class="pt-3">Attachments</p>
                        </th>
                    </tr>

                    <tr>
                        <td colspan="2">

                            <table class="table">
                                <tbody>
                                    <tr>
                                        @foreach($attachments as $attachment)
                                            @if ($loop->index % 5 == 0)
                                                </tr>
                                                <tr>
                                            @endif

                                            <td style="width: {{100 / ($loop->count < 5 ? $loop->count : 5)}}%">
                                                <div class="border-1 border-gray rounded p-2">
                                                    <a href="{{asset("/storage/$attachment->filepath")}}">
                                                        <p class="pb-2 text-center">
                                                            {{$attachment->name}}
                                                        </p>
                                                        <img class="mx-auto py-1"
                                                             @if(str_starts_with($attachment->mimetype, "image/"))
                                                                 src="{{asset("/storage/$attachment->filepath")}}"
                                                             @else
                                                                 src="{{asset('vendor\third_party\icon_attachment.svg')}}"
                                                             height="64" width="64"
                                                             @endif
                                                             alt="{{$attachment->name}}"
                                                        />
                                                    </a>
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endif

                @foreach($additions as $addition)
                    <tr>
                        <th class="text-md align-content-start" colspan="2">
                            <p class="pt-3">Addition</p>
                        </th>
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
