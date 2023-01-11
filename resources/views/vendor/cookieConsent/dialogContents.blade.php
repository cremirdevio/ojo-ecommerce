
<div class="js-cookie-consent cookie-consent alert alert-dismissible fade show" role="alert">
    <div class="main-cookie-content">
        <p class="cookie-consent__message m-0">
            {!! trans('cookieConsent::texts.message') !!}
        </p>

        <button class="allow-button primary-btn js-cookie-consent-agree cookie-consent__agree">
            {{ trans('cookieConsent::texts.agree') }}
        </button>
    </div>
    @if (Route::is('admin') || Route::is('admin.*'))
        <button type="button" class="btn-close front-close-btn" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    @else
        <button type="button" class="btn-close front-close-btn" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif

</div>
