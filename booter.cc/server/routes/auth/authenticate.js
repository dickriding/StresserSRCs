const checkUser = require('../../functions/checkUser')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/authenticate/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			await checkUser(Token, req.useragent)

		 	return res.send({
		 		success : true,
		 		message : 'Authentication is valid'
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}