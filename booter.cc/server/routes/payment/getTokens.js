const checkUser = require('../../functions/checkUser')

const keySchema = require('../../models/key')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/payhub/getTokens/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			const userFound = await checkUser(Token, req.useragent)

			const currentTokens = await keySchema.find({ 
				usedBy : userFound.email,
				used: true
			}).select({
				'value' : 1,
				'usedAt' : 1
			})

		 	return res.send({
		 		success : true,
		 		message : currentTokens
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}