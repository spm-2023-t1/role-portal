<x-app-layout>
    <x-slot name="header">
        
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 my-4">
        <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
            <section>
                <header class="flex justify-between flex-col sm:flex-row border-b pb-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Manage Skills Data') }}
                        </h2>
                    </div>
                    @can('create', \App\Models\Skill::class)
                        <x-primary-button-link class="h-10 mt-4 sm:mt-0 sm:ml-2" :href="route('skills.create')">{{ __('Create New Skill') }}</x-primary-button-link>
                    @endcan
                </header>

                <div class="rounded-lg bg-gray-200 p-4 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="col-md-8">
                            <div class="text-md text-gray-900">
                                Filter Options:
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form action="{{ route('skills.index') }}" method="GET">
                                <div class="mt-3">
                                <x-input-label for="search" :value="__('Search')" />
                                <input type="text" name="search" placeholder="Search..." value="{{ session('search') }}">
                                </div>
                                <div class="mt-3">
                                    <x-primary-button type="submit">Search</x-primary-button>
                                </div>
                            </form>
                            <form action="{{ route('skills.index') }}" method="GET">
                            <input type="hidden" name="search" placeholder="Search...">
                            <div class="mt-3">
                                <x-primary-button type="submit">Reset Search</x-primary-button>
                            </div>
                        </form>
                                </div>

                        </div>
                        </div>
                        </div>



                @if($skills->isEmpty())
                <p class="text-red-600 mt-3">No skills found.</p>
                    @else
                        <div class="divide-y">
                            @foreach ($skills as $skill)
                                <div class="flex py-4">
                                    <div class="h-12 w-12 p-2 rounded-md border bg-gray-50 flex align-middle justify-center">
                                        {{-- <svg class="w-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" fill="currentColor"></path></svg> --> --}}
                                        <svg class="w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" /></svg>
                                    </div>
                                    <div class="flex-1 ml-4">
                                        <div class="text-xl text-gray-900">{{ $skill->name }}</div>
                                        <div class="mt-3 text-gray-800">Created At: {{ $skill->created_at }}</div>
                                        <div class="mt-0 text-gray-800">Created By: {{ $skill->created_by }}</div>
                                        <div class="mt-0 text-gray-800">Updated By: {{ $skill->updated_by }}</div>

                                    </div>
                                    @can('delete', $skill)
                                        <div class="mt-3">
                                        <form method="POST" action="{{ route('skills.destroy', $skill) }}" onsubmit="return confirm('Are you sure you want to delete this skill?')">
                                            @csrf
                                            @method('DELETE')
                                            <x-primary-button type="submit" class="btn btn-danger">Delete</x-primary-button>
                                        </form>
                                    </div>
                                        @endcan
                                        &nbsp;
                                    @can('update', $skill)
                                        <div class="mt-3">
                                            <a href="{{ route('skills.edit', $skill) }}">
                                            <x-primary-button>Edit</x-primary-button>
                                            </a>
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
