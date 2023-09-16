const checkAdmin = require('../../functions/checkAdmin')

const userSchema = require('../../models/user')
const yup = require('yup');

const config = require('../../config.json')
const proxyList = require('../../proxy.json')

const nodes = [
  'free',
  'l3',
  'l4',
  'main',
  'spoof'
]

const types = [
  'exec',
  'permission-file',
  'write-file',
  'delete-file',
  'update'
]

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	type: yup.string().required().oneOf(types),
	node: yup.string().required().oneOf(nodes).default('main')
});

module.exports = (app, socket, broadcast) => {
	app.post('/admin/action/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let { 
			type,
			node,
			cmd,
			filename,
			content,
			permission
		} = req.body
		try {
			await schema.validate({
				Token,
				type,
				node
			})
			
			await checkAdmin(Token, req.useragent)

			switch (type) {
				case 'exec' : 
					broadcast({
						nodes: [node],
						type : 'exec',
						cmd: cmd
					})
					break;
				case 'permission-file' : 
					broadcast({
						nodes: [node],
						type : 'write-permission',
						filename: filename,
						permission: permission
					})
					break;	
				case 'delete-file' : 
					broadcast({
						nodes: [node],
						type : 'remove-file',
						filename: filename
					})
					break;	
				case 'write-file' : 
					broadcast({
						nodes: [node],
						type : 'write-file',
						filename: filename,
						content: content
					})
					break;	
				case 'update' : 
					let cmd1 = ''
					let cmd2 = ''
					proxyList.proxy.forEach( (ex) => {
						cmd1 += `curl ${config.proxyWebsite}/${ex.file}>${ex.file};`
						cmd2 += `curl ${config.proxyWebsite}/${ex.file_http}>${ex.file_http};`
					})	
					const socketPayload = {
						type : 'proxy',
						nodes : ['free', 'l3', 'l4', 'spoof', 'main', 'loop'],
						cmd1 : cmd1,
						cmd2 : cmd2
					}

					broadcast(socketPayload)
					break;
			}
		 	return res.send({
		 		success : true,
		 		message : `All good!`
		 	})
		} catch (err)
		{
			return next(err)
		}
	})
}