const cron = require('node-cron');

const ongoingSchema = require('../models/ongoing')
const userSchema = require('../models/user')
const debugSchema = require('../models/debug')
const orderSchema = require('../models/order')

const generateString = require('../functions/generateString')

const config = require('../config.json')
const proxyList = require('../proxy.json')

const todayDate = new Date()

const conditions = {
	subbed : true,
	subEnds : {
		$lte : todayDate
	}
}
const update = {
	$set : {
		subbed : false,
		loop : false,
		api_access : false,
		concurrent : 1,
		maxBoots : 3,
		maxTime : 120
	}
}
const options = { 
	multi: true
}

module.exports = (broadcast) => {
	cron.schedule('0 0,30 * * * *', async () => {
		console.log('All cron ran.') 
		try {
			let cmd1 = ''
			let cmd2 = ''
			proxyList.proxy.forEach( (ex) => {
				cmd1 += `curl ${config.proxyWebsite}/${ex.file}>${ex.file};`
				cmd2 += `curl ${config.proxyWebsite}/${ex.file_http}>${ex.file_http};`
			})	
			const socketPayload = {
				type : 'proxy',
				nodes : ['free', 'l3', 'l4', 'spoof', 'main', 'loop'],
				cmd1 : cmd1,
				cmd2 : cmd2
			}

			broadcast(socketPayload)
		} catch (err) {
			const debugging = new debugSchema()
			debugging.id = generateString(32)
			debugging.error = err.message
			await debugging.save()
		}
		try {
			const usersAmount = await userSchema.find(conditions)
			await userSchema.updateMany(conditions, update, options)
			console.log(`Expired subscribed users (${usersAmount.length}) are stripped of their subscription.`)
		} catch (err) {
			const debugging = new debugSchema()
			debugging.id = generateString(32)
			debugging.error = err.message
			await debugging.save()
		}
		try {
			var genDate = new Date();
			genDate.setHours(0,0,0,0);
			const bootsAmount = await ongoingSchema.find({
				stopped: true,
				time : {
					$lte: genDate
				}
			})
			await ongoingSchema.deleteMany({
				stopped: true,
				time : {
					$lte: genDate
				}
			})
		} catch (e) {
			const debugging = new debugSchema()
			debugging.id = generateString(32)
			debugging.error = err.message
			await debugging.save()
		}
		try {
			var genDate = new Date();
			genDate.setHours(0,0,0,0);
			const ordersAmount = await orderSchema.find({
				status: -1,
				time : {
					$lte: genDate
				}
			})
			await orderSchema.deleteMany({
				status: -1,
				time : {
					$lte: genDate
				}
			})
		} catch (e) {
			const debugging = new debugSchema()
			debugging.id = generateString(32)
			debugging.error = err.message
			await debugging.save()
		}
	})
}