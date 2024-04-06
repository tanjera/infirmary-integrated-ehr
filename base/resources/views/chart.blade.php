<x-app-layout>

    @section('content')

        <div class="w-100 min-h-screen min-w-screen m-0 container-fluid justify-content-center">
            <div class="row justify-content-center">
                <div class="col-12 p-0  text-sm">
                    <x-chart.header :patient="$patient"/>
                </div>
            </div>
            <div class="row min-h-screen justify-content-center">
                <div class="col-1 p-0  text-sm">
                    <x-chart.navbar/>
                </div>
                <div class="col">
                    <div class="card my-3 text-sm">

                        <div class="card-header grid grid-cols-2">
                            <div class="flex items-center">Content Area</div>
                        </div>
                        <div class="card-body">
                            Include switch for navigated content here (e.g. dashboard, orders, MAR, etc.)
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

</x-app-layout>
