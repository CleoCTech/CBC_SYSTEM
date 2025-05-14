@extends('layouts.master')
@section('page_title', 'Send SMS')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Send SMS</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form class="ajax-store" method="post" action="{{ route('sms.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Phone No. <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="receiver" value="{{ old('receiver') }}" required type="text" class="form-control" placeholder="Eg. 0789456123">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="message" class="col-lg-3 col-form-label font-weight-semibold">Message</label>
                            <div class="col-lg-9">
                                <textarea  class="form-control" name="message" id="message" value="{{ old('message') }}" cols="30" rows="10">

                                </textarea>
                                
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Send SMS <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
