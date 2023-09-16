const checkAdmin = require('../../functions/checkAdmin')

const debugSchema = require('../../models/debug')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/admin/debug/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			await checkAdmin(Token, req.useragent)

			const debugResults = await debugSchema.find({})
		 	return res.send({
		 		success : true,
		 		message : debugResults
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}