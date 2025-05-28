<div class="card">
    <div class="card-header">{{ __('Profile Information') }}</div>

    <div class="card-body">
        <form
            id="send-verification"
            class="d-none"
            method="post"
            action="{{ route('verification.send') }}">
            @csrf
        </form>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">
                    {{ __('Username') }}
                </label>

                <div class="col-md-6">
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}" required autofocus autocomplete="username">

                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>
                    @if (session('status') === 'profile-updated')
                    <span class="m-1 fade-out">{{ __('Saved.') }}</span>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>