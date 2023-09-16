const checkAdmin = require('../../functions/checkAdmin')

const userSchema = require('../../models/user')
const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	username: yup.string().required()
});

module.exports = app => {
	app.post('/admin/banUser/:id', async (req, res, next) => {
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

			const userFound = await userSchema.findOne({
				username
			})
			if(!userFound)
				return next(new Error('User not found.'))

			if(userFound.banned)
				userFound.banned = false
			else
				userFound.banned = true

			await userFound.save()
		 	return res.send({
		 		success : true,
		 		message : `User ${userFound.username} has been successfuly ${userFound.banned ? '' : 'un'}banned`
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}