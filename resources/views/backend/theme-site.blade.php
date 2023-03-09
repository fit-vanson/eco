@extends('layouts.backend')

@section('title', __('Theme Options'))

@section('content')
<!-- main Section -->
<div class="main-body">
	<div class="container-fluid">
		@php $vipc = vipc(); @endphp
		@if($vipc['bkey'] == 0)
		@include('backend.partials.vipc')
		@else
		<div class="row mt-25">
			<div class="col-lg-12">
				<div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                {{ __('Theme Options') }}
                            </div>
                            <div class="col-lg-6">
                                <div class="float-right">
                                    <a href="{{ route('backend.MultipleSites') }}" class="btn warning-btn"><i class="fa fa-reply"></i> {{ __('Back to List') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card-body tabs-area p-0">
						@include('backend.partials.theme_options_tabs_nav')
						<div class="tabs-body">
							<!--Data Entry Form-->
{{--							<form novalidate="" data-validate="parsley" id="DataEntry_formId">--}}

{{--								<div class="row">--}}
{{--									<div class="col-md-8">--}}

{{--										<div class="form-group">--}}
{{--											<label for="favicon">{{ __('Favicon') }}<span class="red">*</span></label>--}}
{{--											<div class="tp-upload-field">--}}
{{--												<input value="{{ $datalist['favicon'] }}" name="favicon" id="favicon" type="text" class="form-control" readonly>--}}
{{--												<a id="on_favicon" href="javascript:void(0);" class="tp-upload-btn"><i class="fa fa-window-restore"></i>{{ __('Browse') }}</a>--}}
{{--											</div>--}}
{{--											<em>Recommended favicon.ico size width: 32px and height: 32px.</em>--}}
{{--											<div id="remove_favicon" class="select-image dnone">--}}
{{--												<div class="inner-image" id="view_favicon"></div>--}}
{{--												<a onClick="onMediaImageRemove('favicon')" class="media-image-remove" href="javascript:void(0);"><i class="fa fa-remove"></i></a>--}}
{{--											</div>--}}
{{--										</div>--}}

{{--										<div class="form-group">--}}
{{--											<label for="front_logo">{{ __('Front Logo') }}<span class="red">*</span></label>--}}
{{--											<div class="tp-upload-field">--}}
{{--												<input value="{{ $datalist['front_logo'] }}" name="front_logo" id="front_logo" type="text" class="form-control" readonly>--}}
{{--												<a id="on_front_logo" href="javascript:void(0);" class="tp-upload-btn"><i class="fa fa-window-restore"></i>{{ __('Browse') }}</a>--}}
{{--											</div>--}}
{{--											<em>Recommended front logo size width: 250px and height: 85px. The logo must be a file of type png</em>--}}
{{--											<div id="remove_front_logo" class="select-image dnone">--}}
{{--												<div class="inner-image" id="view_front_logo"></div>--}}
{{--												<a onClick="onMediaImageRemove('front_logo')" class="media-image-remove" href="javascript:void(0);"><i class="fa fa-remove"></i></a>--}}
{{--											</div>--}}
{{--										</div>--}}

{{--										<div class="form-group">--}}
{{--											<label for="back_logo">{{ __('Back Logo') }}<span class="red">*</span></label>--}}
{{--											<div class="tp-upload-field">--}}
{{--												<input value="{{ $datalist['back_logo'] }}" name="back_logo" id="back_logo" type="text" class="form-control" readonly>--}}
{{--												<a id="on_back_logo" href="javascript:void(0);" class="tp-upload-btn"><i class="fa fa-window-restore"></i>{{ __('Browse') }}</a>--}}
{{--											</div>--}}
{{--											<em>Recommended front logo size width: 250px and height: 85px. The logo must be a file of type png</em>--}}
{{--											<div id="remove_back_logo" class="select-image dnone">--}}
{{--												<div class="inner-image" id="view_back_logo"></div>--}}
{{--												<a onClick="onMediaImageRemove('back_logo')" class="media-image-remove" href="javascript:void(0);"><i class="fa fa-remove"></i></a>--}}
{{--											</div>--}}
{{--										</div>--}}

{{--									</div>--}}
{{--									<div class="col-md-4"></div>--}}
{{--								</div>--}}

{{--								<div class="row tabs-footer mt-15">--}}
{{--									<div class="col-lg-12">--}}
{{--										<a id="submit-form" href="javascript:void(0);" class="btn blue-btn">{{ __('Save') }}</a>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</form>--}}

                            <form novalidate="" data-validate="parsley" id="DataEntry_formId">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="product_name">{{ __('Site Name') }}<span class="red">*</span></label>
                                            <input value="{{ $datalist->site_name }}" type="text" name="site_name" id="site_name" class="form-control parsley-validated" data-required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="product_name">{{ __('Site Web') }}<span class="red">*</span></label>
                                            <input value="{{ $datalist->site_web}}" type="text" name="site_web" id="site_web" class="form-control parsley-validated" data-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="cat_id">{{ __('Category') }}<span class="red">*</span></label>
                                            <select name="categoryid[]" id="cat_id" class="chosen-select form-control" multiple>
                                                @foreach($categorylist as $row)
                                                    <option {{ $datalist->categories->contains($row->id) ? "selected=selected" : '' }} value="{{ $row->id }}">
                                                        {{ $row->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="is_publish">{{ __('Status') }}<span class="red">*</span></label>
                                            <select name="is_publish" id="is_publish" class="chosen-select form-control">
                                                @foreach($statuslist as $row)
                                                    <option {{ $row->id == $datalist['is_publish'] ? "selected=selected" : '' }} value="{{ $row->id }}">
                                                        {{ $row->status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-9"></div>
                                </div>
                                <input value="{{ $datalist['id'] }}" type="text" name="RecordId" id="RecordId" class="dnone">
                                <div class="row tabs-footer mt-15">
                                    <div class="col-lg-12">
                                        <a id="submit-form" href="javascript:void(0);" class="btn blue-btn">{{ __('Save') }}</a>
                                    </div>
                                </div>
                            </form>
							<!--/Data Entry Form/-->
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
<!-- /main Section -->

<!--Global Media-->
@include('backend.partials.global_media')
<!--/Global Media/-->

@endsection

@push('scripts')
<!-- css/js -->
<script src="{{asset('backend/pages/multiple_sites.js')}}"></script>

@endpush
