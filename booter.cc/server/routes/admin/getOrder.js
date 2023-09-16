const checkAdmin = require('../../functions/checkAdmin')
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
	app.get('/admin/getOrder/:id/:orderId', async (req, res, next) => {
		const {
			id,
			orderId
		} = req.params
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token,
				orderId
			})
			
			await checkAdmin(Token, req.useragent)

			const orderFound = await orderSchema.findOne({ 
				txn_id : orderId
			})
			if(!orderFound)
				return next(new Error(`There is no order with ID ${orderId}`))

		 	return res.send({
		 		success : true,
		 		message : orderFound
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}