const { model, Schema } = require('mongoose')

const order = Schema({
	ipn_version : {
		type : Number,
	},
	ipn_type : {
		type : String,
		default : ''
	},
	ipn_mode : {
		type : String,
		default : 'hmac'
	},
	ipn_id : {
		type : String,
		default : ''
	},
	merchant : {
		type : String,
		default : ''
	},
	status : {
		type : Number,
		default : 0
	}, 
	status_text : {
		type : String,
		default : 'Waiting for buyer funds'
	},
	txn_id : {
		type : String,
		default : ''
	},
	currency1 : {
		type : String,
		default : 'USD'
	},
	currency2 : {
		type : String,
		default : 'BTC'
	},
	amount1 : {
		type : String,
		default : ''
	},
	amount2 : {
		type : String,
		default : ''
	},
	amount : {
		type: String,
		default : ''
	},
	fee : {
		type : Number,
		default : 0
	},
	buyer_name : {
		type : String,
		default : 0
	},
	email : {
		type : String,
		default : 0
	},
	item_name : {
		type : String,
		default : 0
	},
	item_number : {
		type : String,
		default : 0
	},
	invoice : {
		type : String,
		default : 0
	},
	custom : {
		type : String,
		default : 0
	},
	send_tx : {
		type : String,
		default : 0
	},
	received_amount : {
		type : String,
		default : '0'
	},
	received_confirms : {
		type : String,
		default : '0'
	},
	address : {
		type : String,
		default : ''
	},
	confirms_needed : {
		type : String,
		default : ''
	},
	timeout: {
		type : Number,
		default : 28800
	},
	checkout_url : {
		type : String,
		default : ''
	},
	status_url : {
		type : String,
		default : ''
	},
	qrcode_url : {
		type : String,
		default : ''
	},
	user : {
		type : String,
		default : ''
	},
	start : {
		type : Date,
		default : Date()
	},
	duration : {
		type : Number,
		default : 1
	},
	maxConcurrent : {
		type : Number,
		default : 1
	},
	maxBoots : {
		type : Number,
		default : 3
	},
	maxTime : {
		type : Number,
		default : 120
	},
	loop : {
		type : Boolean,
		default : false
	},
	api_access : {
		type : Boolean,
		default : false
	},
	key : {
		type : String,
		default : ''
	},
})

module.exports = model('order', order)