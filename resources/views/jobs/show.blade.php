<x-app-layout>
    <x-slot name="header">
        
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 my-4">
        <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
            <section>
                <header class="flex justify-between flex-col sm:flex-row border-b pb-4">
                    <div class="flex items-center">
                        <x-primary-button class="mr-2" title="Go back" onclick="goBack()">&lt;</x-primary-button>
                        <h2 class="text-xl font-medium text-gray-900">
                            
                            View Applicants for <strong>{{ $job->role_name }}</strong> Role
                        </h2>
                    </div>
                </header>
                <!-- Javascript code for back button -->
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
                <div class="flex py-4">
                    <div class="h-12 w-12 p-2 rounded-md border bg-gray-50 flex align-middle justify-center">
                        <svg class="w-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" fill="currentColor"></path></svg>
                    </div>
                    
                        <div class="flex-1 ml-4">
                                    <div class="text-xl text-gray-900">{{ $job->role_name }}</div>
                                    <div class="mt-1 text-gray-800">{{ $job->description }}</div>
                                    <div class="mt-1 text-gray-800">Total applicants: {{ count($job->applicants->where('pivot.role_app_status', 'applied')) }}</div>
                                    <div class="mt-1 text-gray-800">Application deadline: {{ $job->deadline }}</div>
                                    <div class="mt-1 text-gray-800">Job Status: {{ ucfirst($job->listing_status) }}</div>
                                    <div class="mt-1 text-gray-600">Skills required:</div>
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
                        
                    </div>
                    
                </div>
                <div class="mt-3">
                    @if (Auth::user()->role === \App\Enums\UserRole::HumanResource || \App\Enums\UserRole::Manager)
                       
                        <div class="divide-y">
                            <div class="text-lg text-black-900">Total applicants: {{ count($job->applicants->where('pivot.role_app_status', 'applied')) }}</div>
                            @foreach($job->applicants->where('pivot.role_app_status', 'applied') as $applicant)
                                <div class="py-2">
                                    <div><span class="font-medium">Applicant {{ $loop->index + 1 }}'s Name:</span> {{ $applicant->fname }}  {{ $applicant->lname }} </div>
                                    <div><span class="font-medium">Skills:</span>
                                        @foreach ($applicant->skills as $skill)
                                            @if (collect($job->skills)->contains('id', $skill->id))
                                                <div class="bg-green-300 rounded mx-1 px-1 inline">
                                                    {{ $skill->name }}
                                                </div>
                                            @else
                                                <div class="bg-red-300 rounded mx-1 px-1 inline">
                                                    {{ $skill->name }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div><span class="font-medium">Additional Remarks:</span> {{$applicant['pivot']->remarks}} </div>
                                    <div><span class="font-medium">Department:</span> {{ $applicant->dept }} </div>
                                    <div><span class="font-medium">Current Role:</span> {{ $applicant->role }} </div>
                                    <div><span class="font-medium">Email:</span> {{ $applicant->email }} </div>
                                   
                                    <div><span class="font-medium">Business Address:</span> {{ $applicant->biz_address }} </div>
                                    <div><span class="font-medium">Current RO:</span> {{Auth::user()->reporting_officer->fname}} {{Auth::user()->reporting_officer->lname}}</div>
                                    <div><span class="font-medium">Current RO's Email:</span> {{Auth::user()->reporting_officer->email}}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-gray-900">Total applications: {{ count($job->applicants->where('pivot.role_app_status', 'applied')) }}</div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
