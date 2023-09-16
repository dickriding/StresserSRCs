const checkUser = require('../../functions/checkUser')

const keySchema = require('../../models/key')
const axios = require('axios')

const yup = require('yup');

const generateString = require('../../functions/generateString')

const schema = yup.object().shape({
	Token: yup.string().length(64).required(),
	tokenValue: yup.string().length(12).required()
});

module.exports = app => {
	app.post('/payhub/redeem/:id', async (req, res, next) => {
		const {
			authorizationtoken: Token
		} = req.headers
		let { 
			tokenValue
		} = req.body
		try {
			await schema.validate({
				Token,
				tokenValue
			})
			
			const userFound = await checkUser(Token, req.useragent)
			const tokenFound = await keySchema.findOne({
				value : tokenValue,
				used : false
			})
			if(!tokenFound)
				return next(new Error('Token may be invalid or used.'))

			tokenFound.used = true;
			tokenFound.usedAt = new Date();
			tokenFound.usedBy = userFound.email;
			await tokenFound.save()

			const date = new Date()
			userFound.subbed = true;
			userFound.concurrent = tokenFound.maxConcurrent;
			userFound.maxBoots = tokenFound.maxBoots;
			userFound.maxTime = tokenFound.maxTime;
			userFound.api_access = tokenFound.api_access;
			userFound.loop = tokenFound.loop;
			userFound.api_key = generateString(18);
			userFound.subEnds = new Date(date.setMonth(date.getMonth()+tokenFound.duration))
			await userFound.save();

		 	return res.send({
		 		success : true,
		 		message : "Success!"
		 	})
		 	
		} catch (err)
		{
			return next(err)
		}
	})
}