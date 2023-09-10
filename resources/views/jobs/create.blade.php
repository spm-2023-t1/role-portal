<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Listings') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 my-4">
        <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
            <section>
                <header class="flex justify-between flex-col sm:flex-row border-b pb-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Create New Job') }}
                        </h2>
                    </div>
                </header>
                <form method="post" action="{{ route('jobs.store') }}" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{ old('description') }}" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="deadline" :value="__('Deadline')" />
                        <x-text-input id="deadline" name="deadline" type="datetime-local" class="mt-1 block w-full" value="{{ old('deadline') }}" />
                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="skills" :value="__('Required Skills')" />
                        <select name="skills[]" id="skills" multiple>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}" @selected(collect(old('skills'))->contains('id', $skill->id))>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
