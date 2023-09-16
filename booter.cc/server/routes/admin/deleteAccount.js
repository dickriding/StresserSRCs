const checkAdmin = require('../../functions/checkAdmin')

const userSchema = require('../../models/user')
const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	username: yup.string().required()
});

module.exports = app => {
	app.post('/admin/deleteAccount/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let { 
			username
		} = req.body
		try {
			await schema.validate({
				Token,
				username
			})
			
			await checkAdmin(Token, req.useragent)

			await userSchema.deleteOne({
				username
			})

		 	return res.send({
		 		success : true,
		 		message : `User has been successfuly deleted.`
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}