const orderSchema = require('../../models/order')
const generateString = require('../../functions/generateString')
const keySchema = require('../../models/key')

const crypto = require('crypto');
const qs = require(`querystring`);

const yup = require('yup')

const schema = yup.object().shape({
	ipn_version : yup.number().required(),
	ipn_type: yup.string().required(),
	ipn_mode: yup.string().required(),
	ipn_id: yup.string().required(),
	merchant: yup.string().required(),
	status: yup.number().required(),
	status_text: yup.string().required(),
	txn_id: yup.string().required(),
	currency1: yup.string().required(),
	currency2: yup.string().required(),
	amount1: yup.string().required(),
	amount2: yup.string().required(),
	fee: yup.number(),
	buyer_name: yup.string(),
	email: yup.string(),
	item_name: yup.string(),
	item_number: yup.string(),
	invoice: yup.string(),
	custom: yup.string(),
	send_tx: yup.string(),
	received_amount: yup.string(),
	received_confirms: yup.string()
})

module.exports = app => {
	app.post('/super/secret/ipn/callback', async (req, res, next) => {
		const {
			ipn_version,
			ipn_type,
			ipn_mode,
			ipn_id,
			merchant,
			status,
			status_text,
			txn_id,
			currency1,
			currency2,
			amount1,
			amount2,
			fee,
			buyer_name,
			email,
			item_name,
			item_number,
			invoice,
			custom,
			send_tx,
			received_amount,
			received_confirms
		} = req.body

		const {
			hmac
		} = req.headers
		try {
			await schema.validate({
				ipn_version,
				ipn_type,
				ipn_mode,
				ipn_id,
				merchant,
				status,
				status_text,
				txn_id,
				currency1,
				currency2,
				amount1,
				amount2,
				fee,
				buyer_name,
				email,
				item_name,
				item_number,
				invoice,
				custom,
				send_tx,
				received_amount,
				received_confirms
			})

			if(ipn_type !== 'api')
				return next(new Error('Wrong ipn_type.'))

			if(merchant !== '969346454e670677655e0b40147be79f')
				return next(new Error('Wrong ipn_type.'))

			const paramString = qs.stringify(req.body).replace(/%20/g, `+`);

			var hmac_gen = crypto.createHmac('sha512', 'bvmMMa48k7rGjfvWDQ5zkmQk');
			data_gen = hmac_gen.update(paramString);
			gen_hmac= data_gen.digest('hex');

			if(hmac !== gen_hmac)
				return next(new Error('Forged IPN request.'))

			const orderFound = await orderSchema.findOne({
				txn_id
			})
			if(!orderFound)
				return next(new Error('Invalid order.'))

			if( ( orderFound.status >= 0 ||orderFound.status <=99) && status >= 100) {
				console.log('someone got a key')
				// Payment received
				const newKey = new keySchema()
				newKey.id = generateString(32)
				newKey.value = generateString(12)
				newKey.duration = orderFound.duration
				newKey.createdBy = 'AUTO-GENERATED DURING ORDER'
				newKey.maxConcurrent = orderFound.maxConcurrent
				newKey.maxBoots = orderFound.maxBoots
				newKey.maxTime = orderFound.maxTime
				newKey.api_access = orderFound.api_access
				await newKey.save()

				orderFound.key = newKey.value
			}

			orderFound.ipn_version = ipn_version
			orderFound.ipn_type = ipn_type
			orderFound.ipn_mode = ipn_mode
			orderFound.ipn_id = ipn_id
			orderFound.merchant = merchant
			orderFound.status = status
			orderFound.status_text = status_text
			orderFound.currency1 = currency1
			orderFound.currency2 = currency2
			orderFound.amount1 = amount1
			orderFound.amount2 = amount2
			orderFound.fee = fee
			orderFound.buyer_name = buyer_name
			orderFound.email = email
			orderFound.item_name = item_name
			orderFound.item_number = item_number
			orderFound.invoice = invoice
			orderFound.custom = custom
			orderFound.send_tx = send_tx
			orderFound.received_amount = received_amount
			orderFound.received_confirms = received_confirms
			await orderFound.save()

		 	return res.send({
		 		success : true,
		 		message : 'OK'
		 	})
		} catch (err)
		{
			console.log('ipn error')
			console.log(err)
			return next(err)
		}
	})
}
