<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Allergies</div>
            <div class="flex justify-end">
                <a href="/chart/allergies/create/{{$patient->id}}" class="btn btn-outline-success px-3 py-1 ms-2 text-sm">Add Allergy</a>
            </div>
        </div>
    @endsection

    @section("chart_content")

        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="align-content-center text-sm">Allergen</th>
                    <th scope="col" class="align-content-center text-sm">Reaction</th>
                    <th scope="col" class="align-content-center text-sm">Severity</th>
                    <th scope="col" class="align-content-center text-sm">Notes</th>
                    <th scope="col" class="align-content-center text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (count($allergies) > 0)
                    @foreach ($allergies as $allergy)

                        <tr>
                            <td class="align-content-center text-sm">{{ $allergy->allergen }}</td>
                            <td class="align-content-center text-sm">{{ $allergy->reaction }}</td>
                            <td class="align-content-center text-sm">{{ ucfirst($allergy->severity) }}</td>
                            <td class="align-content-center text-sm">{{ $allergy->notes }}</td>
                            <td class="align-content-center text-sm">
                                <a href="/chart/allergies/delete/{{$allergy->id}}" class="btn btn-outline-danger px-3 py-1 ms-2 text-sm">Delete</a>
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
