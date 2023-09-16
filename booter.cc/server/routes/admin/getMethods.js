const checkAdmin = require('../../functions/checkAdmin')

const methodSchema = require('../../models/methods')
const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/admin/getMethod/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			const userFound = await checkAdmin(Token, req.useragent)
			if(!userFound.admin) 
				return next(new Error('User is not an admin.'))

			const currentMethods = await methodSchema.find( {} )
		 	return res.send({
		 		success : true,
		 		message : currentMethods
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}