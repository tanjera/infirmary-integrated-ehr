<x-app-layout>

    @section('content')
        <div class="container p-2">
            <div class="card">
                <div class="card-header">Edit User</div>
                <div class="card-body table table-responsive">

                <form method="POST" action="/users/edit/{{$user->id}}">
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
                                value="{{$user->name}}"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="email" :value="__('Email')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="email" class="block mt-1 w-full text-sm"
                                              name="email"
                                              required
                                              value="{{$user->email}}"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="password" :value="__('Password')" />
                            </td>

                            <td class="text-sm">
                                <x-text-input id="password" class="block mt-1 w-full text-sm"
                                              name="password" type="password"
                                              required autocomplete="current-password"
                                              value="{{$user->password}}"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-sm align-content-center">
                                <x-input-label for="role" :value="__('Role')" />
                            </td>

                            <td class="text-sm">
                                <select id="role" class="block mt-1 w-full text-sm rounded-2" name="role" required>
                                        <option value="administrator" {{$user->role == 'administrator' ? "selected" : ""}}>
                                            Administrator
                                        </option>

                                        <option value="manager" {{$user->role == 'manager' ? "selected" : ""}}>
                                            Manager
                                        </option>

                                        <option value="clinician" {{$user->role == 'clinician' ? "selected" : ""}}>
                                            Clinician
                                        </option>

                                        <option value="unverified" {{$user->role == 'unverified' ? "selected" : ""}}>
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
