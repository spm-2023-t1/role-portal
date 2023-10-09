<div>

    <div class="container">
         <div class="row mt-5">

              <div class="col-md-12">
                    <!-- Search box -->
                    <input type="text" class="form-control" placeholder="Search Name or city" style="width: 250px;" wire:model="searchTerm" >

                    <!-- Paginated records -->
                    <table class="table">
                         <thead>
                              <tr>
                                  <th class="sort" wire:click="sortOrder('name')">Name {!! $sortLink !!}</th>
                                  <th class="sort" wire:click="sortOrder('email')">Email {!! $sortLink !!}</th>
                                  {{-- <th class="sort" wire:click="sortOrder('city')">City {!! $sortLink !!}</th> --}}
                                  <th>Status</th>
                              </tr>
                         </thead>
                         <tbody>
                              @if ($users->count())
                                   @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            {{-- <td>{{ $user->skills }}</td> --}}
                                        </tr>
                                   @endforeach
                              @else
                                   <tr>
                                        <td colspan="5">No record found</td>
                                   </tr>
                              @endif
                         </tbody>
                    </table>

                    <!-- Pagination navigation links -->
                    {{ $users->links() }}
              </div>

         </div>
    </div>

</div>