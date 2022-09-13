const Web3 = require("web3");
const web3 = new Web3("https://mainnet.infura.io/v3/9ad37bf7991e4b5b96ff8e5351d8b37c");

const USDTAddress = "0xdAC17F958D2ee523a2206206994597C13D831ec7";

const ERC20_ABI = [
    {"constant":true,"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},
    
];

var args = process.argv.slice(2);
console.log(args);
if (args.length<2) {
    console.log('Address and amount are required.'); // message
    return 0;
    process.exit();
}

const pk_sender_address = args[0];
const to_address = args[1];
const amount = args[2];

run(pk_sender_address, to_address, amount);

async function run(pk_sender_address, to_address, amount) {
    web3.eth.accounts.wallet.add(pk_sender_address);
    const tokenContract = new Web3.eth.Contract(USDTAddress, ERC20_ABI);
    const transaction = await tokenContract.methods.transfer(to_address, amount).send({from: SENDER_ADDRESS});
    return transaction;
    console.log(transaction);
}
