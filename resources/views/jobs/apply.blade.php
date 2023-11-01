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
                            {{ __('Apply for Job') }}
                        </h2>
                    </div>
                </header>
                <form method="post" action="{{ route('jobs.apply', $job) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')
                    
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
                            
                            <option value="permanent">Permanent</option>
                            <option value="temporary">Temporary</option>
                            
                        </select>
                        <x-input-error :messages="$errors->get('role_type')" class="mt-2" />
                    </div>

                    <div x-data="{ status: '' }">
                        <div>
                            <x-input-label for="listing_status" :value="__('Status')" />
                            <select name="listing_status" id="listing_status" x-model="status">
                                
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
                    </div>

                    <div>
                        <x-input-label for="skills" :value="__('Required Skills')" />
                        <select name="skills[]" id="skills" multiple>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}" @selected(collect(old('skills', $job->skills))->contains('id', $skill->id))>{{ $skill->name }}</option>
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
                        <x-text-input id="deadline" name="deadline" type="datetime-local" class="mt-1 block w-full" value="{{ old('deadline', $job->deadline) }}" />
                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
