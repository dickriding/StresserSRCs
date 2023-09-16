const checkUser = require('../../functions/checkUser')
const axios = require('axios')

const yup = require('yup');

const config = require('../../config.json')

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	host: yup.string().min(1).max(255).required()
});

module.exports = app => {
	app.post('/tools/lookup/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let {
			host
		} = req.body;
		try {
			await schema.validate({
				Token,
				host
			})

			await checkUser(Token, req.useragent)
			const response = await axios.get(`http://ip-api.com/json/${host}`)

			if(response.data.status !== "success")
				return next(new Error('No results found.'))

		 	return res.send({
		 		success : true,
		 		message : response.data
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}