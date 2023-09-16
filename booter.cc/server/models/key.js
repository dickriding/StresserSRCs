const { model, Schema } = require('mongoose')

const key = Schema({
	id : {
		type : String,
		default : ''
	},
	value : {
		type : String,
		default : ''
	},
	used : {
		type : Boolean,
		default : false
	},
	duration : {
		type : Number,
		default : 1
	},
	createdBy : {
		type : String,
		default : ''
	},
	createdAt : {
		type : Date,
		default : Date()
	},
	adminNote : {
		type : String,
		default : 'AUTO-GENERATED'
	},
	usedAt : {
		type : Date
	},
	usedBy : {
		type : String,
		default : ''
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
	}
})

module.exports = model('key', key)