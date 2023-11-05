<x-app-layout>
    <x-slot name="header">
        
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 my-4">
        <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
            <section>
                <header class="flex justify-between flex-col sm:flex-row border-b pb-4">
                    <div class="flex items-center">
                    <x-primary-button class="mr-2" title="Go back" onclick="goBack()">&lt;</x-primary-button>
                        <h2 class="text-lg font-medium text-gray-900">
                            <!-- {{ __('Update Staff Information') }} -->
                            Update <strong>{{ $user->fname }} {{ $user->lname }}'s</strong> Information
                        </h2>
                    </div>
                </header>
                <!-- Javascript code for back button -->
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
                <form method="post" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')
                    <div>
                        <x-input-label for="fname" :value="__('First Name')" />
                        <x-text-input id="fname" name="fname" type="text" class="mt-1 block w-full" value="{{ old('fname', $user->fname) }}" />
                        <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="lname" :value="__('Last Name')" />
                        <x-text-input id="lname" name="lname" type="text" class="mt-1 block w-full" value="{{ old('lname', $user->lname) }}" />
                        <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="skills" :value="__('User Skills')" />
                        <select name="skills[]" id="skills" multiple>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}" @selected(collect(old('skills', $user->skills))->contains('id', $skill->id))>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
