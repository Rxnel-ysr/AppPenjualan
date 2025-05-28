<div class="card">
    <div class="card-header">{{ __('Logout') }}</div>

    <div class="card-body">
        <div class="row mb-0">
            <div class="col-md-6">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
        </form>
    </div>
</div>