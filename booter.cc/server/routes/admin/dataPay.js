const checkAdmin = require('../../functions/checkAdmin')

const userSchema = require('../../models/user')
const orderSchema = require('../../models/order')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = app => {
	app.get('/admin/dataPay/:id', async (req, res, next) => {
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

			const subbedUsers = await userSchema.countDocuments({
				subbed : true
			})
			const totalOrders = await orderSchema.countDocuments({
				status : 1
			})
			const totalPriceBTC = await orderSchema.aggregate([
			    { $match: { status : 1 } },
			    { $group: { _id : null, amount: { $sum: "amount_paid_in_btc" } } }
			])
			const totalPriceUSD = await orderSchema.aggregate([
			    { $match: { status : 1 } },
			    { $group: { _id : null, amount: { $sum: "amount" } } }
			])
		 	return res.send({
		 		success : true,
		 		message : {
		 			subbedUsers,
		 			totalOrders,
		 			totalPriceBTC,
		 			totalPriceUSD
		 		}
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}