<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home Page') }}
        </h2> -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome ") }}
                   {{ Auth::user()->fname}}
                            
                            {{ Auth::user()->lname }}
                    {{ __("!") }}
                    
                </div>

                <div class="flex-1 ml-4">
                       <div class="mt-3 text-gray-800">Update Your Profile ->
                    
                                {{-- <div class="mt-3"> --}}
                                    <a href="{{ route('profile.edit') }}">
                                    <x-primary-button>Profile</x-primary-button>
                                    </a>
                                {{-- </div> --}}
                               
                            </div>
                    

                            <div class="mt-3 text-gray-800">View Job Listings ->
                    
                                {{-- <div class="mt-3"> --}}
                                    <a href="{{ route('jobs.index') }}">
                                    <x-primary-button>Jobs</x-primary-button>
                                    </a>
                                {{-- </div> --}}
                               
                            </div>
                            
                            @can('viewAny', \App\Models\Skill::class)
                   
                            <div class="mt-3 text-gray-800">View Skills ->
                    
                                {{-- <div class="mt-3"> --}}
                                    <a href="{{ route('skills.index') }}">
                                    <x-primary-button>Skills</x-primary-button>
                                    </a>
                                {{-- </div> --}}
                               
                            </div>
                            @endcan

                            @can('viewAny', \App\Models\User::class)
                            <div class="mt-3 text-gray-800">View Staff ->
                    
                                {{-- <div class="mt-3"> --}}
                                    <a href="{{ route('users.index') }}">
                                    <x-primary-button>Staff</x-primary-button>
                                    </a>
                                {{-- </div> --}}
                               
                            </div>
                            @endcan
                            
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
