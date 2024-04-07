<x-app-layout>

    @section('content')
        <div class="w-100 min-h-screen min-w-screen m-0 container-fluid justify-content-center">
            <div class="row justify-content-center">
                <div class="col-12 p-0  text-sm">
                    <x-chart.header :patient="$patient"/>
                </div>
            </div>
            <div class="row min-h-screen justify-content-center">
                <div class="col-md-auto p-0 bg-white border-r border-gray-900 text-sm">
                    <x-chart.navbar :patient="$patient"/>
                </div>

                <div class="col p-0 text-sm">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex items-center">
                                @yield('chart_title')
                            </div>
                        </div>
                        <div class="card-body">
                            @yield('chart_content')
                        </div>
                    </div>
                </div>

            </div>
        </div>

    @endsection

</x-app-layout>
