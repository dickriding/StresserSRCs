const checkAdmin = require('../../functions/checkAdmin')
const keySchema = require('../../models/key')
const axios = require('axios')
const yup = require('yup');

const config = require('../../config.json')

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	keyId: yup.string().length(12).required()
});

module.exports = app => {
	app.get('/admin/getToken/:id/:keyId', async (req, res, next) => {
		const {
			id,
			keyId
		} = req.params
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token,
				keyId
			})
			
			await checkAdmin(Token, req.useragent)

			const keyFound = await keySchema.findOne({ 
				value : keyId
			})
			
			if(!keyFound)
				return next(new Error(`There is no token with ID ${orderId}`))

		 	return res.send({
		 		success : true,
		 		message : keyFound
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}