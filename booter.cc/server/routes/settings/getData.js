const checkUser = require('../../functions/checkUser')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = (app, server) => {
	app.get('/settings/getData/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			const userFound = await checkUser(Token, req.useragent)

			server.getConnections((error,count) => {
			 	return res.send({
			 		success : true,
			 		message : {
			 			username : userFound.username,
			 			email : userFound.email
			 		}
			 	})
		 	});
		} catch (err)
		{
			return next(err)
		}
	})
}