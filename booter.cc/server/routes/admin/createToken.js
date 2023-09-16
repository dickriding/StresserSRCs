const checkAdmin = require('../../functions/checkAdmin')

const generateString = require('../../functions/generateString')
const keySchema = require('../../models/key')

const yup = require('yup');
const config = require('../../config.json')

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	maxTime : yup.number().max(10000).required('Time is required.'),
	maxConcurrent : yup.number().positive().max(10).required('Max concurrent is required.'),
	duration : yup.number().positive().max(24).required('Duration is required.'),
	api_access : yup.boolean().required('API access is required.'),
	loop_access: yup.boolean().required('Loop access is requried.')
});

module.exports = app => {
	app.post('/admin/createToken/:id', async (req, res, next) => {
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
				maxTime,
				maxConcurrent,
				duration,
				api_access,
				loop_access
			})
			
			const userFound = await checkAdmin(Token, req.useragent)
			
			const newKey = new keySchema()
			newKey.id = generateString(32)
			newKey.value = generateString(12)
			newKey.duration = duration
			newKey.createdBy = userFound.username
			newKey.adminNote = 'MANUAL'
			newKey.maxConcurrent = maxConcurrent
			newKey.maxBoots = 999
			newKey.maxTime = maxTime
			newKey.api_access = api_access
			newKey.loop = loop_access
			await newKey.save()

		 	return res.send({
		 		success : true,
		 		message : newKey.value
		 	})

		} catch (err)
		{
			return next(err)
		}
	})
}