const { model, Schema } = require('mongoose')

const blacklist = Schema({
	id : {
		type : String,
		default : ''
	},
	regex : {
		type : String,
		default : ''
	}
})

module.exports = model('blacklist', blacklist)