<x-chart.chart :patient="$patient">

    @section("chart_title")
        <div class="grid grid-cols-2">
            <div class="flex items-center">Create a Note</div>
        </div>
    @endsection

    @section("chart_content")
            <form method="POST" action="/chart/notes/create/{{$patient->id}}" enctype="multipart/form-data">
                @csrf

                <table class="table">
                    <tbody>
                    <tr>
                        <td class="text-sm align-content-center">
                            <x-input-label for="category" :value="__('Category')" />
                        </td>

                        <td class="text-sm">
                            <select id="category" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    name="category" required>
                                @foreach(\App\Models\Note::$category_index as $category)
                                    <option value="{{ $category }}" {{ $category == "progress" ? "selected" : ""}}>
                                        {{ \App\Models\Note::$category_text[array_search($category, \App\Models\Note::$category_index)] }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-sm align-content-center">
                            <x-input-label for="body" :value="__('Note')" />
                        </td>

                        <td class="text-sm">
                            <textarea id="body" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      rows="16"
                                      name="body"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-sm align-content-center">
                            <label for="body" class="block font-medium text-sm text-gray-700">Attachments</label>
                        </td>

                        <td class="text-sm">
                            <input type="file" multiple name="attachments[]">

                            <p style="color: darkgoldenrod" class="py-2">
                                Note: Large file sizes (> 10 mb) may not be supported and/or may return an error.
                            </p>
                        </td>
                    </tr>

                    </tbody>
                </table>

                <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                    <div class="flex justify-center">
                        <a href="/chart/notes/{{$patient->id}}" class="btn btn-outline-primary px-3 py-1 text-sm">Cancel</a>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="btn btn-outline-danger px-3 py-1 text-sm">Save</button>
                    </div>
                </div>
            </form>
    @endsection

</x-chart.chart>
