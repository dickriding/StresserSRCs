const cron = require('node-cron')

const ongoingSchema = require('../models/ongoing')
const debugSchema = require('../models/debug')

const generateString = require('../functions/generateString')

const conditions = {
	stopped: false
}
const update = {
	$set : {
		stopped : true
	}
}
const options = { 
	multi: true
}

module.exports = async () => {
	try {
		await ongoingSchema.updateMany(
			conditions,
			update,
			options
		)
		console.log('Ongoing boots stopped.')
	} catch (err) {
		if(err) {
			const debugging = new debugSchema()
			debugging.id = generateString(32)
			debugging.error = err
			await debugging.save()
		}
	}
}