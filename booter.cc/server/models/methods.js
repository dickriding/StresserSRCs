const { model, Schema } = require('mongoose')

const methods = Schema({
	id : {
		type : String,
		default : ''
	},
	layer : {
		type : Number,
		default : 7
	},
	description: {
		type : String,
		default : ''
	},
	title : {
		type : String,
		default : ''
	},
	name : {
		type : String,
		default : ''
	},
	program: {
		type : String,
		default : ''
	},
	args : {
		type : Array,
		default : []
	},
	headers : {
		type : Boolean,
		default : false
	},
	postdata : {
		type : Boolean,
		default : false
	},
	http : {
		type : Boolean,
		default : false
	},
	getquery : {
		type : Boolean,
		default : false
	},
	cookie : {
		type : Boolean,
		default : false
	},
	option : {
		type : Boolean,
		default: false
	},
	nodes : {
		type : Array,
		default : []
	}
})

module.exports = model('methods', methods)