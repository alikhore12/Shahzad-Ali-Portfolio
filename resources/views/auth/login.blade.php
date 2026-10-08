<x-guest-layout>
    @if (session('status'))<div class="status">{{ session('status') }}</div>@endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field"><label for="email">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@example.com">@error('email')<span class="error">{{ $message }}</span>@enderror</div>
        <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••">@error('password')<span class="error">{{ $message }}</span>@enderror</div>
        <label class="remember"><input type="checkbox" name="remember"> Remember me</label>
        <div class="login-actions"><a href="{{ route('home') }}" style="color:var(--muted);font-size:13px;text-decoration:none">&larr; Back to website</a><button class="login-button" type="submit">Sign in &rarr;</button></div>
    </form>
</x-guest-layout>
