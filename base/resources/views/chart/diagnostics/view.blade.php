<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Diagnostic Reports</div>
            <div class="flex justify-end">
                @if(Auth::user()->canChart())
                    <a href="/chart/diagnostics/append/{{ $report->id }}" class="btn btn-outline-primary px-3 py-1 ms-2 text-sm">Append an Addition</a>
                @endif
            </div>
        </div>
    @endsection

    @section("chart_content")
        <table class="table">
            <tbody>
                <tr>
                    <th class="text-md align-content-start" colspan="2">
                        {{ $report->textCategory() }}
                    </th>
                </tr>

                <tr>
                    <td class="text-sm align-content-start w-25">Author:</td>
                    <td class="text-sm align-content-start w-75">{{ $report->author }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Timestamp:</td>
                    <td class="text-sm align-content-start w-75">{{ date("d M o H:i", strtotime($report->created_at)) }}</td>
                </tr>
                <tr>
                    <td class="text-sm align-content-start w-25">Note:</td>
                    <td class="text-sm align-content-start w-75">
                        <p style="white-space: pre-line">{{ $report->body }}</p>
                    </td>
                </tr>

                @if(!is_null($attachments) && count($attachments) > 0)
                    <tr>
                        <th class="text-md align-content-start" colspan="2">
                            Attachments
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

                                            <td>
                                                <a href="{{asset("/storage/$attachment->filepath")}}">
                                                    <img
                                                        src="{{asset("/storage/$attachment->filepath")}}"
                                                        alt="Attachment"
                                                    />
                                                </a>
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
