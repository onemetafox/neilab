{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('locale.exchange_list')}}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example7" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>{{__('locale.exchange_list_id')}}</th>
                                    <th>{{__('locale.exchange_list_name')}}</th>
                                    <th>{{__('locale.exchange_list_email')}}</th>
                                    @if (Auth::user()->user_type == 'admin')
                                    <th>{{__('locale.exchange_list_wallet_address')}}</th>
                                    @endif
                                    <th>{{__('locale.exchange_list_test_status')}}</th>
                                    <th>{{__('locale.exchange_list_certified')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $key => $value)
                                <tr>
                                    <td>{{++$key}}</td>
                                    @switch($value['ex_name'])
                                        @case('Binance')
                                            <td>Binance</td>
                                            @break
                                        @case('FTX')
                                            <td>FTX</td>
                                            @break
                                        @case('kucoin')
                                            <td>Kucoin</td>
                                            @break
                                        @case('gateio')
                                            <td>Gate.io</td>
                                            @break
                                        @case('bitfinex')
                                            <td>Bitfinex</td>
                                            @break
                                        @case('huobi')
                                            <td>Huobi</td>
                                            @break
                                        @case('bitstamp')
                                            <td>Bitstamp</td>
                                            @break
                                        @case('okx')
                                            <td>OKX</td>
                                            @break

                                        @default
                                            <td></td>

                                    @endswitch
                                    <td>{{$value['ex_login']}}</td>
                                    @if (Auth::user()->user_type == 'admin')
                                    <td>{{$value['wallet_address']}}</td>
                                    @endif
                                    <td>
                                        @if ($value['connect_status'] == false)
                                        <span class="badge light badge-danger">
                                            <i class="fa fa-circle text-danger me-1"></i>
                                            Disconnected
                                        </span>
                                        @else
                                        <span class="badge light badge-success">
                                            <i class="fa fa-circle text-success me-1"></i>
                                            Connected
                                        </span>
                                        @endif
                                    </td>
                                    <td>Certified</td>
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

@endsection

{{-- Scripts --}}
@section('scripts')
	<script>
		jQuery(document).ready(function(){
			dezSettingsOptions.version = '<?php echo $theme_mode?>';
			setTimeout(function() {
				dezSettingsOptions.version = '<?php echo $theme_mode?>';
				new dezSettings(dezSettingsOptions);
			}, 1500)
		});
	</script>
@endsection
