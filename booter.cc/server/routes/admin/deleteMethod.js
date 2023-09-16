const checkAdmin = require('../../functions/checkAdmin')

const methodSchema = require('../../models/methods')
const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	methodId: yup.string().length(16).required(),
});

module.exports = app => {
	app.post('/admin/deleteMethod/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let { 
			methodId
		} = req.body
		try {
			await schema.validate({
				Token,
				methodId
			})
			
			const userFound = await checkAdmin(Token, req.useragent)
			if(!userFound.admin) 
				return next(new Error('User is not an admin.'))

			await methodSchema.findOneAndRemove( { id : methodId})

		 	return res.send({
		 		success : true,
		 		message : 'Method removed successfully.'
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}