const checkUser = require('../../functions/checkUser')
const orderSchema = require('../../models/order')
const generateString = require('../../functions/generateString')
const keySchema = require('../../models/key')
const axios = require('axios')
const yup = require('yup');

const config = require('../../config.json')

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	orderId: yup.string().required()
});

module.exports = app => {
	app.get('/payhub/getOrder/:id/:orderId', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		const {
			id,
			orderId
		} = req.params
		try {
			await schema.validate({
				Token,
				orderId
			})
			
			const userFound = await checkUser(Token, req.useragent)

			const orderFound = await orderSchema.findOne({ 
				user : userFound.email,
				txn_id : orderId
			}).select({
				'qrcode_url' : 1,
				'start' : 1,
				'duration' : 1,
				'maxConcurrent' : 1,
				'maxBoots' : 1,
				'maxTime' : 1,
				'api_access' : 1,
				'key' : 1,
				'address' : 1,
				'received_confirms' : 1,
				'received_amount' : 1,
				'amount' : 1,
				'status_text' : 1,
				'timeout' : 1,
				'status' : 1
			})

			if(!orderFound)
				return next(new Error(`There is no order with ID ${orderId}`))

		 	return res.send({
		 		success : true,
		 		message : orderFound
		 	})
		} catch (err)
		{
			console.log(err)
			return next(err)
		}
	})
}