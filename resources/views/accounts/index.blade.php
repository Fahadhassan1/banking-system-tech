<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Saving Accounts List ') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-8 lg:px-10">
            <div class="bg-white ove shadow-sm sm:rounded-lg p-6">


                <!-- showing error message -->
                <div>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach($errors->all() as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    @endif
                </div>

                  <!-- showing success message -->
                <div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            <?php echo session('success'); ?>
                        </div>
                    @endif
                </div>

                  <!-- showing error message -->
                  <div>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <?php echo session('error'); ?>
                        </div>
                    @endif
                </div>

                

                <div class="content-body">
                    <!-- Basic table -->
                    <section id="basic-datatable">
                        <div class="row">
                            <div class="col-12">
                                <table class="table-responsive table mb-0 table-borderless nowrap" id="datatable_t">
                                    <thead class="datatable-header">
                                    <tr>
                                        <th class="w-600">Acc#.</th>
                                        <th class="w-600">First</th>
                                        <th class="w-600">Last</th>
                                        <th class="tab-remove w-600">DOB</th>
                                        <th class="tab-remove w-600">Balance</th>
                                        <th class="tab-removew-600">Created</th>
                                        <th class="tab-remove w-600">Status</th>
                                        <th class="w-600">Actions</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>

                           
                
            </div>
        </div>
    </div>


 <script>
        document.addEventListener("DOMContentLoaded", function () {
        
            let datatable =$('#datatable_t').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,
                lengthChange: false,
                order: [[0, 'desc']],
                // scrollX: true,
                ajax: {
                    url: "{!! route('accounts.get.data') !!}",
                    type: 'GET',

                },
                columns: [
                    { data: 'account_number', name: 'account_number'},
                    { data: 'first_name', name: 'first_name'},
                    { data: 'last_name', name: 'last_name' },
                    { data: 'dob', name: 'dob' },
                    { data: 'balance', name: 'balance' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' , orderable: false, searchable: false},
                ],
            });
    
             // Custom search functionality
             $('#custom-search').on('keyup', function() {
                datatable.search(this.value).draw(); 
            });
     });
       
    </script>   
</x-guest-layout>
