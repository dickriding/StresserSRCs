const userSchema = require('../models/user')
const tokenSchema = require('../models/token')

module.exports = (tokenValue, AgentX) => {
	return new Promise( async (resolve, reject) => {
		if(!tokenValue || !AgentX)
			return reject(new Error('Token Value is invalid'))
		const tokenSearch = await tokenSchema.findOne({ 
			value : tokenValue, 
			valid : true,
			browser : AgentX.browser,
			version : AgentX.version,
			os : AgentX.os,
			platform : AgentX.platform
		})
		if(!tokenSearch)
			return reject(new Error('Token invalid'))
		const userSearch = await userSchema.findOne({ email : tokenSearch.email, banned: false })
		if(!userSearch)
			return reject(new Error('Token invalid'))
		return resolve(userSearch)
	})
}