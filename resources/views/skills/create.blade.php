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
                    <div class="flex items-center">
                    <x-primary-button class="mr-2" title="Go back" onclick="goBack()">&lt;</x-primary-button>    
                    <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Create New Skill') }}
                        </h2>
                    </div>
                </header>
                <!-- Javascript code for back button -->
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
                <form method="post" action="{{ route('skills.store') }}" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Name of skill')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
