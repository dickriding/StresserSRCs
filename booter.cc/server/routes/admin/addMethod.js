const checkAdmin = require('../../functions/checkAdmin')
const generateString = require('../../functions/generateString')

const methodSchema = require('../../models/methods')
const yup = require('yup');

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	layer: yup.number().required(),
	title: yup.string().required(),
	name: yup.string().required(),
	program: yup.string().required(),
	args: yup.array().required(),
	nodes: yup.array().required(),
	description: yup.string().required()
});

module.exports = app => {
	app.post('/admin/addMethod/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let { 
			layer,
			title,
			name,
			headersb,
			postdata,
			program,
			args,
			nodes,
			http,
			description,
			getquery,
			cookie,
			option
		} = req.body
		try {
			await schema.validate({
				Token,
				layer,
				title,
				name,
				program,
				args,
				nodes,
				description
			})
			
			const userFound = await checkAdmin(Token, req.useragent)
			if(!userFound.admin) 
				return next(new Error('User is not an admin.'))

			const newMethod = new methodSchema()
			newMethod.id =  generateString(16)
			newMethod.layer = layer 
			newMethod.title = title 
			newMethod.name = name
			newMethod.program = program
			newMethod.args = args 
			newMethod.headers = headersb
			newMethod.postdata = postdata 
			newMethod.nodes = nodes
			newMethod.http = http
			newMethod.description = description
			newMethod.getquery = getquery
			newMethod.cookie = cookie 
			newMethod.option = option 
			await newMethod.save()

		 	return res.send({
		 		success : true,
		 		message : 'Method added successfully.'
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}