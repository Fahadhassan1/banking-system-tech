<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accounts Creation ') }}
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

                           
                <form method="POST" action="{{ route('accounts.store') }}" id="bookForm">
                    @csrf
                        <!--Add  accounts Button -->
                        <div class="row mt-4">
                            <div class="col-md-12 text-end">
                                <x-danger-button type="button" class="addButton">
                                    {{ __('Add accounts') }}
                                </x-danger-button>
                            </div>
                        </div>

                        <div class="row accounts-fields form-group" id="bookTemplate" >
                            <!-- User ID -->

                             <div class="ms-4 col-md-2 mt-3">
                                <x-input-label for="currency" :value="__('Select User ')" />
                                <select id="user_id" class="user_id border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm form-control mt-1" name="accounts[0][user_id]" required autocomplete="user_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->email }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>


                            <!-- First Name -->
                            <div class="ms-2 col-md-2 mt-3">
                                <x-input-label for="fname" :value="__('First Name')" />
                                <x-text-input id="fname" class="fname form-control mt-1" type="text"  name="accounts[0][fname]"  required  autocomplete="fname" />
                                <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                            </div>
                    
                            <!-- Last Name -->
                            <div class="ms-4 col-md-2 mt-3">
                                <x-input-label for="lname" :value="__('Last Name')" />
                                <x-text-input id="lname" class="lname form-control mt-1" type="text"   name="accounts[0][lname]" required autocomplete="lname" />
                                <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                            </div>


                           <!-- Date of Birth -->
                            <div class="ms-4 col-md-2 mt-3">
                                <x-input-label for="dob" :value="__('Date of Birth')" />
                                <x-text-input id="dob" class="dob form-control mt-1" type="date"  name="accounts[0][dob]"  required autocomplete="dob" />
                                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                            </div>

                            <!-- address -->
                            <div class="ms-4 col-md-2 mt-3">
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" class="address form-control mt-1" type="text"  name="accounts[0][address]" required autocomplete="address" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <!-- Phone Number -->
                            <div class="ms-4 col-md-2 mt-3">
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" class="phone form-control mt-1" type="text"   name="accounts[0][phone]" required autocomplete="phone" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />

                            </div>


                            <!-- Currency -->
                            <div class="ms-4 col-md-2 mt-3">
                                <x-input-label for="currency" :value="__('Currency')" />
                                <select id="currency" class="currency border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm form-control mt-1"  name="accounts[0][currency]" required autocomplete="currency">
                                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                </select>
                                <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                            </div>

                            <!-- Balnce -->
                            <div class="ms-4 col-md-2 mt-3">
                                <x-input-label for="balance" :value="__('Balance')" />
                                <x-text-input id="balance" class="balance form-control mt-1" type="number"  :value="10000"   name="accounts[0][balance]" required autocomplete="balance" />
                                <x-input-error :messages="$errors->get('balance')" class="mt-2" />
                            </div>
                    
                        
                            <div class="ms-4  col-md-2 mt-4 bookFormRemoveButton d-none">
                                    <x-primary-button class="mt-3 removeButton" type="button">
                                        {{ __('Remove') }}
                                    </x-primary-button>
                            </div>
                        
                        </div>

                    
                        <!-- Submit Button -->
                        <div class="row mt-5" id="submit-button">
                            <div class="col-md-12 text-center">
                                <x-primary-button type="submit">
                                    {{ __('Create Saving accounts') }}
                                </x-primary-button>
                            </div>
                        </div>
                    
                </form>
            </div>
        </div>
    </div>



<script src="{{ asset('js/accounts/create.js') }}"></script>

</x-guest-layout>
