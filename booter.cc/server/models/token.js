const { model, Schema } = require('mongoose')

const tokens = Schema({
	value : {
		type : String,
		default : ''
	},
	valid : {
		type : Boolean,
		default : true
	},
	email : {
		type : String,
		default : ''
	},
	browser : {
		type : String,
		default : ''
	},
	version : {
		type : String,
		default : ''
	},
	os : {
		type : String,
		default : ''
	},
	platform : {
		type : String,
		default : ''
	},
	date : {
		type : Date,
		default : Date()
	}
})

module.exports = model('tokens', tokens)