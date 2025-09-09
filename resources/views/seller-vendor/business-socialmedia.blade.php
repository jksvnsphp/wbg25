@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light px-3 pb-2">My Social Media</h6>
                <div class="card rounded-0">
                    <div class="card-header">
                        <h6 class="fw-bold fs-6 pb-0 mb-0">Set Social Setting</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('company.add.social')}}" class="row">
                            @csrf
                            <div class="col-md-6 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Set Microsoft Team On/Off</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="skypeOnOff" name="isSkype" @checked(isset($socialMedia->isSkype) && $socialMedia->isSkype==1)/>
                                            <label class="form-check-label" for="skypeOnOff">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="text" name="skype" id="skypeId" class="form-control"
                                                placeholder="Enter your microsoft meet id." value="{{isset($socialMedia->skype)?$socialMedia->skype:''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">
                                            Set LinkedIn On/Off
                                        </h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="linkedInOnOff" name="isLinkedIn" @checked(isset($socialMedia->isLinkedIn) && $socialMedia->isLinkedIn==1) />
                                            <label class="form-check-label" for="linkedInOnOff">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group">
                                            <span class="input-group-text">https://www.linkedin.com/in/</span>
                                            <input type="text" name="linkedin" id="linkedId" class="form-control"
                                                placeholder="Enter your linkedIn id." value="{{isset($socialMedia->linkedin)?$socialMedia->linkedin:''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">
                                            Set Facebook (Meta) On/Off
                                        </h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="facebookOnOff" name="isFacebook" @checked(isset($socialMedia->isFacebook) && $socialMedia->isFacebook==1) />
                                            <label class="form-check-label" for="facebookOnOff">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group">
                                            <span class="input-group-text">https://www.facebook.com/</span>
                                            <input type="text" name="facebook" id="facebookpagename"
                                                class="form-control" placeholder="Enter your facebook page name." value="{{isset($socialMedia->facebook)?$socialMedia->facebook:''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Set X On/Off</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="xOnOff" name="isX" @checked(isset($socialMedia->isX) && $socialMedia->isX==1) />
                                            <label class="form-check-label" for="xOnOff">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group">
                                            <span class="input-group-text">https://www.x.com/</span>
                                            <input type="text" name="x" id="twitter" class="form-control"
                                                placeholder="Enter your twitter (x) user name." value="{{isset($socialMedia->x)?$socialMedia->x:''}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Set Instagram On/Off</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="instagramOnOff" name="isInstagram" @checked(isset($socialMedia->isInstagram) && $socialMedia->isInstagram==1) />
                                            <label class="form-check-label" for="instagramOnOff">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group">
                                            <span class="input-group-text">https://www.instagram.com/</span>
                                            <input type="text" name="instagram" id="instagram" class="form-control"
                                                placeholder="Enter your instagram Id." value="{{isset($socialMedia->instagram)?$socialMedia->instagram:''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Set Youtube On/Off</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="youtubeOnOff" name="isYoutube" @checked(isset($socialMedia->isYoutube) && $socialMedia->isYoutube==1) />
                                            <label class="form-check-label" for="youtubeOnOff">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group">
                                            <span class="input-group-text">https://www.youtube.com/</span>
                                            <input type="text" name="youtube" id="youtube" class="form-control"
                                                placeholder="Enter your youtube username." value="{{isset($socialMedia->youtube)?$socialMedia->youtube:''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-secondary mt-4">Save & Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
