const checkUser = require('../../functions/checkUser')

const methodSchema = require('../../models/methods')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = (app, server) => {
	app.get('/getDocs/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			const userFound = await checkUser(Token, req.useragent)

			const methodsFound = await methodSchema.find({
				layer: {
					$ne: 70
				}
			}).select({
				'name' : 1,
				'title' : 1,
				'description' : 1,
				'layer' : 1
			})
		 	return res.send({
		 		success : true,
		 		message : {
		 			methodsFound,
		 			apikey : userFound.api_key
		 		}
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}