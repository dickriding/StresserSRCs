const checkAdmin = require('../../functions/checkAdmin')

const userSchema = require('../../models/user')

const axios = require('axios')

const yup = require('yup');
const config = require('../../config.json')

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	username: yup.string().required(),
	maxTime : yup.number().min(360).max(10000).required('Time is required.'),
	maxConcurrent : yup.number().positive().max(10).required('Max concurrent is required.'),
	duration : yup.number().positive().max(24).required('Duration is required.'),
	api_access : yup.boolean().required('API access is required.'),
	loop_access: yup.boolean().required('Loop access is requried.')
});

module.exports = app => {
	app.post('/admin/updateUser/:id/:user', async (req, res, next) => {
		const {
			id,
			user: username
		} = req.params
		const {
			authorizationtoken: Token
		} = req.headers
		let { 
			maxTime,
			maxConcurrent,
			duration,
			api_access,
			loop_access
		} = req.body
		try {
			await schema.validate({
				Token,
				username,
				maxTime,
				maxConcurrent,
				duration,
				api_access,
				loop_access
			})
			
			await checkAdmin(Token, req.useragent)

			const userFound = await userSchema.findOne({
				username
			})
			if(!userFound)
				return next(new Error('Invalid username.'))

			const date = new Date()
			userFound.concurrent = maxConcurrent
			userFound.maxBoots = 999 
			userFound.maxTime = maxTime
			userFound.api_access = api_access
			userFound.loop = loop_access
			userFound.subbed = true
			userFound.subEnds = new Date(date.setMonth(date.getMonth()+duration))
			await userFound.save()

		 	return res.send({
		 		success : true,
		 		message : 'Information updated!'
		 	})

		} catch (err)
		{
			return next(err)
		}
	})
}