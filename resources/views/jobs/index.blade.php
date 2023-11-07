@php
    use App\Enums\JobStatus;
    use App\Enums\UserRole;
@endphp

<x-app-layout>
    <x-slot name="header">
       
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 my-4">
        <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
            <section>
                <header class="flex justify-between flex-col sm:flex-row border-b pb-4">
                    <div class="flex items-center">
                    <!-- <x-primary-button class="mr-2" title="Go back" onclick="goBack()">&lt;</x-primary-button> -->
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('View All Job Listings') }}
                        </h2>
                    </div>
                
                    @can('create', \App\Models\Job::class)
                    <x-primary-button-link class="h-10 mt-4 sm:mt-0 sm:ml-2" :href="route('jobs.create')">{{ __('Create New Job Listing') }}</x-primary-button-link>
                    @endcan
                </header>

                <div class="rounded-lg bg-gray-200 p-4 mb-4">
                <div class="col">
                <div class="col">
                    <div class="text-md text-gray-900">
                        Filter Options:
                    </div>
                        <form action="{{ route('jobs.index') }}" method="GET">
                            <div class="form-container mt-3">
                                <div>
                                    <x-input-label for="search" :value="__('Search Role Listing')" />
                                    <input type="text" name="search" placeholder="Search..." value="{{ session('search') }}">
                                </div>
                            </div>
                            
                            <div class="form-container mt-3 flex-start">
                                <div class="w-full" style="width: 15%; margin-right: 10px;">
                                    <x-input-label for="filter_listing_type" :value="__('Filter Role Type')" />
                                    <select name="filter_role_type[]" multiple>
                                        <option value="Permanent" {{ in_array('Permanent', session('filter_role_type', [])) ? 'selected' : '' }}>Permanent</option>
                                        <option value="Temporary" {{ in_array('Temporary', session('filter_role_type', [])) ? 'selected' : '' }}>Temporary</option>
                                    </select>
                                </div>
                                <div class="w-full" style="width: 30%; margin-right: 10px;">
                                    <x-input-label for="filter_skill" :value="__('Filter Skills')" />
                                    <select name="filter_skill[]" multiple>
                                        @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}"
                                            {{ in_array($skill->id, session('filter_skill', [])) ? 'selected' : '' }}
                                            @selected(collect(old('skills'))->contains('id', $skill->id))
                                            >{{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full">
                                    <x-input-label for="filter_listing_status" :value="__('Filter Job Status')" />
                                    <select name="filter_listing_status[]" multiple>
                                        <option value="open" {{ in_array('Open', session('filter_listing_status', [])) ? 'selected' : '' }}>Open</option>
                                        <option value="private" {{ in_array('Private', session('filter_listing_status', [])) ? 'selected' : '' }}>Private</option>
                                        <option value="closed" {{ in_array('Closed', session('filter_listing_status', [])) ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class=" flex-1 mt-3">
                                <x-input-label for="start_date" :value="__('Deadline Start Date')" />
                                <x-text-input id="start_date" name="start_date" type="datetime-local" class="mt-1 block w-full" value="{{ session('start_date') }}" />
                                </div>
                                <div class="flex-1 mt-3">
                                <x-input-label for="end_date" :value="__('Deadline End Date')" />
                                <x-text-input id="end_date" name="end_date" type="datetime-local" class="mt-1 block w-full" value="{{ session('end_date') }}" />
                                </div>
                            </div>

                            <div class="mt-3">
                                <x-primary-button type="submit">Search & Filter</x-primary-button>
                            </div>
                        </form>

                        <div class="form-container">
                            <form action="{{ route('jobs.index') }}" method="GET">
                                <input type="hidden" name="search" placeholder="Search...">
                                <div class="mt-3">
                                    <x-primary-button type="submit">Reset Search</x-primary-button>
                                </div>
                            </form>
                        </div>
                    
                </div>
                </div>
                </div>

                <div>
                    @if (session()->has('message'))
                    <div class="alert alert-warning alert-block">
                        {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                        <strong>
                            {{ session('message') }}
                        </strong>
                    </div>
                    @endif
                </div>

                <div>
                    @if ($jobs->isEmpty())
                    <p class="text-red-600 mt-3">No job listings found.</p>
                    @else
                    <div class="divide-y">
                        @foreach ($jobs as $job)
                        <!-- conditions: HR sees all, Staff only sees open and private, Managers sees open, private, and those they are source_managers of-->
                        @can('viewJobs', $job)
                            <div class="flex py-4">
                                <div class="h-12 w-12 p-2 rounded-md border bg-gray-50 flex align-middle justify-center">
                                    <svg class="w-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" fill="currentColor"></path></svg>
                                </div>
                                <div class="flex-1 ml-4">
                                    <div class="text-xl text-gray-900">{{ $job->role_name }}</div>
                                    <div class="mt-1 text-gray-800">{{ $job->description }}</div>
                                    <div class="mt-1 text-gray-800"><strong>Application deadline:</strong> {{ $job->deadline }}</div>
                                    <div class="mt-1 text-gray-800"><strong>Role Listing Open Date:</strong> {{ $job->role_listing_open }}</div>
                                    <div class="mt-1 text-gray-800"><strong>Source Manager:</strong> {{ $job->source_manager->fname }} {{ $job->source_manager->lname }}</div>
                                    <div class="mt-1 text-gray-800"><strong>Job Status:</strong> {{ ucfirst($job->listing_status) }}</div>
                                    <div class="mt-1 text-gray-800"><strong>Skills required:</strong></div>
                                    <div class="mt-1 flex">
                                        @foreach($job->skills as $skill)
                                            @if(collect(Auth::user()->skills)->contains('id', $skill->id))
                                                <div class="bg-green-300 rounded mx-1 px-1">
                                                    {{ $skill->name }}
                                                </div>
                                            @else
                                                <div class="bg-red-300 rounded mx-1 px-1">
                                                    {{ $skill->name }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="mt-1 text-gray-800"><strong>Total applicants:</strong> {{ count($job->applicants) }}</div>
                                    <div class="mt-3">
                                        <x-primary-button onclick="openJobDetailsModal({{ $job->id }})">Show All Details</x-primary-button>
                                    </div>
                                    <div id="job-details-modal-{{ $job->id }}" class="fixed inset-0 z-10 hidden overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen p-4">
                                            <!-- Modal background -->
                                            <div class="fixed inset-0 bg-black opacity-50"></div>
                                            <!-- Modal content -->
                                            <div class="bg-white p-8 rounded-lg shadow-lg relative">
                                                <button class="absolute top-0 right-0 p-4" onclick="closeJobDetailsModal({{ $job->id }})">Close</button>
                                                <h2 class="text-lg font-medium text-gray-900">{{ $job->role_name }}</h2>
                                                <p class="mt-2 text-gray-800"><strong>ID:</strong> {{ $job->id }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Name:</strong> {{ $job->role_name }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Description:</strong> {{ $job->description }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Type:</strong> {{ ucfirst($job->role_type) }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Status:</strong> {{ ucfirst($job->listing_status) }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Created on:</strong> {{ $job->created_at }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Created by:</strong> {{ $job->owner->fname ?? 'UNKNOWN' }} {{ $job->owner->lname ?? 'UNKNOWN' }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Email of Creator:</strong> {{ $job->owner->email }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Application deadline:</strong> {{ $job->deadline }}</p>
                                                @can('viewRoleListingOpen', \App\Models\Job::class)
                                                <p class="mt-2 text-gray-800"><strong>Role Listing Open Date:</strong> {{ $job->role_listing_open }}</p>
                                                @endcan
                                                @if ($job->updated_at != $job->created_at)
                                                    <p class="mt-2 text-gray-800"><strong>Updated by:</strong> {{ $job->updater->fname }} {{ $job->updater->lname ?? 'UNKNOWN' }}</p>
                                                    <p class="mt-2 text-gray-800"><strong>Time of last edit:</strong> {{ $job->updated_at }}</p>
                                                @endif
                                                <p class="mt-2 text-gray-800"><strong>Total applicants:</strong> {{ count($job->applicants) }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Source Manager:</strong> {{ $job->source_manager->fname }} {{ $job->source_manager->lname }}</p>
                                                <p class="mt-2 text-gray-800"><strong>Source Manager Email:</strong> {{ $job->source_manager->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        // JavaScript function to open the modal
                                        function openJobDetailsModal(jobId) {
                                            const modalElement = document.getElementById(`job-details-modal-${jobId}`);
                                            if (modalElement) {
                                                modalElement.classList.remove('hidden');
                                            }
                                        }
                                        // JavaScript function to close the modal
                                        function closeJobDetailsModal(jobId) {
                                            const modalElement = document.getElementById(`job-details-modal-${jobId}`);
                                            if (modalElement) {
                                                modalElement.classList.add('hidden');
                                            }
                                        }
                                    </script>

                                    @if($job->listing_status == 'open' || $job->listing_status == 'private')
                                    <div class="mt-3">
                                        @if(collect(Auth::user()->applications)->contains('id', $job->id))
                                            <div class="text-green-600">Applied successfully.</div>
                                        @else
                                            <!-- <form method="post" action="{{ route('jobs.apply', $job) }}"> -->
                                                <!-- @csrf
                                                @method('patch') -->
                                                <!-- <x-primary-button onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Apply for this job') }}</x-primary-button> -->
                                                <!-- Button to Trigger Application Modal -->
                                                <div class="mt-3">
                                                    <x-primary-button onclick="openApplicationModal({{ $job->id }})">
                                                        Apply for this job
                                                    </x-primary-button>
                                                </div>
                                            <!-- </form> -->
                                        @endif
                                    </div>
                                    @endif

                                    <!-- Application Modal -->
                                    <div id="job-application-modal-{{ $job->id }}" class="fixed inset-0 z-10 hidden overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen p-4">
                                            <!-- Modal background -->
                                            <div class="fixed inset-0 bg-black opacity-50"></div>
                                            <!-- Modal content -->
                                            <div class="bg-white p-8 rounded-lg shadow-lg relative max-w-screen-lg w-full">
                                                <button class="absolute top-0 right-0 p-4" onclick="closeApplicationModal({{ $job->id }})">Close</button>
                                                <form action="{{ route('jobs.apply', ['job' => $job->id]) }}" method="POST">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="_method" value="PATCH"> 
                                                <div>
                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            {{ __('Application Form') }}
                                                        </h2>
                                                    </div>
                                                    <div>
                                                        First Name: {{ Auth::user()->fname}}
                                                    </div>
                                                    <div>
                                                        Last Name: {{ Auth::user()->lname}}
                                                    </div>
                                                    <div>
                                                        Department: {{ Auth::user()->dept}}
                                                    </div>
                                                    <div>
                                                        Email: {{ Auth::user()->email}}
                                                    </div>
                                                    <div>
                                                        Phone Number: {{ Auth::user()->phone_num}}
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-input-label for="start_date" :value="__('Start Date')" />
                                                        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ old('start_date', now()->format('Y-m-d')) }}" />
                                                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <x-input-label for="additional_remarks" :value="__('Additional Remarks')" />
                                                        <x-text-input id="additional_remarks" name="additional_remarks" type="text" class="mt-1 block w-full" value="{{ old('additional_remarks') }}" />
                                                        <x-input-error :messages="$errors->get('additional_remarks')" class="mt-2" />
                                                    </div>
                                                    <!-- <div class="mt-3">
                                                    <x-text-input id="job_id" name="job_id" type="hidden" class="mt-1 block w-full" value="{{ $job->id }}" />
                                                    </div>
                                                    <div class="mt-3">
                                                    <x-text-input id="user_id" name="user_id" type="hidden" class="mt-1 block w-full" value="{{ Auth::user()->id }}" />
                                                    </div> -->
                                                    <div class="mt-3">
                                                    <x-text-input id="role_app_status" name="role_app_status" type="hidden" class="mt-1 block w-full" value="applied" />
                                                    </div>
                                                    <!-- <x-primary-button class="mt-3" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Submit Application Form') }}</x-primary-button> -->
                                                    <x-primary-button class="mt-3">{{ __('Submit Application Form') }}</x-primary-button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        // JavaScript function to open the modal
                                        function openApplicationModal(jobId) {
                                            console.log("test");
                                            const modalElement = document.getElementById(`job-application-modal-${jobId}`);
                                            if (modalElement) {
                                                modalElement.classList.remove('hidden');
                                            }
                                        }
                                        // JavaScript function to close the modal
                                        function closeApplicationModal(jobId) {
                                            const modalElement = document.getElementById(`job-application-modal-${jobId}`);
                                            if (modalElement) {
                                                modalElement.classList.add('hidden');
                                            }
                                        }
                                    </script>
                                    
                                    @can('viewApplicationHR', $job)
                                    <div class="mt-3">
                                        <a href="{{ route('jobs.show', $job) }}">
                                        <x-primary-button>Show All Applicants</x-primary-button>
                                        </a>
                                    </div>
                                    @endcan
                                    
                                    @can('viewApplicationManager', $job)
                                    @if (Auth::user()->id === $job->source_manager)
                                        
                                    <div class="mt-3">
                                        <a href="{{ route('jobs.show', $job) }}">
                                        <x-primary-button>Show All Applicants</x-primary-button>
                                        </a>
                                    </div>
                                    @endif
                                    @endcan

                                    @can('update', $job)
                                    <div class="mt-3">
                                    <form method="POST" action="{{ route('jobs.destroy', $job) }}" onsubmit="return confirm('Are you sure you want to delete this job?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button type="submit" class="btn btn-danger">Delete</x-primary-button>
                                    </form>
                                </div>
                                    @endcan
                                </div>
                                @can('update', $job)
                                    <div class="mt-3">
                                        <a href="{{ route('jobs.edit', $job) }}">
                                        <x-primary-button>Edit</x-primary-button>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                            <!-- </div> -->
                            @endcan
                        @endforeach
                    </div>
                    @endif
                    </div>
            </section>
        </div>
    </div>
</x-app-layout>
