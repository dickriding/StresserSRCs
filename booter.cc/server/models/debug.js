const { model, Schema } = require('mongoose')

const debug = Schema({
	id : {
		type : String,
		default : ''
	},
	error : {
		type : String,
		default : ''
	},
	time : {
		type : Date,
		default : Date()
	}
})

module.exports = model('debug', debug)