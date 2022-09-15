@if(!empty(config('dz.public.global.js.top')))
	@foreach(config('dz.public.global.js.top') as $script)
			<script src="{{ asset($script) }}" type="text/javascript"></script>
	@endforeach
@endif
@php
	// $action = $controller.'_'.$action;
    $action = isset($action) ? $action : '';
@endphp
@if(!empty(config('dz.public.pagelevel.js.'.$action)))
	@foreach(config('dz.public.pagelevel.js.'.$action) as $script)
			<script src="{{ asset($script) }}" type="text/javascript"></script>
	@endforeach
@endif
@if(!empty(config('dz.public.global.js.bottom')))
	@foreach(config('dz.public.global.js.bottom') as $script)
			<script src="{{ asset($script) }}" type="text/javascript"></script>
	@endforeach
@endif
<script src="{{ asset('vendor/toastr/js/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins-init/toastr-init.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.8.0/web3.min.js" integrity="sha512-bSQ2kf76XufUYS/4XinoHLp5S4lNOyRv0/x5UJACiOMy8ueqTNwRFfUZWmWpwnczjRp9SjiF1jrXbGEim7Y0Xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	function alertSuccess(amount, symbol){
			toastr.info("Paid "+amount+symbol+" Successfully", "Success", {
                    positionClass: "toast-top-right",
                    timeOut: 5e3,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: !1
                })
		}
	const abi = [
		{
			"constant": true,
			"inputs": [],
			"name": "symbol",
			"outputs": [
				{
					"name": "",
					"type": "string"
				}
			],
			"payable": false,
			"stateMutability": "view",
			"type": "function"
		},
		{
			"constant": true,
			"inputs": [],
			"name": "decimals",
			"outputs": [
				{
					"name": "",
					"type": "uint8"
				}
			],
			"payable": false,
			"stateMutability": "view",
			"type": "function"
		}
	];
	async function collectData(contract) {
		const [decimals, symbol] = await Promise.all([
			contract.methods.decimals().call(),
			contract.methods.symbol().call()
		]);
		return { decimals, symbol };
	}

	function checkTransferEvent(){

		const web3 = new Web3('wss://rinkeby.infura.io/ws/v3/5be6fa190df6478c910c7f6431285bed');
		let options = {
			topics: [
				web3.utils.sha3('Transfer(address,address,uint256)')
			]
		};

		let subscription = web3.eth.subscribe('logs', options);

		subscription.on('data', event => {
			if (event.topics.length == 3) {
				let transaction = web3.eth.abi.decodeLog([{
					type: 'address',
					name: 'from',
					indexed: true
				}, {
					type: 'address',
					name: 'to',
					indexed: true
				}, {
					type: 'uint256',
					name: 'value',
					indexed: false
				}],
				event.data,
				[event.topics[1], event.topics[2], event.topics[3]]);

				const contract = new web3.eth.Contract(abi, event.address);

				collectData(contract).then(contractData => {
					const unit = Object.keys(web3.utils.unitMap).find(key => web3.utils.unitMap[key] === web3.utils.toBN(10).pow(web3.utils.toBN(contractData.decimals)).toString());
					if (transaction.from == '0x50279d0BB3d6F85E42c6Cac1546d60ac0683A932' && transaction.to == '0x38621Cf6F17D6918eEef43F7C6549caf5FBAE993' && event.address == '0xD92E713d051C37EbB2561803a3b5FBAbc4962431'){
						console.log(`Transfer of ${web3.utils.fromWei(transaction.value, unit)} ${contractData.symbol} from ${transaction.from} to ${transaction.to}`)
						alertSuccess(web3.utils.fromWei(transaction.value, unit), contractData.symbol);
						subscription.unsubscribe(function(error, success){
							if(success)
								console.log('Successfully unsubscribed!');
						});
					}
				})
			}
		});
		subscription.on('error', err => { 
			throw err ;
			subscription.unsubscribe(function(error, success){
				if(success)
					console.log('Successfully unsubscribed!');
			});
		});
	}

	checkTransferEvent();
    
</script>