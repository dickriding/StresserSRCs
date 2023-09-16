const checkUser = require('../../functions/checkUser')

const ongoingSchema = require('../../models/ongoing')
const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	attackId: yup.string().length(32).required(),
});

module.exports = (app, server, broadcast) => {
	app.post('/stopAttack/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let { 
			attackId
		} = req.body
		try {
			await schema.validate({
				Token,
				attackId
			})
			
			const userFound = await checkUser(Token, req.useragent)

			const onGoingFound = await ongoingSchema.findOne({
				id : attackId,
				user : userFound.username,
				stopped : false
			})
			if(!onGoingFound)
				return next(new Error(`Attack does not exist or already stopped.`))
			const socketPayload = {
				session : attackId,
				type : 'stop',
				nodes : onGoingFound.nodes
			}

			broadcast(socketPayload)

			onGoingFound.stopped = true
			await onGoingFound.save()

		 	return res.send({
		 		success : true,
		 		message : 'Attack stopped.'
		 	})
			
		} catch (err)
		{
			return next(err)
		}
	})
}