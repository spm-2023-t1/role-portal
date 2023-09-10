<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('My Skills') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your skills.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.skills.edit') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="skills" :value="__('My Skills')" />
            <select name="skills[]" id="skills" multiple>
                @foreach ($skills as $skill)
                    <option value="{{ $skill->id }}" @selected(collect(old('skills', $user->skills))->contains('id', $skill->id))>{{ $skill->name }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'skills-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
