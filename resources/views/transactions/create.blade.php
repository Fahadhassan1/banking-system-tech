<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Funds Transfer') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-8 lg:px-10">
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

                           
                <form method="POST" action="{{ route('transfer.store') }}" id="bookForm">
                    @csrf
                   

                        <div class="row accounts-fields form-group px-8" id="bookTemplate" >

                            <!-- Recipient account number -->
                            <div class="ms-4 col-md-12 mt-3">
                                <x-input-label for="account_number" :value="__('Recipient Account Number')" />
                                <x-text-input id="recipient_account_number" class="recipient_account_number form-control mt-1" type="text"  name="recipient_account_number" required autocomplete="recipient_account_number" />
                                <x-input-error :messages="$errors->get('recipient_account_number')" class="mt-2" />   
                            </div>
                          

                            <!-- Currency -->
                            <div class="ms-4 col-md-12 mt-3">
                                <x-input-label for="currency" :value="__('Currency')" />
                                <select id="currency" class="currency border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm form-control mt-1"  name="currency" required autocomplete="currency">
                                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                </select>
                                <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                            </div>

                            <!-- Balnce -->
                            <div class="ms-4 col-md-12 mt-3">
                                <x-input-label for="amount" :value="__('Amount')" />
                                <x-text-input id="amount" class="amount form-control mt-1" type="number" min='1' name="amount" required autocomplete="amount" />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="ms-4 col-md-12 mt-3">
                                <x-input-label for="description" :value="__('Description')" />
                                <x-text-input id="description" class="description form-control mt-1" type="text" name="description" required autocomplete="description" />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />

                            </div>     
                
                        
                        </div>

                    
                        <!-- Submit Button -->
                        <div class="row mt-5" id="submit-button">
                            <div class="col-md-12 text-center">
                                <x-primary-button type="submit">
                                    {{ __('Transfer Funds') }}
                                </x-primary-button>
                            </div>
                        </div>
                    
                </form>
            </div>
        </div>
    </div>


 <script>
        document.addEventListener("DOMContentLoaded", function () {
        
            
     });
       
    </script>   
</x-guest-layout>
