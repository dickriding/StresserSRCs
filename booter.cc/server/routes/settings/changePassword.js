const checkUser = require('../../functions/checkUser')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	password: yup.string().max(255).required('Password is required'),
	newpassword: yup.string().max(255).required('New Password is required'),
	repeatnewpassword: yup.string().max(255).required('Repeat New Password is required'),
});

module.exports = app => {
	app.post('/settings/changePassword/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let { 
			password,
			newpassword,
			repeatnewpassword
		} = req.body
		try {
			await schema.validate({
				Token,
				password,
				newpassword,
				repeatnewpassword
			})
			
			if(newpassword !== repeatnewpassword)
				return next(new Error('Confirm new password does not match new password.'))
			const userFound = await checkUser(Token, req.useragent)

			if(!userFound.validPassword(password, userFound.password))
				return next(new Error('Password does not match'))

			userFound.password = userFound.generateHash(newpassword);

			userFound.save().then(() => {
				return res.send({
					success : true,
					message : 'Password changed.'
				})
			}).catch(err => {
				return next(new Error(err))
			})
			


		} catch (err)
		{
			return next(err)
		}
	})
}