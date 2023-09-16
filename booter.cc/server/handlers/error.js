//const debugSchema = require('../models/debug')
//const generateString = require('../functions/generateString')

module.exports = (app) => {
	app.use( async (error, req, res, next) => {
		//console.log(error)
		//const debugging = new debugSchema()
		//debugging.id = generateString(32)
		//debugging.error = error.message
		//await debugging.save()
		res.send({
			success: false,
			message: error.message
		});
	});
}