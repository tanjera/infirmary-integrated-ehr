<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Add Allergy</div>
        </div>
    @endsection

    @section("chart_content")

            <form method="POST" action="/chart/allergies/add/{{$patient->id}}">
                @csrf

                <table class="table">
                    <tbody>
                    <tr>
                        <td class="text-sm align-content-center">
                            <x-input-label for="allergen" :value="__('Allergen')" />
                        </td>

                        <td class="text-sm">
                            <x-text-input id="allergen" class="block mt-1 w-full text-sm"
                                          name="allergen"
                                          required
                            />
                        </td>
                    </tr>

                    <tr>
                        <td class="text-sm align-content-center">
                            <x-input-label for="reaction" :value="__('Reaction')" />
                        </td>

                        <td class="text-sm">
                            <x-text-input id="reaction" class="block mt-1 w-full text-sm"
                                          name="reaction"
                                          required/>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-sm align-content-center">
                            <x-input-label for="severity" :value="__('Severity')" />
                        </td>

                        <td class="text-sm">
                            <select id="severity" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    name="severity" required>
                                @foreach(\App\Models\Chart\Allergy::$severity_index as $severity)
                                    <option value="{{ $severity }}" {{ $severity == "mild" ? "selected" : ""}}>
                                        {{ ucfirst($severity) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-sm align-content-center">
                            <x-input-label for="notes" :value="__('Notes')" />
                        </td>

                        <td class="text-sm">
                            <x-text-input id="notes" class="block mt-1 w-full text-sm"
                                          name="notes"/>
                        </td>
                    </tr>

                    </tbody>
                </table>

                <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                    <div class="flex justify-center">
                        <a href="/chart/allergies/{{$patient->id}}" class="btn btn-outline-primary px-3 py-1 text-sm">Cancel</a>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="btn btn-outline-danger px-3 py-1 text-sm">Save</button>
                    </div>
                </div>
            </form>

    @endsection

</x-chart.chart>
