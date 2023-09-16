const { model, Schema } = require('mongoose')

const logs = Schema({
	id : {
		type : String,
		default : ''
	},
	user : {
		type : String,
		default : ''
	},
	destination : {
		type : String,
		default : ''
	},
	port : {
		type : Number,
		default : ''
	},
	method : {
		type : String,
		default : ''
	},
	duration : {
		type : Number,
		default : 0
	},
	time : {
		type : Date,
		default : Date()
	}
})

module.exports = model('logs', logs)