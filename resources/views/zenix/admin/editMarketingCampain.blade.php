{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
		<h2 class="font-w600 title mb-2 me-auto ">{{__('locale.add_new_marketing_campain')}}</h2>
		<a href="javascript:void(0);" class="btn btn-secondary mb-2"><i class="las la-calendar scale5 me-3"></i>Filter Periode</a>
	</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('locale.add_new_marketing_campain')}}</h4>
					@if(session()->has('error'))
					<div class="alert alert-danger"><div class="alert-body">{{ session()->get('error') }}</div></div>
					@endif

					@if(session()->has('success'))
					<div class="alert alert-success"><div class="alert-body">{{ session()->get('success') }}</div></div>
					@endif
                </div>
                <div class="card-body">
					<div class="row no-gutters">
						<form method="post" action="{!! url('/admin/updateMarketing/'); !!}">
							@csrf
							<input type="hidden" name="old_id" value="{{isset($result)?$result[0]['id']:''}}"/>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Campain Name</strong></label>
										<input type="text" class="form-control" name="campain_name" value="{{isset($result)?$result[0]['campain_name']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Total Fee To Client</strong></label>
										<input type="number" step="any" min="0" class="form-control" name="total_fee"  value="{{isset($result)?$result[0]['ex_password']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Internal Sales Manager Fee</strong></label>
										<input type="number" step="any" min="0" class="form-control" name="internal_sales_fee"  value="{{isset($result)?$result[0]['ex_sms_phone_number']:''}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Uni-Level Fee</strong></label>
										<input type="number" step="any" min="0" class="form-control" name="uni_level_fee"  value="{{isset($result)?$result[0]['api_login']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>External Sales Manager</strong></label>
										<input type="number" step="any" min="0" class="form-control" name="external_sales_fee"  value="{{isset($result)?$result[0]['api_password']:''}}">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Trust Fee</strong></label>
										<input type="number" step="any" min="0" class="form-control" name="trust_fee"  value="{{isset($result)?$result[0]['api_login']:''}}">
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Profit Fee</strong></label>
										<input type="number" step="any" min="0" class="form-control" name="profit_fee"  value="{{isset($result)?$result[0]['api_password']:''}}">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Require KYC</strong></label>
										<select id="kyc_required" name="kyc_required">
											<option value="1">yes</option>
											<option value="2">no</option>
										</select></div>
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label class="mb-1"><strong>Select Domain From Drop Down</strong></label>
										<select id="domain_id" name="domain_id">
											@foreach ($domains as $key => $domain)
												<option value="{{++$key}}">{{$domain['domain_name']}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-check custom-checkbox mb-3 checkbox-info">
										<input type="checkbox" class="form-check-input" id="active_add_new" name="active_add_new" onclick="showAddNewDomainForm()">
										<label class="form-check-label" for="customCheckBox2">Add New Domain Website</label>
									</div>
								</div>
							</div>
							<div  id="newDomainWebsiteForm">
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

		function showAddNewDomainForm(){
			var active = document.getElementById('active_add_new');
			if(active.checked){
				$('#newDomainWebsiteForm').html(
							"<div class='row'>"+
								"<div class='col-xl-6'>"+
									"<div class='form-group'>"+
										"<label class='mb-1'><strong>Enter New Domain</strong></label>"+
										"<input type='text' class='form-control' name='domain_name'>"+
									"</div>"+
								"</div>"+
							"</div>"+
							"<div class='col-xl-12'>"+
								"<div class='form-group'>"+
									"<label class='mb-1'><strong>First Signup Page</strong></label>"+
									"<textarea class='form-control' id='signup_page' name='signup_page' maxlength='1000'></textarea>"+
								"</div>"+
							"</div>"+
							"<div class='col-xl-12'>"+
								"<div class='form-group'>"+
									"<label class='mb-1'><strong>Agreement Page</strong></label>"+
									"<textarea class='form-control' id='agreement_page' name='agreement_page' maxlength='1000'></textarea>"+
								"</div>"+
							"</div>"+
							"<div class='col-xl-12'>"+
								"<div class='form-group'>"+
									"<label class='mb-1'><strong>Last Page</strong></label>"+
									"<textarea class='form-control' id='last_page' name='last_page' maxlength='1000'></textarea>"+
								"</div>"+
							"</div>"
							);
			}else{
				$('#newDomainWebsiteForm').html("");
			}
		}
	</script>
@endsection	