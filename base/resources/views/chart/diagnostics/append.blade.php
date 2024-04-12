<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="flex items-center">Append a Report Addition</div>
    @endsection

    @section("chart_content")
        <form method="POST" action="/chart/diagnostics/affix/{{$report->id}}">
            @csrf

            <table class="table">
                <tbody>
                <tr>
                    <td class="text-sm align-content-center">
                        <x-input-label for="body" :value="__('Addition')" />
                    </td>

                    <td class="text-sm">
                        <textarea id="body" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                  rows="16"
                                  name="body"></textarea>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                <div class="flex justify-center">
                    <a href="/chart/diagnostics/view/{{$report->id}}" class="btn btn-outline-danger px-3 py-1 text-sm">Cancel</a>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="btn btn-outline-success px-3 py-1 text-sm">Save</button>
                </div>
            </div>
        </form>
    @endsection

</x-chart.chart>
