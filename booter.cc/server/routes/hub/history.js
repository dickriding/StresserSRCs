const checkUser = require('../../functions/checkUser')

const ongoingSchema = require('../../models/ongoing')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/panel/history/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			const userFound = await checkUser(Token, req.useragent)

			const historyArr = await ongoingSchema.find({ 
				user : userFound.username
			}).select({
				'user' : 0,
				'nodes' : 0
			})
		 	return res.send({
		 		success : true,
		 		message : historyArr
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}