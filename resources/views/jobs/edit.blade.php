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
                            <!-- {{ __('Update Job Listing') }} -->
                            Edit <strong>{{ $job->role_name }}</strong> Role Listing
                        </h2>
                    </div>
                </header>
                <!-- Javascript code for back button -->
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>

                <form method="post" action="{{ route('jobs.update', $job) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')
                    <div>
                        <x-input-label for="id" :value="__('ID')" />
                        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full" value="{{ old('id', $job->id) }}" />
                        <x-input-error :messages="$errors->get('id')" class="mt-2" />
                    </div>
                    
                    <div>
                        <x-text-input type="hidden" id="updated_by" name="updated_by" class="mt-1 block w-full" value="{{ Auth::user()->id }}"/>
                    </div>
                    
                    <div>
                        <x-input-label for="role_name" :value="__('Name')" />
                        <x-text-input id="role_name" name="role_name" type="text" class="mt-1 block w-full" value="{{ old('role_name', $job->role_name) }}" />
                        <x-input-error :messages="$errors->get('role_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{ old('description', $job->description) }}" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="role_type" :value="__('Type')" />
                        <select name="role_type" id="role_type">
                            
                            <!-- <option value="permanent" value="{{ old('role_type', $job->role_type) }}">Permanent</option> -->
                            <option value="permanent" @if(old('role_type') == 'permanent') selected @endif @if($job->role_type == 'permanent') selected @endif>Permanent</option>
                            <option value="temporary" @if(old('role_type') == 'temporary') selected @endif @if($job->role_type == 'temporary') selected @endif>Temporary</option>
                            
                        </select>
                        <x-input-error :messages="$errors->get('role_type')" class="mt-2" />
                    </div>

                    <!-- <div x-data="{ status: '' }"> -->
                    <div x-data="{ prevStatus: '{{ old('listing_status') }}', status: '{{ $job->listing_status ?: '' }}' }">
                        <!-- <div text=""></div> -->
                        <div>
                            <x-input-label for="listing_status" :value="__('Status')" />
                            <select name="listing_status" id="listing_status" x-model="status">
                                
                                <!-- <option value="open" x-bind:selected="status==='open'">Open</option>
                                <option value="closed" x-bind:selected="status==='closed'">Closed</option>
                                <option value="private" x-bind:selected="status==='private'">Private</option> -->

                                <option value="open" x-bind:selected="prevStatus === 'open' || status === 'open'">Open</option>
                                <option value="closed" x-bind:selected="prevStatus === 'closed' || status === 'closed'">Closed</option>
                                <option value="private" x-bind:selected="prevStatus === 'private' || status === 'private' || $job->listing_status == 'private'">Private</option>
                            </select>
                            <x-input-error :messages="$errors->get('listing_status')" class="mt-2" />
                        </div>

                        <!-- <div>{{ $job->viewers }}</div> -->

                        <br x-show="status=='private' || prevStatus == 'private'">    

                        <div x-show="status=='private' || prevStatus == 'private'">
                            <x-input-label for="staff_visibility" :value="__('Select Recipients')" />
                            <select name="staff_visibility[]" id="staff_visibility" multiple>
                                @foreach ($viewers as $s)
                                    <!-- <option value="{{ $s->id }}" @selected(collect(old('staff_visibility'))->contains('id', $s->id))>{{ $s->fname." ".$s->lname }}</option> -->
                                    <!-- <option value="{{ $s->id }}" @foreach ($job->viewers as $st) @if($s->id === $st->id) selected @endif @endforeach> -->
                                    <!-- <option value="{{ $s->id }}" @if(collect(old('staff_visibility')) != []) @if(collect(old('staff_visibility'))->contains($s->id)) selected @endif @else @foreach($job->viewers as $st) @if($s->id == $st->id) selected @endif @endforeach @endif> -->
                                        <option value="{{ $s->id }}" 
                                        @if(count(collect(old('staff_visibility'))) == 0 and count(collect($job->viewers)) == 0) @endif 
                                        @if(count(collect(old('staff_visibility'))) > 0 and count(collect($job->viewers)) == 0) @foreach(collect(old('staff_visibility')) as $mvp) @if($mvp == $s->id) selected @endif @endforeach @endif 
                                        @if(count(collect(old('staff_visibility'))) == 0 and count(collect($job->viewers)) > 0) @foreach($job->viewers as $pvm) @if($pvm->id == $s->id) selected @endif @endforeach @endif
                                        @if(count(collect(old('staff_visibility'))) > 0 and count(collect($job->viewers)) > 0) @foreach(collect(old('staff_visibility')) as $stuff) @if($stuff == $s->id) selected @endif @endforeach @endif>
                                        {{ $s->fname." ".$s->lname }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('staff_visibility')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="source_manager_id" :value="__('Source Manager')" />
                        <select name="source_manager_id" id="source_manager_id" value="{{ old('source_manager_id') }}">
                            @foreach ($managers as $manager)
                            <!-- <option value="{{ $manager->id }}" @selected(collect(old('source_manager_id'))->contains('id', $manager->id))>{{ $manager->fname." ".$manager->lname }}</option> -->
                            <!-- <option value="{{ $manager->id }}" @if(old('source_manager_id') == $manager->id || $job->source_manager_id == $manager->id) selected @endif>{{ $manager->fname." ".$manager->lname }}</option> -->
                            <option value="{{ $manager->id }}" @if(old('source_manager_id') == '') @if($job->source_manager_id == $manager->id) selected @endif @endif
                                @if(old('source_manager_id') != '') @if($manager->id == old('source_manager_id')) selected @endif @endif>
                                {{ $manager->fname." ".$manager->lname }}
                            </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('source_manager_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="skills" :value="__('Required Skills')" />
                        <select name="skills[]" id="skills" multiple>
                            @foreach ($skills as $skill)
                                <!-- <option value="{{ $skill->id }}" @selected(collect(old('skills', $job->skills))->contains('id', $skill->id))>{{ $skill->name }}</option> -->
                                <option value="{{ $skill->id }}" @foreach($job->skills as $sk) @if($skill->id == $sk->id) selected @endif @endforeach>{{ $skill->name }}</option>
                                
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
                        <x-input-label for="role_listing_open" :value="__('Role Listing Open Date')" />
                        <x-text-input id="role_listing_open" name="role_listing_open" type="datetime-local" class="mt-1 block w-full" value="{{ old('role_listing_open', $job->role_listing_open) }}" onchange="changeRoleListingOpen('{{$job->created_at}}')"/>
                        <x-input-error :messages="$errors->get('role_listing_open')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="deadline" :value="__('Application Deadline')" />
                        <x-text-input id="deadline" name="deadline" type="datetime-local" class="mt-1 block w-full" value="{{ old('deadline', $job->deadline) }}" />
                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="is_released" :value="__('Is Job Released for Viewing')"/>
                        <x-text-input id="is_released" name="is_released" class="mt-1 block w-full" value="{{ old('is_released', $job->is_released) }}"/>
                        <x-input-error :messages="$errors->get('is_released')" class="mt-2" />
                    </div>

                    <script>
                        function changeRoleListingOpen(created_on) {
                            const role_listing_open_elem = document.getElementById('role_listing_open')
                            const is_release_elem = document.getElementById('is_released')
                            const now_date = new Date();

                            // if role_listing_open > now() --> then false else true

                            if(new Date(role_listing_open_elem.value) > now_date) {
                                is_release_elem.value = "false";
                            }

                            else{
                                is_release_elem.value = "true";
                            }
                        }
                    </script>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
