<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 my-4">
        <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
            <section>
                <header class="flex justify-between flex-col sm:flex-row border-b pb-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Staff') }}
                        </h2>
                    </div>
                    {{-- @can('create', \App\Models\Job::class)
                        <x-primary-button-link class="h-10 mt-4 sm:mt-0 sm:ml-2" :href="route('jobs.create')">{{ __('Create New Job') }}</x-primary-button-link>
                    @endcan --}}
                </header>

                <div class="row">
                    <div class="col-md-4">
                        <div class="col-md-8">
                            <div class="form-container">
                        <form action="{{ route('users.index') }}" method="GET">
                            <input type="hidden" name="search" placeholder="Search...">
                            <div class="mt-3">
                                <x-primary-button type="submit">Reset Search</x-primary-button>
                            </div>
                        </form>
                    </div>
                        </div>
                
                    <div class="col-md-8">
                        <form action="{{ route('users.index') }}" method="GET">
                            <div class="form-container">
                            <div>
                            <x-input-label for="search" :value="__('Search')" />
                            <input type="text" name="search" placeholder="Search..." value="{{ session('search') }}">
                            </div>
                        </div>
                            
                        <div class="form-container">
                            <div>
                            <x-input-label for="filter_role" :value="__('Filter Role')" />
                            <select name="filter_role[]" multiple>
                                <option value="HR" {{ in_array('HR', session('filter_role', [])) ? 'selected' : '' }}>HR</option>
                                <option value="Manager" {{ in_array('Manager', session('filter_role', [])) ? 'selected' : '' }}>Manager</option>
                                <option value="Staff" {{ in_array('Staff', session('filter_role', [])) ? 'selected' : '' }}>Staff</option>
                                <!-- Add other filter options as needed -->
                            </select>
                            </div>

                            &nbsp;
                            &nbsp;

                        <div>
                            <x-input-label for="filter_skill" :value="__('Filter Skills')" />
                            <select name="filter_skill[]" multiple>
                                @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}"
                                    {{ in_array( $skill->id, session('filter_skill', [])) ? 'selected' : '' }}
                                    @selected(collect(old('skills'))->contains('id', $skill->id))
                                    >{{ $skill->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                            <div class="mt-3">
                                <x-primary-button type="submit">Search & Filter</x-primary-button>
                            </div> 
                        </form>
                    </div>
                </div>



                <div class="divide-y">
                    @foreach ($users as $user)
                        <div class="flex py-4">
                            <div class="h-12 w-12 p-2 rounded-md border bg-gray-50 flex align-middle justify-center">
                                <svg class="w-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" fill="currentColor"></path></svg>
                            </div>
                            <div class="flex-1 ml-4">
                                <div class="text-xl text-gray-900">{{ $user->fname }} {{ $user->lname }}</div>
                                <div class="mt-1 text-gray-800">Department: {{ $user->dept }}</div>
                                <div class="mt-1 text-gray-800">Email: {{ $user->email }}</div>
                                <div class="mt-1 text-gray-800">Role: {{ $user->role }}</div>
                                <div class="mt-1 text-gray-800">Phone: {{ $user->phone_num }}</div>
                                <div class="mt-1 text-gray-800">Business Address: {{ $user->biz_address }}</div>
                                <div class="mt-1 text-gray-800">Skills:</div>
                                
                                <div class="mt-1 flex">
                                    @foreach($user->skills as $skill)
                                        @if(collect(Auth::user()->skills)->contains('id', $skill->id))
                                            <div class="bg-green-300 rounded mx-1 px-1">
                                                {{ $skill->name }}
                                            </div>
                                        @else
                                            <div class="bg-red-300 rounded mx-1 px-1">
                                                {{ $skill->name }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @can('update', $user)
                                <div class="mt-3">
                                    <a href="{{ route('users.edit', $user) }}">
                                    <x-primary-button>Edit</x-primary-button>
                                    </a>
                                    <div> 
                                        &nbsp;
                                    </div>
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button type="submit" class="btn btn-danger">Delete</x-primary-button>
                                    </form>
                                </div>
                                @endcan
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
