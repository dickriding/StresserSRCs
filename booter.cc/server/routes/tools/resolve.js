const checkUser = require('../../functions/checkUser')
const axios = require('axios')

const yup = require('yup');

const config = require('../../config.json')

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	host: yup.string().min(1).max(255).required()
});

module.exports = app => {
	app.post('/tools/resolve/:id', async (req, res, next) => {
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

		  	let defaultHeaders = {
	            'content-type': 'application/json',
	            'authorization': '',
	            'cache-control': 'no-cache',
	            'user-agent': 'censys-cli/1.0'
          	}

		    const buf = Buffer.from(`${config.censys_apiid}:${config.censys_secret}`, 'ascii');
    		defaultHeaders.authorization = `Basic ${buf.toString('base64')}`;

		    const response = await axios.post("https://censys.io/api/v1/search/ipv4", {
		        'query' : host,
		        'page' : 1,
		        'flatten' : false
		      }, {
		        headers : defaultHeaders
		      }
		    )

			if(response.data.status !== "ok")
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