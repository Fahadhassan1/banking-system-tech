<x-guest-layout>
    <form method="POST" action="{{ route('verify.store') }}">
        @csrf
        <p class="text-muted">
            You have received an email which contains two factor login code.
            If you haven't received it, press <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('verify.resend') }}">here</a>.
        </p>



        <div class="mt-4 mb-3">
            <x-input-label for="two_factor_code" :value="__('Two Factor Verification')" />
            <x-text-input id="two_factor_code" class="block mt-1 w-full" type="text" name="two_factor_code"  required autofocus placeholder="Two Factor Code" />
            <x-input-error :messages="$errors->get('two_factor_code')" class="mt-2" />
            
        </div>

        <div class="row mt-4">
            <x-primary-button class="ml-4 col-md-4 " type="submit">
                
                {{ __('Verify') }}
                
            </x-primary-button>

            <x-danger-button class="ml-4 col-md-4">
                <a class="px-4 text-white" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                {{ __('Logout') }}
                </a>
            </x-danger-button>
           
        </div>
    </form>

<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>    
</x-guest-layout>
