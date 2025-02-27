<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction History') }}
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
                                        <th class="w-600">Sender</th>
                                        <th class="w-600">Receiver</th>
                                        <th class="w-600">Type</th>
                                        <th class="w-600">Amount</th>
                                        <th class="w-600">Currency</th>
                                        <th class="tab-remove w-600">ExchangeRate</th>
                                        <th class="tab-remove w-600">FinalAmount</th>
                                        <th class="tab-removew-600">Description</th>
                                        <th class="tab-remove w-600">Created</th>
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
        
            let account_id = {!! json_encode($account_id) !!};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let datatable =$('#datatable_t').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,
                lengthChange: false,
                order: [[0, 'desc']],
                // scrollX: true,
                ajax: {
                    url: "{{ route('transactions.get.data') }}",
                    type: 'POST',
                    data: function(d) {
                        d.account_id = account_id;
                    }
                },
                columns: [
                    { data: 'sender', name: 'sender'},
                    { data: 'receiver', name: 'receiver'},
                    { data: 'transaction_type', name: 'transaction_type'},
                    { data: 'amount', name: 'amount'},
                    { data: 'currency', name: 'currency' },
                    { data: 'exchange_rate', name: 'exchange_rate' },
                    { data: 'final_amount', name: 'final_amount' },
                    { data: 'description', name: 'description' },
                    { data: 'created_at', name: 'created_at' },
                ],
            });
    
             // Custom search functionality
             $('#custom-search').on('keyup', function() {
                datatable.search(this.value).draw(); 
            });
     });
       
    </script>   
</x-guest-layout>
