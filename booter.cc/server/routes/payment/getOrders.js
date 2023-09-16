const checkUser = require('../../functions/checkUser')

const orderSchema = require('../../models/order')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/payhub/getOrders/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			const userFound = await checkUser(Token, req.useragent)

			const currentOrders = await orderSchema.find({ 
				user : userFound.email
			}).select({
				'txn_id' : 1,
				'start' : 1,
				'amount' : 1,
				'status' : 1,
				'status_text' : 1
			})
		 	return res.send({
		 		success : true,
		 		message : currentOrders
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}