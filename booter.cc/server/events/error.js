const debugSchema = require('../models/debug')
const generateString = require('../functions/generateString')

module.exports = async (server, error) => {
	const debugging = new debugSchema()
	debugging.id = generateString(32)
	debugging.error = error.message
	await debugging.save()
	console.log(`TCP BOTNET ERROR ${error}`)
}