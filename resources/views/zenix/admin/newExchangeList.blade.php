{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
		<h2 class="font-w600 title mb-2 me-auto ">{{__('locale.admin_create_new_exchange_list')}}</h2>
		<a href="javascript:void(0);" class="btn btn-secondary mb-2"><i class="las la-calendar scale5 me-3"></i>Filter Periode</a>
	</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('locale.admin_create_new_exchange_list')}}</h4>
					@if(session()->has('error'))
					<div class="alert alert-danger"><div class="alert-body">{{ session()->get('error') }}</div></div>
					@endif

					@if(session()->has('success'))
					<div class="alert alert-success"><div class="alert-body">{{ session()->get('success') }}</div></div>
					@endif
                </div>
                <div class="card-body">
					<div class="row no-gutters">
						<form method="post" action="{!! url('/update_exchange_list'); !!}">
							@csrf
							<input type="hidden" name="old_id" value="{{isset($result)?$result[0]['id']:''}}"/>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Exchange Name</strong></label>
										<input type="text" class="form-control" name="ex_name" placeholder="Input exchange name" value="{{isset($result)?$result[0]['ex_name']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Login</strong></label>
										<input type="text" class="form-control" name="ex_login" value="{{isset($result)?$result[0]['ex_login']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Password</strong></label>
										<input type="text" class="form-control" name="ex_password"  value="{{isset($result)?$result[0]['ex_password']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>sms phone number</strong></label>
										<input type="text" class="form-control" name="ex_sms_phone_number"  value="{{isset($result)?$result[0]['ex_sms_phone_number']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>API login</strong></label>
										<input type="text" class="form-control" name="api_login"  value="{{isset($result)?$result[0]['api_login']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>API password</strong></label>
										<input type="text" class="form-control" name="api_password"  value="{{isset($result)?$result[0]['api_password']:''}}">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>account name</strong></label>
										<input type="text" class="form-control" name="api_account_name"  value="{{isset($result)?$result[0]['api_account_name']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>API Key</strong></label>
										<input type="text" class="form-control" name="api_key"  value="{{isset($result)?$result[0]['api_key']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>API Secret</strong></label>
										<input type="text" class="form-control" name="api_secret"  value="{{isset($result)?$result[0]['api_secret']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Passphase</strong></label>
										<input type="text" class="form-control" name="api_passphase"  value="{{isset($result)?$result[0]['api_passphase']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>fund Password</strong></label>
										<input type="text" class="form-control" name="api_fund_password"  value="{{isset($result)?$result[0]['api_fund_password']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>API doc</strong></label>
										<input type="text" class="form-control" name="api_doc"  value="{{isset($result)?$result[0]['api_doc']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>API doc Link</strong></label>
										<input type="text" class="form-control" name="api_doc_link"  value="{{isset($result)?$result[0]['api_doc_link']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Bank Login</strong></label>
										<input type="text" class="form-control" name="bank_login"  value="{{isset($result)?$result[0]['bank_login']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Bank Password</strong></label>
										<input type="text" class="form-control" name="bank_password"  value="{{isset($result)?$result[0]['bank_password']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Bank Link</strong></label>
										<input type="text" class="form-control" name="bank_link"  value="{{isset($result)?$result[0]['bank_link']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Bank Other</strong></label>
										<input type="text" class="form-control" name="bank_other"  value="{{isset($result)?$result[0]['bank_other']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Contact Name</strong></label>
										<input type="text" class="form-control" name="contact_name"  value="{{isset($result)?$result[0]['contact_name']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Contact Email</strong></label>
										<input type="text" class="form-control" name="contact_email"  value="{{isset($result)?$result[0]['contact_email']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Contact Phone</strong></label>
										<input type="text" class="form-control" name="contact_phone"  value="{{isset($result)?$result[0]['contact_phone']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Contact Telegram</strong></label>
										<input type="text" class="form-control" name="contact_telegram" value="{{isset($result)?$result[0]['contact_telegram']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Contact Whatsapp</strong></label>
										<input type="text" class="form-control" name="contact_whatsapp" value="{{isset($result)?$result[0]['contact_whatsapp']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Contact skype</strong></label>
										<input type="text" class="form-control" name="contact_skype" value="{{isset($result)?$result[0]['contact_skype']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Contact Boom Boom chat</strong></label>
										<input type="text" class="form-control" name="contact_boom_boom_chat" value="{{isset($result)?$result[0]['contact_boom_boom_chat']:''}}">
									</div>
								</div>
							</div>
							<input type="submit" class="btn btn-secondary mb-2" value="Save"></input>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection	

{{-- Scripts --}}
@section('scripts')
	<script>
		jQuery(document).ready(function(){
			dezSettingsOptions.version = 'dark';
			setTimeout(function() {
				dezSettingsOptions.version = 'dark';
				new dezSettings(dezSettingsOptions);
			}, 1500)
		});
	</script>
@endsection	