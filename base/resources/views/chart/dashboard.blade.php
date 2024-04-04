<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header grid grid-cols-2">
                    <div class="flex items-center">Patient Chart: Dashboard</div>
                </div>
                <div class="card-body table table-responsive">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session::has('message'))
                        <p class="alert">{!! Session::get('message') !!}</p>
                        @foreach($errors->all() as $error)
                            <p>{!! $error !!}</p>
                        @endforeach
                    @endif

                    {{
                        "$patient->name_last, $patient->name_first"
                        . (strlen($patient->name_middle) == 0 ? "" : " $patient->name_middle")
                        . (strlen($patient->name_preferred) == 0 ? "" : " '$patient->name_preferred'")
                    }}
                </div>
            </div>
        </div>
    @endsection

</x-app-layout>
