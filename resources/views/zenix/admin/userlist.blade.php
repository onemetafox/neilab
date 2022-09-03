{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
		<h2 class="font-w600 title mb-2 me-auto ">{{__('locale.adminuserlist')}}</h2>
		<div class="weather-btn mb-2">
			<span class="me-3 font-w600 text-black"><i class="fa fa-cloud me-2"></i>21</span>
			<select class="form-control style-1 default-select  me-3 ">
				<option>Medan, IDN</option>
				<option>Jakarta, IDN</option>
				<option>Surabaya, IDN</option>
			</select>
		</div>
		<a href="javascript:void(0);" class="btn btn-secondary mb-2"><i class="las la-calendar scale5 me-3"></i>Filter Periode</a>
	</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('locale.adminuserlist')}}</h4>
					@if(session()->has('error'))
					<div class="alert alert-danger"><div class="alert-body">{{ session()->get('error') }}</div></div>
					@endif

					@if(session()->has('success'))
					<div class="alert alert-success"><div class="alert-body">{{ session()->get('success') }}</div></div>
					@endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example7" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>{{__('locale.user_id')}}</th>
                                    <th>{{__('locale.user_status')}}</th>
                                    <th>{{__('locale.user_marketing_campain')}}</th>
                                    <th>{{__('locale.user_first_name')}}</th>
                                    <th>{{__('locale.user_last_name')}}</th>
                                    <th>{{__('locale.user_kyc_status')}}</th>
                                    <th>{{__('locale.user_change_email')}}</th>
                                    <th>{{__('locale.user_change_password')}}</th>
                                    <th>{{__('locale.user_change_upline')}}</th>
                                    <th>{{__('locale.user_view_upline')}}</th>
                                    <th>{{__('locale.user_view_downline')}}</th>
                                    <th>{{__('locale.user_product')}}</th>
                                    <th>{{__('locale.user_MLM_tree')}}</th>
                                    <th>{{__('locale.user_edit_status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $key => $value)
                                <tr>
                                    <td>{{$value['id']}}</td>
                                    <td>
										@if ($value['state'] == 0)
                                        <span class="badge badge-dark">
                                            <i class="fa fa-circle text-primary me-1"></i>
                                            Pending
                                        </span>
										@elseif ($value['state'] == 1)
                                        <span class="badge badge-success">
                                            <i class="fa fa-circle text-danger me-1"></i>
                                            Approved
                                        </span>
										@elseif ($value['state'] == 2)
                                        <span class="badge badge-primary">
                                            <i class="fa fa-circle text-success me-1"></i>
                                            Suspended
                                        </span>
										@else
                                        <span class="badge badge-danger">
                                            <i class="fa fa-circle text-dark me-1"></i>
                                            Decline
                                        </span>
										@endif
									</td>
					

                                    <td><a href="{!! url('/admin/marketingcampainview/'.$value['marketing_campain_id']); !!}">{{$value['marketing_campain_name']}}</a></td>
                                    <td>{{$value['first_name']}}</td>
                                    <td>{{$value['last_name']}}</td>
                                    <td><a href="{!! url('/admin/kyc_edit/'.$value['id']); !!}">{{$value['kyc_status']}}</a></td>
                                    <td><a href="javascript:fireEmailChangeModal({{$value['id']}})">{{$value['email']}}</a></td>
                                    <td><a href="javascript:firePasswordChangeModal({{$value['id']}})">Format</a></td>
                                    <td><a data-bs-toggle="modal" data-bs-target="#basicModal">{{$value['email']}}</a></td>
                                    <td><a href="{!! url('/admin/view_upline/'.$value['id']); !!}">{{$value['email']}}</a></td>
                                    <td><a href="{!! url('/admin/view_downline/'.$value['id']); !!}">{{$value['email']}}</a></td>
                                    <td><a href="{!! url('/admin/user_product/'.$value['id']); !!}">Link</a></td>
                                    <td><a href="{!! url('/admin/mlm_tree/'.$value['id']); !!}">Link</a></td>
                                    <td>
                                        <div class="dropdown ms-auto text-right">
                                            <div class="btn-link" data-bs-toggle="dropdown">
                                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-end">
									

												<a class="dropdown-item" href="{!! url('/admin/change_userstate/'.$value['id'].'/0'); !!}">Pending</a>
                                                <a class="dropdown-item" href="{!! url('/admin/change_userstate/'.$value['id'].'/1'); !!}">Approved</a>
                                                <a class="dropdown-item" href="{!! url('/admin/change_userstate/'.$value['id'].'/2'); !!}">Suspended</a>
                                                <a class="dropdown-item" href="{!! url('/admin/change_userstate/'.$value['id'].'/3'); !!}">Decline</a>
                                            </div>
                                        </div>
                                    </td>	
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="changeEmailModal" aria-hidden="true" style="display: none;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="post" action="{!! url('/admin/changeUserEmail'); !!}">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Change User Email</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="user_id" name="user_id"/>
					<div class="col-xl-12">
						<div class="form-group">
							<label class="mb-1"><strong>Email to be changed</strong></label>
							<input type="text" class="form-control" name="target_email" id="target_email">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="changePasswordModal" aria-hidden="true" style="display: none;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		
			<form method="post" action="{!! url('/admin/changeUserPassword'); !!}">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Change User Password</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="user_password_id" name="user_password_id"/>
					Password will be formated to number "12345".
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger light" data-bs-dismiss="modal">No</button>
					<button type="submit" class="btn btn-primary">Yes</button>
				</div>
			</form>
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


		function fireEmailChangeModal(id){
			$.ajax({
				type: "post",
				
				url : '{!! url('/admin/getUserByID'); !!}',
				data: {
					"_token": "{{ csrf_token() }}",
					"id": id
				},
				success: function(data){
					$("#target_email").val(data['data'][0]['email']);
					$("#user_id").val(data['data'][0]['id']);
				},
			});
			$('#changeEmailModal').modal('show')
		}
		function firePasswordChangeModal(id){
			$.ajax({
				type: "post",
				url : '{!! url('/admin/getUserByID'); !!}',
				data: {
					"_token": "{{ csrf_token() }}",
					"id": id
				},
				success: function(data){
					$("#user_password_id").val(data['data'][0]['id']);
				},
			});
			$('#changePasswordModal').modal('show')
		}
	</script>
@endsection	