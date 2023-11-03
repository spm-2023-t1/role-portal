<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Skills') }}
        </h2> -->
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

                <div class="row">
                    <div class="col-md-4">
                        <div class="col-md-8">
                        <form action="{{ route('skills.index') }}" method="GET">
                            <input type="hidden" name="search" placeholder="Search...">
                            <div class="mt-3">
                                <x-primary-button type="submit">Reset Search</x-primary-button>
                            </div>
                        </form>
                        </div>
                        <div class="col-md-8">
                            <form action="{{ route('skills.index') }}" method="GET">
                                <div>
                                <x-input-label for="search" :value="__('Search')" />
                                <input type="text" name="search" placeholder="Search..." value="{{ session('search') }}">
                                </div>
                                <div class="mt-3">
                                    <x-primary-button type="submit">Search</x-primary-button>
                                </div>
                            </form>
                                </div>

                        </div>
                        </div>



                <div class="divide-y">
                    @foreach ($skills as $skill)
                        <div class="flex py-4">
                            <div class="h-12 w-12 p-2 rounded-md border bg-gray-50 flex align-middle justify-center">
                                <svg class="w-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" fill="currentColor"></path></svg>
                            </div>
                            <div class="flex-1 ml-4">
                                <div class="text-xl text-gray-900">{{ $skill->name }}</div>
                                <div class="mt-3 text-gray-800">Created: {{ $skill->created_at }}</div>
                            </div>
                            @can('update', $skill)
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
            </section>
        </div>
    </div>
</x-app-layout>
