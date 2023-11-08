@php
    use App\Enums\UserRole;
@endphp

<x-app-layout>
    <x-slot name="header">
        
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 my-4">
        <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
            <section>
                <header class="flex justify-between flex-col sm:flex-row border-b pb-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Manage Staff Data') }}
                        </h2>
                    </div>
                   
                </header>

                <div class="row">
                    <div class="rounded-lg bg-gray-200 p-4 mb-4">
                    <div class="col-md-4">
                        <div class="col-md-8">
                            <div class="text-md text-gray-900">
                                Filter Options:
                            </div>
                            <div class="form-container">
                    </div>
                        </div>
                
                    <div class="col-md-8">
                        <form action="{{ route('users.index') }}" method="GET">
                            <div class="form-container">
                            <div class="mt-3">
                            <x-input-label for="search" :value="__('Search')" />
                            <input type="text" name="search" placeholder="Search..." value="{{ session('search') }}">
                            </div>
                        </div>
                            
                        <div class="form-container">
                            @if(Auth::user()->role === UserRole::HumanResource)
                                <div>
                                <x-input-label for="filter_role" :value="__('Filter Role')" />
                                <select name="filter_role[]" multiple>
                                    <option value="HR" {{ in_array('HR', session('filter_role', [])) ? 'selected' : '' }}>HR</option>
                                    <option value="Manager" {{ in_array('Manager', session('filter_role', [])) ? 'selected' : '' }}>Manager</option>
                                    <option value="Staff" {{ in_array('Staff', session('filter_role', [])) ? 'selected' : '' }}>Staff</option>
                                    <!-- Add other filter options as needed -->
                                </select>
                                </div>
                            @endif

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
                        <form action="{{ route('users.index') }}" method="GET">
                            <input type="hidden" name="search" placeholder="Search...">
                            <div class="mt-3">
                                <x-primary-button type="submit">Reset Search</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
                </div>



                @if($users->isEmpty())
                <p class="text-red-600 mt-3">No staff found.</p>
                @else
                <div class="divide-y">
                    @foreach ($users as $user)
                        <div class="flex py-4">
                            <div class="h-12 w-12 p-2 rounded-md border bg-gray-50 flex align-middle justify-center">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                            </div>
                            <div class="flex-1 ml-4">
                                <div class="text-xl text-gray-900">{{ $user->fname }} {{ $user->lname }}</div>
                                <!-- Only HR can see all the extra information as per US8 -->
                                @if(Auth::user()->role === UserRole::HumanResource)
                                <div class="mt-1 text-gray-800">Department: {{ $user->dept }}</div>
                                <div class="mt-1 text-gray-800">Role: {{ $user->role }}</div>
                                <div class="mt-1 text-gray-800">Business Address: {{ $user->biz_address }}</div>
                                <div class="mt-1 text-gray-800">Phone: {{ $user->phone_num }}</div>
                                @endif
                                <div class="mt-1 text-gray-800">Email: {{ $user->email }}</div>
                                <div class="mt-1 text-gray-800">Skills:</div>
                                
                                <div class="mt-1 flex">
                                    @foreach($user->skills as $skill)
                                        
                                        <div class="bg-gray-300 rounded mx-1 px-1">{{$skill->name}}</div>
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
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
