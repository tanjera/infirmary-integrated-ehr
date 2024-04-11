<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="flex items-center">Patient Chart</div>
    @endsection

    @section("chart_content")
        Please navigate through the patient's chart using the navigation links on the left side of the screen.
    @endsection

</x-chart.chart>
