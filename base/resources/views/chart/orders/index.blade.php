<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Orders</div>
            <div class="flex justify-end">
                @if(Auth::user()->canChart())
                    <a href="/chart/orders/create/{{$patient->id}}" class="btn btn-outline-success px-3 py-1 ms-2 text-sm">Write an Order</a>
                @endif
            </div>
        </div>
    @endsection

    @section("chart_content")

        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="align-content-center w-25 text-sm">Timestamp</th>
                <th scope="col" class="align-content-center w-25 text-sm">Author</th>
                <th scope="col" class="align-content-center w-25 text-sm">Order</th>
            </tr>
            </thead>
            <tbody>
            @if (count($orders) > 0)
                @foreach ($orders as $order)
                    <tr>
                        <td class="align-content-center text-sm">
                        </td>
                        <td class="align-content-center text-sm">
                        </td>
                        <td class="align-content-center text-sm">
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
