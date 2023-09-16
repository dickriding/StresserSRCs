const checkAdmin = require('../../functions/checkAdmin')

const orderSchema = require('../../models/order')
const keySchema = require('../../models/key')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/admin/getOrders/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			await checkAdmin(Token, req.useragent)

			const currentOrders = await orderSchema.find({}).select({
				'txn_id' : 1,
				'start' : 1,
				'amount' : 1,
				'status' : 1,
				'status_text' : 1,
				'user' : 1
			})

			const totalOrders = await orderSchema.countDocuments()
			const paidOrders = await orderSchema.countDocuments({
				status: 100
			})
			const priceArray = await orderSchema.find({
				status: 100
			}).select({
				'amount1' : 1
			})
			let totalPrice = 0
			priceArray.forEach( (e) => {
				totalPrice += e.amount1
			})
			const currentTokens = await keySchema.find({}).select({
				'value' : 1,
				'createdBy' : 1,
				'adminNote' : 1,
				'createdAt' : 1,
				'used' : 1
			})

		 	return res.send({
		 		success : true,
		 		message : {
		 			currentOrders,
		 			currentTokens,
		 			totalOrders,
		 			paidOrders,
		 			totalPrice
		 		}
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}