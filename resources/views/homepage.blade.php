<x-app-layout>
    <x-slot name="header">
        
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
                    
                                
                                    <a href="{{ route('profile.edit') }}">
                                    <x-primary-button>Profile</x-primary-button>
                                    </a>
                                
                               
                            </div>
                    

                            <div class="mt-3 text-gray-800">View Job Listings ->
                    
                                
                                    <a href="{{ route('jobs.index') }}">
                                    <x-primary-button>Jobs</x-primary-button>
                                    </a>
                                
                               
                            </div>
                            
                            @can('viewAny', \App\Models\Skill::class)
                   
                            <div class="mt-3 text-gray-800">View Skills ->
                    
                                
                                    <a href="{{ route('skills.index') }}">
                                    <x-primary-button>Skills</x-primary-button>
                                    </a>
                                
                            </div>
                            @endcan

                            @can('viewAny', \App\Models\User::class)
                            <div class="mt-3 text-gray-800">View Staff ->
                    
                               
                                    <a href="{{ route('users.index') }}">
                                    <x-primary-button>Staff</x-primary-button>
                                    </a>
                                
                               
                            </div>
                            @endcan
                            
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
