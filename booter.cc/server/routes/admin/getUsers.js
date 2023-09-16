const checkAdmin = require('../../functions/checkAdmin')

const userSchema = require('../../models/user')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/admin/getUsers/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			await checkAdmin(Token, req.useragent)

			const userResults = await userSchema.find({}).select({
				'password' : 0,
				'concurrent' : 0,
				'maxBoots' : 0,
				'maxTime' : 0,
				'loop' : 0,
				'api_access' : 0,
				'api_key' : 0,

			})
		 	return res.send({
		 		success : true,
		 		message : userResults
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}