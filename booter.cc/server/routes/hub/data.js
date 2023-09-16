const checkUser = require('../../functions/checkUser')

const ongoingSchema = require('../../models/ongoing')
const methodSchema = require('../../models/methods')

const proxies = require('../../proxy.json')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/data/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			const userFound = await checkUser(Token, req.useragent)

			const currentConcurrent = await ongoingSchema.countDocuments({
				user : userFound.username,
				stopped : false
			})

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

			const availableMethods = await methodSchema.find( {} ).select({
				'title' : 0,
				'program' : 0,
				'args' : 0,
				'nodes' : 0
			})
			
			const returnMsg = {
				maxConcurrent : userFound.concurrent,
				maxBoots : userFound.maxBoots,
				maxTime : userFound.maxTime,
				currentConcurrent,
				currentBoots,
				availableMethods,
				isSubbed : userFound.subbed,
				subEnds : userFound.subEnds,
				hasAPI : userFound.api_access,
				proxiesList : proxies.proxy,
				isLoop : userFound.loop
			}

		 	return res.send({
		 		success : true,
		 		message : returnMsg
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}