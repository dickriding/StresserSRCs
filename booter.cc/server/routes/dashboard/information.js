const checkUser = require('../../functions/checkUser')

const userSchema = require('../../models/user')
const logsSchema = require('../../models/logs')
const ongoingSchema = require('../../models/ongoing')

const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required()
});

module.exports = (app) => {
	app.get('/information/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		try {
			await schema.validate({
				Token
			})
			
			await checkUser(Token, req.useragent)

			const totalUsers = 2000 + await userSchema.countDocuments()
			const totalBoots = 70000 + await logsSchema.countDocuments()
			const totalOngoing = await ongoingSchema.countDocuments({
				stopped: false
			})
		 	return res.send({
		 		success : true,
		 		message : {
		 			totalUsers,
		 			totalBoots,
		 			totalServers : totalOngoing
		 		}
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}
