<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Listings') }}
        </h2> -->
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 my-4">
        <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
            <section>
                <header class="flex justify-between flex-col sm:flex-row border-b pb-4">
                    <div class="flex items-center">
                    <x-primary-button class="mr-2" title="Go back" onclick="goBack()">&lt;</x-primary-button>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Create New Job Listing') }}
                        </h2>
                    </div>
                </header>
                <!-- Javascript code for back button -->
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
                <form method="post" action="{{ route('jobs.store') }}" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="id" :value="__('ID')" />
                        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full" value="{{ old('id') }}" />
                        <x-input-error :messages="$errors->get('id')" class="mt-2" />
                    </div>

                    
                    <div>
                        <x-input-label for="role_name" :value="__('Name')" />
                        <x-text-input id="role_name" name="role_name" type="text" class="mt-1 block w-full" value="{{ old('role_name') }}" />
                        <x-input-error :messages="$errors->get('role_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{ old('description') }}" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="role_type" :value="__('Type')" />
                        <select name="role_type" id="role_type">
                            
                            <option value="permanent">Permanent</option>
                            <option value="temporary">Temporary</option>
                            
                        </select>
                        <x-input-error :messages="$errors->get('role_type')" class="mt-2" />
                    </div>

                    <div x-data="{ status: '' }">
                        <div>
                            <x-input-label for="listing_status" :value="__('Status')" />
                            <select name="listing_status" id="listing_status" x-model="status" value="{{ old('listing_status') }}">
                                
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                                <option value="private">Private</option>
                                
                            </select>
                            <x-input-error :messages="$errors->get('listing_status')" class="mt-2" />
                        </div>

                        <br x-show="status=='private'">

                        <div x-show="status=='private'">
                            <x-input-label for="staff_visibility" :value="__('Select Recipients')" />
                            <select name="staff_visibility[]" id="staff_visibility" multiple>
                                @foreach ($viewers as $s)
                                    <option value="{{ $s->id }}" @selected(collect(old('staff_visibility'))->contains('id', $s->id))>{{ $s->fname." ".$s->lname }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('staff_visibility')" class="mt-2" />
                        </div>
                        <div>
                        <x-input-label for="source_manager" :value="__('Source Manager')" />
                        <select name="source_manager" id="source_manager">
                            @foreach ($managers as $manager)
                            <option value="{{ $manager->id }}" @selected(collect(old('source_manager'))->contains('id', $manager->id))>{{ $manager->fname." ".$manager->lname }}</option>
                            @endforeach
                            {{-- @foreach ($hrs as $hr)
                                <option value="{{ $hr->id }}" @selected(collect(old('reporting_officer'))->contains('id', $hr->id))>{{ $hr->fname." ".$hr->lname }}</option>
                                @endforeach --}}
                            </select>
                            <x-input-error :messages="$errors->get('source_manager')" class="mt-2" />
                                
                            </div>
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

                    {{-- <div>
                        <x-input-label for="date_of_creation" :value="__('Created on')" />
                        <x-text-input id="date_of_creation" name="date_of_creation" type="datetime-local" class="mt-1 block w-full" value="{{ old('date_of_creation', now()->format('Y-m-d\TH:i')) }}" />
                        <x-input-error :messages="$errors->get('date_of_creation')" class="mt-2" />
                    </div> --}}

                    <div>
                        <x-input-label for="deadline" :value="__('Application Deadline')" />
                        <x-text-input id="deadline" name="deadline" type="datetime-local" class="mt-1 block w-full" value="{{ old('deadline') }}" />
                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                    </div>

                    <!-- while it doesn't show on the create page, the following information should be shown on the update and view page of the listing:
                        1. Name of HR staff who created the job listing - based on the profile of user logged in
                        2. Name of HR staff who last edited the job listing - based on profile of user logged in
                        3. Time of last edit
                    -->

                    <div class="flex items-center gap-4">
                        <x-primary-button id="save-button">{{ __('Save') }}</x-primary-button>
                    </div>

                    <script>
                        document.getElementById('save-button').addEventListener('click', function() {
                            const confirmation = confirm('Are you sure you want to create this job listing?');
                            if (confirmation) {
                                document.querySelector('form').submit();
                            }
                        });
                    </script>

                </form>
            </section>
        </div>
    </div>
</x-app-layout>
