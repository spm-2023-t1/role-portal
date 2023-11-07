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
                            
                            <option value="permanent" @if(old('role_type') === "permanent") selected @endif>Permanent</option>
                            <option value="temporary" @if(old('role_type') === "temporary") selected @endif>Temporary</option>
                            
                        </select>
                        <x-input-error :messages="$errors->get('role_type')" class="mt-2" />
                    </div>

                    <div x-data="{ prevStatus: '{{ old('listing_status') }}', status: '' }">
                        <div>
                            <x-input-label for="listing_status" :value="__('Status')" />
                            <select name="listing_status" id="listing_status" x-model="status">
                                
                                <option value="open" x-bind:selected="prevStatus === 'open' || status === 'open'">Open</option>
                                <option value="closed" x-bind:selected="prevStatus === 'closed' || status === 'closed'">Closed</option>
                                <option value="private" x-bind:selected="prevStatus === 'private' || status === 'private'">Private</option>                                
                            </select>
                            <x-input-error :messages="$errors->get('listing_status')" class="mt-2" />
                        </div>

                        <br x-show="status=='private'|| prevStatus == 'private'">

                        <div x-show="status=='private'|| prevStatus == 'private'">
                            <x-input-label for="staff_visibility" :value="__('Select Recipients')" />
                            <select name="staff_visibility[]" id="staff_visibility" multiple>
                                @foreach ($viewers as $s)
                                    <option value="{{ $s->id }}" @if(count(collect(old('staff_visibility'))) == 0) @endif 
                                        @if(collect(old('staff_visibility'))) @foreach(collect(old('staff_visibility')) as $mvp) @if($mvp == $s->id) selected @endif @endforeach @endif> 
                                        {{ $s->fname." ".$s->lname }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('staff_visibility')" class="mt-2" />
                        </div>
                    </div>
                        
                        <div>
                            <x-input-label for="source_manager_id" :value="__('Source Manager')" />
                            <select name="source_manager_id" id="source_manager_id" value="{{ old('source_manager_id') }}">
                                @foreach ($managers as $manager)
                                <option value="{{ $manager->id }}" @if(old('source_manager_id') == '') @endif
                                @if(old('source_manager_id') != '') @if($manager->id == old('source_manager_id')) selected @endif @endif>{{ $manager->fname." ".$manager->lname }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('source_manager_id')" class="mt-2" />
                        </div>
                    <div>
                        <x-input-label for="skills" :value="__('Required Skills')"/>
                        <select name="skills[]" id="skills" multiple>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}" @if(collect(old('skills'))) @foreach(collect(old('skills')) as $lol) @if($lol == $skill->id) selected @endif @endforeach @endif>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                    </div>
                    
                    <div>
                        <x-input-label for="role_listing_open" :value="__('Role Listing Open Date')" />
                        <x-text-input id="role_listing_open" name="role_listing_open" type="datetime-local" class="mt-1 block w-full" value="{{ old('role_listing_open') }}" onchange="updateApplicationDeadline()" />
                        <x-input-error :messages="$errors->get('role_listing_open')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="deadline" :value="__('Application Deadline')" />
                        <x-text-input id="deadline" name="deadline" type="datetime-local" class="mt-1 block w-full" value="{{ old('deadline') }}" />
                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                    </div>

                    <div>
                        <!-- <x-input-label for="is_released" :value="__('Is Job Released for Viewing')" type="hidden"/> -->
                        <x-text-input id="is_released" name="is_released" class="mt-1 block w-full" value="{{ old('is_released') }}" type="hidden"/>
                        <x-input-error :messages="$errors->get('is_released')" class="mt-2" />
                    </div>

                    <script>
                        function updateApplicationDeadline() {
                            const roleListingOpenInput = document.getElementById('role_listing_open');
                            const deadlineInput = document.getElementById('deadline');
                            const is_releasedInput = document.getElementById('is_released');
                            
                            if (roleListingOpenInput.value) {
                                const roleListingOpenDate = new Date(roleListingOpenInput.value);
                                const twoWeeksLater = new Date(roleListingOpenDate);
                                twoWeeksLater.setDate(twoWeeksLater.getDate() + 14); // Add 14 days (two weeks)
                                
                                // Format the date as YYYY-MM-DDTHH:MM
                                const formattedDate = twoWeeksLater.toISOString().slice(0, 16);
                                
                                deadlineInput.value = formattedDate;
                            }

                            const currentDateTime = new Date();
    
                            if (new Date(roleListingOpenInput.value) > currentDateTime) {
                                is_releasedInput.value = "false";
                            } else {
                                is_releasedInput.value = "true";
                            }
                        }
                    </script>

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
