@extends('front.layouts.master')
@section('title', isset($title) ? $title : 'Home')
@section('description', isset($description) ? $description : '')
@section('keywords', isset($keywords) ? $keywords : '')

@section('content')
    @if ((session('theme') && session('theme') == 'theme2') || $allsettings['theme'] == 'two')
        @include('front.home.themetwo')
    @else
        @include('front.home.themeone')
    @endif
@endsection

@section('subscribe_pop_up_modal')
    @if (!session()->has('dontshoW'))
        <!-- Page Load Popup Modal End -->
        <div class="modal fade bd-example-modal-lg theme-modal" id="popUpModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body modal1 modal-bg">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-7 col-md-12">
                                        <div class="offer_modal_left">
                                            <img src="{{ asset(IMG_LOGO_PATH . $allsettings['main_logo']) }}"
                                                alt="logo">
                                            <h3>{{ __('SUBSCRIBE TO NEWSLETTER') }}</h3>
                                            <p class="m-0">
                                                {{ __('Subscribe For The Latest News.') }}
                                            </p>

                                            <form id="subscribe_form" name="subscribe_form">
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control subscribeModal"
                                                        name="subscribeval" id="subscribeval"
                                                        placeholder="{{ __('Your email') }}">
                                                    <div class="input-group-append">
                                                        <button
                                                            class="theme-btn-one btn-black-overlay btn_sm border-0 subscribeModal"
                                                            id="subscribeModal">
                                                            {{ __('Subscribe') }}</button>
                                                    </div>
                                                </div>
                                                <div class="check_boxed_modal">
                                                    <input type="checkbox" id="doNotShowModel" name="dontshowmodal"
                                                        value="dont_show">
                                                    <label for="vehicle1">{{ __("Don't show this popup again") }}</label>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-12">
                                        <div class="offer_modal_img d-none d-lg-flex">
                                            <img src="{{ asset(IMG_ADVERTISE_PATH . $allsettings['popup_image']) }}"
                                                alt="img">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Page Load Popup Modal End -->
    <div id="DoNotSubscribe" data-url="{{ route('do.not.subscribe') }}"></div>
    <div id="SubscribeStore" data-url="{{ route('admin.subscribe.store') }}"></div>
    @push('post_script')
        <script src="{{ asset('frontend/assets/js/pages/home.js') }}"></script>
    @endpush()
@endsection
