const { model, Schema } = require('mongoose')
const bcrypt = require('bcrypt')

const users = Schema({
	email : {
		type : String,
		unique: true,
		required: true
	},
	username : {
		type : String,
		unique: true,
		required: true
	},
	password : {
		type : String,
		required: true
	},
	admin : {
		type : Boolean,
		default : false,
		required: true
	},
	date : {
		type : Date,
		default : Date()
	},
	concurrent : {
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
	subbed : {
		type : Boolean,
		default : false
	},
	subEnds : {
		type : Date
	},
	api_access : {
		type : Boolean,
		default : false
	},
	api_key : {
		type : String,
		default : ''
	},
	slots : {
		type : Number,
		default : 1
	},
	banned : {
		type : Boolean,
		default : false
	}
})

users.methods.generateHash = (password) => {
	return bcrypt.hashSync(password, bcrypt.genSaltSync(8), null);
};

users.methods.validPassword = (password, password2) => {
	return bcrypt.compareSync(password, password2);
};

module.exports = model('users', users)