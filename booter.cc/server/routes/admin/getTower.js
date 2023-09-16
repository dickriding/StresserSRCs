const checkAdmin = require('../../functions/checkAdmin')

const orderSchema = require('../../models/order')
const logsSchema = require('../../models/ongoing')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = (app, server, b, socketsInfo) => {
	app.get('/admin/getTower/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			await checkAdmin(Token, req.useragent)
			const priceArray = await orderSchema.find({
			}).select({
				'amount1' : 1,
				'status' : 1
			})
			let revenue = 0
			let net = 0
			let pendingorders = 0
			let overdue = 0

			priceArray.forEach( (e) => {
				if(e.status == 100) {
					net += Number(e.amount1) - 400
					revenue += Number(e.amount1)
				}	
				if(e.status == -1)
					overdue += Number(e.amount1)
				if(e.status == 0)
					pendingorders += Number(e.amount1)
			})

			net = Math.round(net)
			revenue = Math.round(revenue)
			overdue = Math.round(overdue)
			pendingorders = Math.round(pendingorders)

			var start = new Date();
			start.setHours(0,0,0,0);

			var end = new Date();
			end.setHours(23,59,59,999);

			const logsFound = await logsSchema.find({
				time : {
					$gte: start, 
					$lt: end
				}
			}).select({
				'user' : 1,
				'destination' : 1,
				'port' : 1,
				'method' : 1,
				'time' : 1
			})

			server.getConnections((error,count) => {
 			 	return res.send({
			 		success : true,
			 		message : {
			 			net,
			 			revenue,
			 			pendingorders,
			 			overdue,
			 			logsFound,
			 			socketsInfo,
			 			connectedSocket: count
			 		}
			 	})
		 	});


		} catch (err)
		{
			return next(err)
		}
	})
}