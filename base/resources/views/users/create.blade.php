<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header flex items-center">Add User</div>
                <div class="card-body table table-responsive">

                <form method="POST" action="/users/add">
                    @csrf

                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="name" :value="__('Name')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="name" class="block mt-1 w-full text-sm"
                                              name="name"
                                              required
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="email" :value="__('Email')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="email" class="block mt-1 w-full text-sm"
                                              name="email"
                                              required/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="password" :value="__('Password')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="password" class="block mt-1 w-full text-sm"
                                              name="password" type="password"
                                              required autocomplete="current-password"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="role" :value="__('Role')" />
                            </td>

                            <td class="text-sm">
                                <select id="role" class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="role" required>
                                        <option value="administrator">
                                            Administrator
                                        </option>

                                        <option value="manager">
                                            Manager
                                        </option>

                                        <option value="clinician">
                                            Clinician
                                        </option>

                                        <option value="unverified" selected>
                                            Unverified
                                        </option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="relative grid grid-cols-2 flex w-auto gap-6 p-2 items-center">
                        <div class="flex justify-center">
                            <a href="/users" class="btn btn-outline-primary px-3 py-1 text-sm">Cancel</a>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="btn btn-outline-danger px-3 py-1 text-sm">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection

</x-app-layout>
