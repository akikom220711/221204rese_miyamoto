<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <!--<a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>-->
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            <!--{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}-->
            {{ __('登録ありがとうございます。確認のメールを送信します。下記リンクをクリックしてください。') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                <!--{{ __('A new verification link has been sent to the email address you provided during registration.') }}-->
                {{ __('確認のメールが送信されました。メール内のリンクをクリックして会員登録を完了してください。') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        <!--{{ __('Resend Verification Email') }}-->
                        {{ __('確認メールを送信') }}
                    </x-button>
                </div>
            </form>

            <form method="GET" action="/userlogout">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    <!--{{ __('Log Out') }}-->
                    {{ __('ログアウト') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
