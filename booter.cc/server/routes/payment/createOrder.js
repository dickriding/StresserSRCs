const checkUser = require('../../functions/checkUser')
const generateString = require('../../functions/generateString')

const orderSchema = require('../../models/order')

const axios = require('axios')

const Coinpayments = require("coinpayments")

const yup = require('yup');
const config = require('../../config.json')

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	maxTime : yup.number().positive().min(360).max(10000).required('Time is required.'),
	maxConcurrent : yup.number().positive().max(10).required('Max concurrent is required.'),
	duration : yup.number().positive().max(24).required('Duration is required.'),
	api_access : yup.boolean().required('API access is required.')
});

var client = new Coinpayments({
    key: "fb14cde8248745d94e49e7aabc400249c05822b95783457cd6c92033797cbdb1",
    secret: "d2bd885864Fc014c6bAfc9e3a203b125dd01d694cFA66B1b71d90Ea486fcA28c"
});

module.exports = app => {
	app.post('/payhub/addOrder/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let { 
			maxTime,
			maxConcurrent,
			duration,
			api_access
		} = req.body
		try {
			await schema.validate({
				Token,
				maxTime,
				maxConcurrent,
				duration,
				api_access
			})
			
			const userFound = await checkUser(Token, req.useragent)

			const price = Number( ( (api_access ? 2 : 1) * ( duration  * (
                    (maxTime * 0.01387) +
                    (maxConcurrent * 10) ))).toFixed(2)
                  )

			const result = await client.createTransaction({
				'currency1' : 'USD', 
				'currency2' : 'BTC', 
				'amount' : price,
				'buyer_email' : userFound.email,
				'buyer_name' : userFound.username
			})

			const newOrder = new orderSchema()
			newOrder.amount1 = price 
			newOrder.amount2 = result.amount
			newOrder.amount = result.amount 
			newOrder.txn_id = result.txn_id
			newOrder.address = result.address
			newOrder.confirms_needed = result.confirms_needed 
			newOrder.timeout = result.timeout
			newOrder.checkout_url = result.checkout_url
			newOrder.status_url = result.status_url
			newOrder.qrcode_url = result.qrcode_url
			newOrder.user = userFound.email
			newOrder.maxConcurrent = maxConcurrent
			newOrder.maxBoots = 999 
			newOrder.maxTime = maxTime
			newOrder.api_access = api_access
			newOrder.duration  = duration
			newOrder.start = new Date()
			await newOrder.save()

		 	return res.send({
		 		success : true,
		 		message : newOrder.txn_id
		 	})

		} catch (err)
		{
			console.log(err)
			return next(err)
		}
	})
}
