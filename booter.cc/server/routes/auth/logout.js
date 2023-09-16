const checkUser = require('../../functions/checkUser')
const tokenSchema = require('../../models/token')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/logout/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			const userFound = await checkUser(Token, req.useragent)
			const findToken = await tokenSchema.findOne({
				email : userFound.email,
				valid : true
			})
			if(!findToken)
				return next(new Error('Invalid token.'))

			findToken.valid = false;
			await findToken.save()
		 	return res.send({
		 		success : true,
		 		message : 'Logged out.'
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}