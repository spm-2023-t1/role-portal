<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="fname" :value="__('First Name')" />
            <x-text-input id="fname" name="fname" type="text" class="mt-1 block w-full" value="{{ old('fname', $user->fname) }}" />
            <x-input-error :messages="$errors->get('fname')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="lname" :value="__('Last Name')" />
            <x-text-input id="lname" name="lname" type="text" class="mt-1 block w-full" value="{{ old('lname', $user->lname) }}" />
            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="dept" :value="__('Department')" />
            <x-text-input id="dept" name="dept" type="text" class="mt-1 block w-full" value="{{ old('dept', $user->dept) }}" />
            <x-input-error :messages="$errors->get('dept')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="biz_address" :value="__('Business Address')" />
            <x-text-input id="biz_address" name="biz_address" type="text" class="mt-1 block w-full" value="{{ old('biz_address', $user->biz_address) }}" />
            <x-input-error :messages="$errors->get('biz_address')" class="mt-2" />
        </div>
        <div>
        <x-input-label for="current_role" :value="__('Current Role')" />
                            <select name="current_role" id="current_role">
                                @foreach ($jobs as $job)
                                    <option value="{{ $job->id }}" >{{ $job->role_name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('current_role')" class="mt-2" />
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
