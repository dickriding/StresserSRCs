const { model, Schema } = require('mongoose')

const ongoing = Schema({
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
	method : {
		type : String,
		default : ''
	},
	port : {
		type : Number,
		default : 80
	},
	duration : {
		type : Number,
		default : 0
	},
	stopped : {
		type : Boolean,
		default : false
	},
	time : {
		type : Date,
		default : Date()
	},
	looped : {
		type : Boolean,
		default : false
	},
	nodes : {
		type : Array,
		default : []
	}
})

module.exports = model('ongoing', ongoing)