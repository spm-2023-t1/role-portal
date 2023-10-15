<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Listings Dashboard') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 my-4">
        <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
            <section>
                <header class="flex justify-between flex-col sm:flex-row border-b pb-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Job Listings') }}
                        </h2>
                    </div>
                    @can('create', \App\Models\Job::class)
                        <x-primary-button-link class="h-10 mt-4 sm:mt-0 sm:ml-2" :href="route('jobs.create')">{{ __('Create New Job Listing') }}</x-primary-button-link>
                    @endcan
                </header>
                
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
                
                <div class="divide-y">
                    @foreach ($jobs as $job)
                        <div class="flex py-4">
                            <div class="h-12 w-12 p-2 rounded-md border bg-gray-50 flex align-middle justify-center">
                                <svg class="w-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" fill="currentColor"></path></svg>
                            </div>
                            <div class="flex-1 ml-4">
                                <div class="text-xl text-gray-900">{{ $job->title }}</div>
                                <div class="mt-1 text-gray-800">{{ $job->description }}</div>
                                <div class="mt-3 text-gray-800">Application deadline: {{ $job->deadline }}</div>
                                <div class="mt-3 text-gray-600">Skills required:</div>
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
                                            <h2 class="text-lg font-medium text-gray-900">{{ $job->title }}</h2>
                                            <p class="mt-2 text-gray-800">ID: {{ $job->id }}</p>
                                            <p class="mt-2 text-gray-800">Name: {{ $job->role_name }}</p>
                                            <p class="mt-2 text-gray-800">Description: {{ $job->description }}</p>
                                            <p class="mt-2 text-gray-800">Type: {{ ucfirst($job->role_type) }}</p>
                                            <p class="mt-2 text-gray-800">Status: {{ ucfirst($job->listing_status) }}</p>
                                            <p class="mt-2 text-gray-800">Created on: {{ $job->date_of_creation }}</p>
                                            <p class="mt-2 text-gray-800">Created by: {{ $job->user_id }}</p>
                                            {{-- <p class="mt-2 text-gray-800">Created by: {{ User::where('user_id','=',Auth::user())->whereIn('id', $job->user_id)->get(); }}</p> --}}
                                            {{-- <p class="mt-2 text-gray-800">Created by: {{ $job->user_id->fname }}</p> --}}
                                            <p class="mt-2 text-gray-800">Time of last edit: {{ $job->updated_at }}</p>
                                            <p class="mt-2 text-gray-800">Application deadline: {{ $job->deadline }}</p>
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

                        

                        
                               


                                <div class="mt-3">
                                    @if (collect(Auth::user()->applications)->contains('id', $job->id))
                                        <div class="text-green-600">Applied successfully.</div>
                                    @else
                                        <form method="post" action="{{ route('jobs.apply', $job) }}">
                                            @csrf
                                            @method('patch')
                                            <x-primary-button onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Apply for this job') }}</x-primary-button>
                                        </form>
                                    @endif
                                </div>
                                @can('update', $job)
                                <div class="mt-3">
                                    <a href="{{ route('jobs.show', $job) }}">
                                    <x-primary-button>Show All Applicants</x-primary-button>
                                    </a>
                                </div>
                                @endcan
                            </div>
                            @can('update', $job)
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('jobs.edit', $job)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
