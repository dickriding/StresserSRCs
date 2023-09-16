const checkAdmin = require('../../functions/checkAdmin')

const userSchema = require('../../models/user')
const tokenSchema = require('../../models/token')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	Username: yup.string().required()
});

module.exports = app => {
	app.get('/admin/getUser/:id/:user', async (req, res, next) => {
		const {
			id,
			user: Username
		} = req.params
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token,
				Username
			})
			
			await checkAdmin(Token, req.useragent)

			const userFound = await userSchema.findOne({
				username: Username
			}).select({
				'password' : 0,
			})
			const sessionFound = await tokenSchema.find({
				valid : true,
				email : userFound.email
			}).select({
				'value' : 0,
				'email' : 0,
				'valid' : 0
			})
		 	return res.send({
		 		success : true,
		 		message : { 
		 			userFound,
		 			sessionFound
		 		}
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}